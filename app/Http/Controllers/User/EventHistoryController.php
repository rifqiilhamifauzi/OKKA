<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class EventHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch all registrations for this user where status is approved
        // and the related event status is completed.
        $historyRegistrations = Registration::with('event')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereHas('event', function ($query) {
                $query->where('status', 'completed')
                      ->orWhere(function($q) {
                          $q->where('status', 'active')
                            ->whereDate('end_date', '<', now()->toDateString());
                      });
            })
            ->get();
            
        $announcements = Announcement::where('is_published', true)
            ->where(function($q) {
                $q->where('visibility', 'global')
                  ->orWhere('visibility', 'participants');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('User/History/Index', [
            'historyRegistrations' => $historyRegistrations,
            'announcements' => $announcements,
        ]);
    }
}
