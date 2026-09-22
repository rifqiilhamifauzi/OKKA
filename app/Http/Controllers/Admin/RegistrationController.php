<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Registration;
use App\Models\Event;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        $eventId = $request->query('event_id');

        $activeEvent = null;
        if ($eventId && $eventId !== 'all') {
            $activeEvent = $events->firstWhere('id', $eventId);
        }
        
        $query = Registration::with('user', 'detail', 'event');
        
        if ($activeEvent) {
            $query->where('event_id', $activeEvent->id);
        }

        // Searching
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('detail', function($q3) use ($search) {
                      $q3->where('identity_number', 'like', "%{$search}%");
                  });
            });
        }

        // Filtering
        if ($request->has('status') && $request->status != 'all' && $request->status != '') {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Registration/Index', [
            'registrations' => $registrations,
            'filters' => array_merge($request->only(['search', 'status']), ['event_id' => $eventId ?? 'all']),
            'events' => $events,
            'activeEvent' => $activeEvent,
        ]);
    }

    public function approvals(Request $request)
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        $eventId = $request->query('event_id');

        $activeEvent = null;
        if ($eventId && $eventId !== 'all') {
            $activeEvent = $events->firstWhere('id', $eventId);
        }
        
        // Filter by 'paid' as default for approvals, or allow 'pending'
        $status = $request->has('status') && $request->status != 'all' ? $request->status : null;
        
        $query = Registration::with('user', 'detail', 'event');
        
        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['pending', 'paid']);
        }
        
        if ($activeEvent) {
            $query->where('event_id', $activeEvent->id);
        }

        // Searching
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('detail', function($q3) use ($search) {
                      $q3->where('identity_number', 'like', "%{$search}%");
                  });
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Registration/Approvals', [
            'registrations' => $registrations,
            'filters' => array_merge($request->only(['search', 'status']), ['event_id' => $eventId ?? 'all']),
            'events' => $events,
            'activeEvent' => $activeEvent,
        ]);
    }

    public function show($id)
    {
        $registration = Registration::with('user', 'detail', 'event', 'payments')->findOrFail($id);

        return Inertia::render('Admin/Registration/Show', [
            'registration' => $registration,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,approved,rejected',
        ]);

        $registration = Registration::with('user', 'detail')->findOrFail($id);
        $registration->status = $request->status;
        $registration->save();

        \App\Models\ActivityLog::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Update Registration Status',
            'description' => 'Mengubah status pendaftaran ' . $registration->user->name . ' menjadi ' . $request->status,
        ]);

        if ($request->status === 'paid') {
            $registration->user->notify(new \App\Notifications\PaymentVerified($registration));
        } else {
            $registration->user->notify(new \App\Notifications\RegistrationStatusChanged($request->status, $registration));
        }
        
        // WhatsApp Notification
        if (in_array($request->status, ['approved', 'rejected'])) {
            $name = $registration->user->name;
            $phone = $registration->detail->phone ?? null;
            $dashboardLink = url('/dashboard');
            
            if ($phone) {
                if ($request->status === 'approved') {
                    $message = "OKKA — Pembayaran Berhasil Diverifikasi!\n\n"
                             . "Halo, {$name} 👋\n"
                             . "Pembayaran kamu untuk kegiatan OKKA 2026 telah berhasil diverifikasi oleh admin.\n\n"
                             . "✅ Status: TERVERIFIKASI\n\n"
                             . "Silahkan cek pendaftaranmu di {$dashboardLink}\n"
                             . "Terima kasih dan sampai bertemu di OKKA 2026! 🚀";
                } else {
                    $message = "OKKA — Verifikasi Pembayaran\n\n"
                             . "Halo, {$name} 👋\n"
                             . "Mohon maaf, pembayaran kamu belum dapat diverifikasi oleh admin.\n\n"
                             . "❌ Status: GAGAL\n\n"
                             . "Silakan lakukan pengecekan di {$dashboardLink} dan upload ulang bukti pembayaran melalui sistem pendaftaran OKKA 2026.\n\n"
                             . "Terima kasih 🙏";
                }
                
                \App\Services\WhatsAppService::sendMessage($phone, $message);
            }
        }

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $registration = Registration::with('user')->findOrFail($id);
        $name = $registration->user->name;
        $registration->delete();

        \App\Models\ActivityLog::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Delete Registration',
            'description' => 'Menghapus pendaftaran peserta: ' . $name,
        ]);

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
