<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
            Log::info('Google login attempt with email: ' . $email);

            // Check if email is from pcr.ac.id or mahasiswa.pcr.ac.id domain
            if (!str_ends_with($email, '@pcr.ac.id') && !str_ends_with($email, '@mahasiswa.pcr.ac.id')) {
                Log::warning('Google login rejected for email: ' . $email);
                return redirect('/login')->withErrors(['email' => 'Hanya email kampus PCR (@pcr.ac.id atau @mahasiswa.pcr.ac.id) yang diizinkan.']);
            }

            $user = User::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => 'tamu', // default role
                ]);
            }

            Auth::login($user);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Gagal login dengan Google.']);
        }
    }
}
