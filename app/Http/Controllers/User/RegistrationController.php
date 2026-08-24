<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Registration;
use App\Models\RegistrationDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function create(Request $request)
    {
        $eventId = $request->query('event_id');
        if (!$eventId) {
            return redirect()->route('user.dashboard')->withErrors(['error' => 'Pilih event terlebih dahulu.']);
        }

        $activeEvent = Event::where('id', $eventId)->where('status', 'active')->first();
        if (!$activeEvent) {
            return redirect()->route('user.dashboard')->withErrors(['error' => 'Event tidak ditemukan atau tidak aktif.']);
        }

        $user = Auth::user();
        $existingRegistration = $user->registrations()->where('event_id', $activeEvent->id)->first();

        if ($existingRegistration) {
            return redirect()->route('user.dashboard')->with('message', 'Anda sudah mendaftar untuk event ini.');
        }

        return Inertia::render('User/Registration/Create', [
            'activeEvent' => $activeEvent,
            'user' => clone $user,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'full_name' => 'required|string|max:255',
            'identity_number' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'scout_status' => 'required|boolean',
        ]);

        $activeEvent = Event::where('id', $request->event_id)->where('status', 'active')->firstOrFail();
        $user = Auth::user();

        // Cek apakah sudah daftar
        if ($user->registrations()->where('event_id', $activeEvent->id)->exists()) {
            return redirect()->route('user.dashboard')->withErrors(['error' => 'Anda sudah mendaftar pada event ini.']);
        }

        DB::beginTransaction();
        try {
            // Update User's full name
            $user->update(['name' => $request->full_name]);

            // Generate Registration Number
            $regNumber = 'OKKA' . date('y') . strtoupper(Str::random(6));

            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $activeEvent->id,
                'registration_number' => $regNumber,
                'status' => 'pending',
            ]);

            RegistrationDetail::create([
                'registration_id' => $registration->id,
                'identity_number' => $request->identity_number,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'scout_status' => $request->scout_status,
            ]);

            DB::commit();

            return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data pendaftaran.']);
        }
    }

    public function uploadPayment(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        
        $registration = $user->registrations()->where('event_id', $request->event_id)->firstOrFail();

        if ($registration->status !== 'pending') {
            return back()->withErrors(['error' => 'Status pendaftaran tidak valid untuk unggah pembayaran.']);
        }

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            $registration->update([
                'payment_proof' => $path,
                'status' => 'paid'
            ]);
            
            return redirect()->route('user.dashboard')->with('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi admin.');
        }

        return back()->withErrors(['error' => 'Gagal mengunggah file.']);
    }
}
