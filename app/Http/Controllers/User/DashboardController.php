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

        return Inertia::render('User/Dashboard', [
            'activeEvents' => $activeEvents,
            'registrations' => $registrations
        ]);
    }
}
