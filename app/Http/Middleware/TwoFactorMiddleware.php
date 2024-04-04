<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(auth()->user()->id);

        if (auth()->check() && $user->two_factor_code) {
            if ($user->two_factor_expires_at < Carbon::now()) {
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')
                    ->withStatus('Your verification code expired. Please re-login.');
            }
            if (! $request->is('verify*')) {
                return redirect()->route('verify.index');
            }
        }

        return $next($request);
    }
}
