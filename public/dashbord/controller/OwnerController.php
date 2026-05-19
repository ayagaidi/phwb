<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function showLogin()
    {
        return view('dashbord.view.login');
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
                if (isset($user->role) && $user->role === 'owner') {
                    $request->session()->regenerate();
                    return response()->json([
                        'success' => true,
                        'message' => 'تم تسجيل الدخول بنجاح',
                        'redirect' => route('admin.dashboard')
                    ]);
                }
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'ليس لديك صلاحية الوصول'], 403);
            }

            return response()->json(['success' => false, 'message' => 'بيانات الدخول غير صحيحة'], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }
        return view('dashbord.view.dashboard');
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            return redirect()->route('admin.login');
        }
    }
}
