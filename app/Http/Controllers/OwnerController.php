<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    public function showLogin()
    {
        return view('owner.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->role === 'owner' || $user->email === 'owner@dawsha.com') {
                    $request->session()->regenerate();
                    return response()->json([
                        'success' => true,
                        'message' => 'تم تسجيل الدخول بنجاح',
                        'redirect' => route('owner.dashboard')
                    ]);
                }
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'ليس لديك صلاحية الوصول إلى لوحة التحكم'
                ], 403);
            }

            return response()->json([
                'success' => false,
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تسجيل الدخول: ' . $e->getMessage()
            ], 500);
        }
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('owner.login');
        }
        return view('owner.dashboard');
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('owner.login');
        } catch (\Exception $e) {
            return redirect()->route('owner.login');
        }
    }
}
