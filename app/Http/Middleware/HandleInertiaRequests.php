<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'announcements' => function () use ($request) {
                $user = $request->user();
                if (!$user || $user->role !== 'user') return [];
                
                $isParticipant = $user->registrations()->where('status', 'approved')->exists();
                
                $query = \App\Models\Announcement::where('is_published', true)->orderBy('created_at', 'desc');
                
                if ($isParticipant) {
                    $query->whereIn('visibility', ['global', 'participants']);
                } else {
                    $query->where('visibility', 'global');
                }
                
                return $query->get();
            },
            'errors' => function () use ($request) {
                return $request->session()->get('errors')
                    ? $request->session()->get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ];
    }
}
