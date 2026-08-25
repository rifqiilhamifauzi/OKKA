<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function home()
    {
        return Inertia::render('Public/Home');
    }

    public function about()
    {
        return Inertia::render('Public/About');
    }

    public function program()
    {
        return Inertia::render('Public/Program');
    }

    public function schedule()
    {
        return Inertia::render('Public/Schedule');
    }

    public function announcement()
    {
        $announcements = \App\Models\Announcement::where('is_published', true)
            ->where('visibility', 'global')
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('Public/Announcement', [
            'announcements' => $announcements
        ]);
    }

    public function documentation()
    {
        return Inertia::render('Public/Documentation');
    }

    public function faq()
    {
        return Inertia::render('Public/FAQ');
    }

    public function registrationInfo()
    {
        return Inertia::render('Public/RegistrationInfo');
    }
}
