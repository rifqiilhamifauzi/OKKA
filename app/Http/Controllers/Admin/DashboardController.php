<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        $eventId = $request->query('event_id');

        $activeEvent = null;
        if ($eventId && $eventId !== 'all') {
            $activeEvent = $events->firstWhere('id', $eventId);
        }

        $metrics = [
            'total' => 0,
            'pending' => 0,
            'paid' => 0,
            'approved' => 0,
        ];

        $query = Registration::with('user', 'detail', 'event');
        
        if ($activeEvent) {
            $query->where('event_id', $activeEvent->id);
        }

        $allRegistrations = $query->get();
        
        $metrics['total'] = $allRegistrations->count();
        $metrics['pending'] = $allRegistrations->where('status', 'pending')->count();
        $metrics['paid'] = $allRegistrations->where('status', 'paid')->count();
        $metrics['approved'] = $allRegistrations->where('status', 'approved')->count();

        $recentRegistrations = Registration::with('user', 'detail', 'event')
            ->when($activeEvent, function($q) use ($activeEvent) {
                return $q->where('event_id', $activeEvent->id);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'events' => $events,
            'activeEvent' => $activeEvent,
            'metrics' => $metrics,
            'recentRegistrations' => $recentRegistrations,
            'filters' => ['event_id' => $eventId ?? 'all'],
        ]);
    }
}
