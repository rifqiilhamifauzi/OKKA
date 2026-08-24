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
        $activeEvent = Event::where('status', 'active')->orderBy('created_at', 'desc')->first();
        
        $query = Registration::with('user', 'detail')
            ->when($activeEvent, function($q) use ($activeEvent) {
                return $q->where('event_id', $activeEvent->id);
            });

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
            'filters' => $request->only(['search', 'status']),
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

        $registration = Registration::findOrFail($id);
        $registration->status = $request->status;
        $registration->save();

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
