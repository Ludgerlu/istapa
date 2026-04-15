<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find user by email or username
        $user = User::where('user_email', $request->login)
                    ->orWhere('user_login', $request->login)
                    ->first();

        if ($user && Hash::check($request->password, $user->user_pass)) {
            Auth::login($user, $request->remember);
            
            // Log the login
            $this->logLogin($user);
            
            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isTeacher()) {
                return redirect()->route('teacher.dashboard');
            } elseif ($user->isStudent()) {
                return redirect()->route('student.dashboard');
            }
            
            return redirect()->route('home');
        }

        return back()->withErrors([
            'login' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    protected function logLogin($user)
    {
        \App\Models\UserLog::create([
            'user_login' => $user->user_login,
            'role' => $user->getRole(),
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'date_time' => now(),
            'deleted_status' => 0
        ]);
    }

   public function profile()
    {
        // Get authenticated user
        $user = Auth::user();

        // dd($user);
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }
        // return redirect()->intended($this->getUserDashboardRoute($user->type));

        return view('profile.profil', [
            'user' => $user,
            'userType' => $user->usertype,
            'link' => $this->getUserDashboardRoute($user->usertype),
        ]);
    }

     public function defaultPassword(Request $request)
    {
        $user = Auth::user();
        // Update password
        $user->cryptedpwd = Hash::make('password');
        $user->save();
        return back()->with('success', 'Mot de passe modifié avec succès!'. Hash::make('password'));
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        // Validation rules
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        ], [
            'new_password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.'
        ]);
        // Check current password
        if (!Hash::check($request->current_password, $user->cryptedpwd)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
        }
        // Update password
        $user->cryptedpwd = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', 'Mot de passe modifié avec succès!');
    }

        public function showChangePasswordForm()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.password', [
            'user' => $user,
            'userType' => $user->type,
        ]);
    }


}
