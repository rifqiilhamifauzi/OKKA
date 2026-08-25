<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->orderBy('created_at', 'desc')->get();
        return Inertia::render('Admin/Event/Index', [
            'events' => $events
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $slug = Str::slug($request->name);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while(Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $event = Event::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'registration_fee' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'draft', // By default draft
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Create Event',
            'description' => 'Membuat event baru: ' . $event->name,
        ]);

        return redirect()->back()->with('success', 'Event berhasil dibuat.');
    }

    public function updateStatus(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:draft,active,completed'
        ]);

        $event->update(['status' => $request->status]);

        \App\Models\ActivityLog::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Update Event Status',
            'description' => 'Mengubah status event "' . $event->name . '" menjadi ' . $request->status,
        ]);

        return redirect()->back()->with('success', 'Status event berhasil diperbarui.');
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $slug = $event->slug;
        if ($event->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            while(Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $event->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'registration_fee' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Update Event',
            'description' => 'Memperbarui data event: ' . $event->name,
        ]);

        return redirect()->back()->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // Pastikan tidak ada registrasi yang terkait sebelum menghapus (opsional, tergantung logic bisnis)
        if ($event->registrations()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Tidak dapat menghapus event karena sudah ada pendaftar.']);
        }

        $eventName = $event->name;
        $event->delete();

        \App\Models\ActivityLog::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Delete Event',
            'description' => 'Menghapus event: ' . $eventName,
        ]);

        return redirect()->back()->with('success', 'Event berhasil dihapus.');
    }
}
