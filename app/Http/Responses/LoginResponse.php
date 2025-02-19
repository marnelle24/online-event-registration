<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return redirect()->intended(route('user.dashboard'));
    }
} 