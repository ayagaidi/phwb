<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('dashbord.login');
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
        return view('dashbord.dashboard');
    }

    public function users()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }
        $users = \App\Models\User::all();
        return view('dashbord.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('dashbord.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'staff',
        ]);

        return redirect()->route('admin.users')->with('success', 'تمت إضافة المستخدم بنجاح');
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('dashbord.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->update($request->only('name', 'email', 'role'));
        return redirect()->route('admin.users')->with('success', 'تم التعديل بنجاح');
    }

    public function toggleUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.users');
    }

    // Programs
    public function programs()
    {
        $programs = \App\Models\Program::latest()->get();
        return view('dashbord.programs.index', compact('programs'));
    }

    public function createProgram()
    {
        return view('dashbord.programs.create');
    }

    public function storeProgram(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $data['is_published'] = false;
        \App\Models\Program::create($data);

        return redirect()->route('admin.programs')->with('success', 'تمت إضافة البرنامج');
    }

    public function editProgram($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        return view('dashbord.programs.edit', compact('program'));
    }

    public function updateProgram(Request $request, $id)
    {
        $program = \App\Models\Program::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($data);
        return redirect()->route('admin.programs');
    }

    public function toggleProgram($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        $program->is_published = !$program->is_published;
        $program->save();
        return redirect()->route('admin.programs');
    }

    public function destroyProgram($id)
    {
        \App\Models\Program::findOrFail($id)->delete();
        return redirect()->route('admin.programs');
    }

    public function deleteProgramImage($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        if ($program->image) {
            \Storage::disk('public')->delete($program->image);
            $program->image = null;
            $program->save();
        }
        return redirect()->back();
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
