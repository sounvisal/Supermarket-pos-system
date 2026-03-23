<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'password' => 'required',
            'role' => 'required|in:cashier,manager,stock'
        ]);

        $credentials = [
            'employee_id' => $request->employee_id,
            'password' => $request->password,
        ];

        // Attempt to log in
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Cast role to string to ensure comparison works correctly
            $userRole = (string) $user->role;
            $selectedRole = (string) $request->role;
            
            // Check if the user has the selected role
            if ($userRole !== $selectedRole) {
                Auth::logout();
                return back()->withErrors([
                    'role' => 'You do not have access to this role.'
                ])->withInput($request->except('password'));
            }
            
            $request->session()->regenerate();
            
            // Redirect based on role
            switch ($userRole) {
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

        return back()->withErrors([
            'employee_id' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 