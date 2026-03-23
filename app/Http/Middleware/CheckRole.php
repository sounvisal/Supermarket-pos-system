<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();
        
        // Convert $roles to an array and check if the user's role is one of them
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // If user doesn't have any of the required roles, redirect based on their actual role
        switch ($user->role) {
            case 'cashier':
                return redirect('/home/charge');
            case 'stock':
                return redirect('/master/product');
            case 'manager':
                return redirect('/master/dashboard');
            default:
                return redirect('/');
        }
    }
} 