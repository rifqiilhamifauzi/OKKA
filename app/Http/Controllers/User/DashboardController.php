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
        
        // Fetch ALL active events
        $activeEvents = Event::where('status', 'active')->get();
        
        // Fetch registrations for this user for active events
        $registrations = Registration::where('user_id', $user->id)
                                 ->whereIn('event_id', $activeEvents->pluck('id'))
                                 ->get()
                                 ->keyBy('event_id');

        // Fetch announcements
        $isParticipant = $user->registrations()->where('status', 'approved')->exists();
        
        $announcementsQuery = Announcement::where('is_published', true)->orderBy('created_at', 'desc');
        
        if ($isParticipant) {
            // Can see both global and participants announcements
            $announcementsQuery->whereIn('visibility', ['global', 'participants']);
        } else {
            // Can only see global announcements
            $announcementsQuery->where('visibility', 'global');
        }
        
        $announcements = $announcementsQuery->get();

        return Inertia::render('User/Dashboard', [
            'activeEvents' => $activeEvents,
            'registrations' => $registrations,
            'announcements' => $announcements
        ]);
    }
}
