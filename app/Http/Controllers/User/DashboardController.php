<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $userRegistrations = Registration::where('user_id', $user->id)->get();
        $registeredEventIds = $userRegistrations->pluck('event_id');

        // Fetch ALL active events that are either still open OR the user has already registered
        $activeEvents = Event::where('status', 'active')
            ->where(function($query) use ($registeredEventIds) {
                $query->whereDate('end_date', '>=', now()->toDateString())
                      ->orWhereIn('id', $registeredEventIds);
            })->get();
        
        // Fetch registrations for this user for the displayed events
        $registrations = $userRegistrations->whereIn('event_id', $activeEvents->pluck('id'))->keyBy('event_id');

        $announcements = Announcement::where('is_published', true)
            ->where(function($q) {
                $q->where('visibility', 'global')
                  ->orWhere('visibility', 'participants');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('User/Dashboard', [
            'activeEvents' => $activeEvents,
            'registrations' => $registrations,
            'announcements' => $announcements,
        ]);
    }
}
