<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            $isNewUser = false;

            if ($user) {
                // Update existing user with google id/avatar if they registered manually previously
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => null,
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]);
                $isNewUser = true;
            }

            Auth::login($user, true);

            if ($isNewUser) {
                return redirect()->route('user.dashboard');
            }

            // Redirect back to intended page or dashboard
            return redirect()->intended(route('user.dashboard'));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google login failed: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return redirect()->route('login')->withErrors(['error' => 'Gagal login menggunakan Google. Silakan coba lagi.']);
        }
    }

    /**
     * Bypass authentication for local development.
     */
    public function bypass(Request $request)
    {
        if (!app()->environment('local')) {
            abort(403, 'Bypass is only allowed in local environment.');
        }

        $role = $request->query('role', 'user');

        if ($role === 'admin') {
            $user = User::updateOrCreate(
                ['email' => 'admin@okka.ac.id'],
                [
                    'name' => 'Administrator OKKA (Bypass)',
                    'google_id' => 'admin_dummy_id',
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]
            );
            Auth::login($user, true);
            return redirect()->route('admin.dashboard');
        } else {
            $user = User::updateOrCreate(
                ['email' => 'student@okka.ac.id'],
                [
                    'name' => 'Mahasiswa Dummy (Bypass)',
                    'google_id' => 'student_dummy_id',
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );
            Auth::login($user, true);
            return redirect()->route('user.dashboard');
        }
    }
}
