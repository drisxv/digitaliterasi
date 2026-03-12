<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that requires the user to log in after registration.
     */
    public function toResponse($request): RedirectResponse
    {
        Auth::guard(config('fortify.guard'))->logout();

        if ($request instanceof Request && $request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('status', 'Registrasi berhasil. Silakan login dengan username Anda.');
    }
}
