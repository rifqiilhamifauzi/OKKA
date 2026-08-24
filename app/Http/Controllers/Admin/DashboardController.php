<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        $activeEvent = Event::where('status', 'active')->orderBy('created_at', 'desc')->first();
        
        $metrics = [
            'total' => 0,
            'pending' => 0,
            'paid' => 0,
            'approved' => 0,
        ];

        $recentRegistrations = collect([]);

        if ($activeEvent) {
            $registrations = Registration::where('event_id', $activeEvent->id)->get();
            
            $metrics['total'] = $registrations->count();
            $metrics['pending'] = $registrations->where('status', 'pending')->count();
            $metrics['paid'] = $registrations->where('status', 'paid')->count();
            $metrics['approved'] = $registrations->where('status', 'approved')->count();

            $recentRegistrations = Registration::with('user', 'detail')
                ->where('event_id', $activeEvent->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return Inertia::render('Admin/Dashboard', [
            'activeEvent' => $activeEvent,
            'metrics' => $metrics,
            'recentRegistrations' => $recentRegistrations,
        ]);
    }
}
