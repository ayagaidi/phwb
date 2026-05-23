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
                        'message' => __('admin.login_success'),
                        'redirect' => route('admin.dashboard')
                    ]);
                }
                Auth::logout();
                return response()->json(['success' => false, 'message' => __('admin.no_permission')], 403);
            }

            return response()->json(['success' => false, 'message' => __('admin.invalid_credentials')], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.connection_error') . ': ' . $e->getMessage()
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

        return redirect()->route('admin.users')->with('success', __('admin.user_added'));
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
        return redirect()->route('admin.users')->with('success', __('admin.user_updated'));
    }

    public function toggleUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.users')->with('success', __('admin.user_toggled'));
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
            'title_en' => 'nullable',
            'description' => 'required',
            'description_en' => 'nullable',
            'image' => 'nullable|image',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $data['is_published'] = false;
        \App\Models\Program::create($data);

        return redirect()->route('admin.programs')->with('success', __('admin.programs.added'));
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
            'title_en' => 'nullable',
            'description' => 'required',
            'description_en' => 'nullable',
            'image' => 'nullable|image',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($data);
        return redirect()->route('admin.programs')->with('success', __('admin.programs.updated'));
    }

    public function toggleProgram($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        $program->is_published = !$program->is_published;
        $program->save();
        return redirect()->route('admin.programs')->with('success', __('admin.programs.toggled'));
    }

    public function destroyProgram($id)
    {
        \App\Models\Program::findOrFail($id)->delete();
        return redirect()->route('admin.programs')->with('success', __('admin.programs.deleted'));
    }

    public function deleteProgramImage($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        if ($program->image) {
            \Storage::disk('public')->delete($program->image);
            $program->image = null;
            $program->save();
        }
        return redirect()->back()->with('success', __('admin.programs.image_deleted'));
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

    public function volunteerContent()
    {
        $content = \App\Models\VolunteerContent::firstOrCreate([]);
        return view('dashbord.volunteer-content', compact('content'));
    }

    public function updateVolunteerContent(Request $request)
    {
        $content = \App\Models\VolunteerContent::firstOrCreate([]);

        $data = $request->validate([
            'hero_title' => 'nullable|string',
            'hero_title_en' => 'nullable|string',
            'hero_desc' => 'nullable|string',
            'hero_desc_en' => 'nullable|string',
            'opportunities' => 'nullable|string',
            'opportunities_en' => 'nullable|string',
            'banner_image' => 'nullable|image',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($content->banner_image) {
                \Storage::disk('public')->delete($content->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('volunteer', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.volunteer-content')->with('success', __('admin.volunteer.updated'));
    }

    // Articles
    public function articles()
    {
        try {
            $articles = \App\Models\Article::latest()->get();
        } catch (\Exception $e) {
            $articles = collect(); // empty if table not migrated yet
        }
        return view('dashbord.articles.index', compact('articles'));
    }

    public function createArticle()
    {
        return view('dashbord.articles.create');
    }

    public function storeArticle(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'title_en' => 'nullable',
            'content' => 'required',
            'content_en' => 'nullable',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $data['is_published'] = false;
        \App\Models\Article::create($data);

        return redirect()->route('admin.articles')->with('success', __('admin.articles.added'));
    }

    public function editArticle($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('dashbord.articles.edit', compact('article'));
    }

    public function updateArticle(Request $request, $id)
    {
        $article = \App\Models\Article::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'title_en' => 'nullable',
            'content' => 'required',
            'content_en' => 'nullable',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);
        return redirect()->route('admin.articles')->with('success', __('admin.articles.updated'));
    }

    public function toggleArticle($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        $article->is_published = !$article->is_published;
        $article->save();
        return redirect()->route('admin.articles')->with('success', __('admin.articles.toggled'));
    }

    public function destroyArticle($id)
    {
        \App\Models\Article::destroy($id);
        return redirect()->route('admin.articles')->with('success', __('admin.articles.deleted'));
    }

    // Donation Methods
    public function donationMethods()
    {
        $methods = \App\Models\DonationMethod::latest()->get();
        return view('dashbord.donation-methods.index', compact('methods'));
    }

    public function createDonationMethod()
    {
        return view('dashbord.donation-methods.create');
    }

    public function storeDonationMethod(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'name_en' => 'nullable',
            'description' => 'required',
            'description_en' => 'nullable',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('donation-methods', 'public');
        }

        \App\Models\DonationMethod::create($data);
        return redirect()->route('admin.donation-methods')->with('success', __('admin.donation_methods.added'));
    }

    public function destroyDonationMethod($id)
    {
        \App\Models\DonationMethod::destroy($id);
        return redirect()->route('admin.donation-methods')->with('success', __('admin.donation_methods.deleted'));
    }

    // Organizational Structure
    public function orgStructure()
    {
        $units = \App\Models\OrganizationalUnit::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('dashbord.org-structure.index', compact('units'));
    }

    public function createOrgUnit()
    {
        $parents = \App\Models\OrganizationalUnit::orderBy('name')->get();
        return view('dashbord.org-structure.create', compact('parents'));
    }

    public function storeOrgUnit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'name_en' => 'nullable',
            'title' => 'nullable',
            'title_en' => 'nullable',
            'photo' => 'nullable|image',
            'parent_id' => 'nullable|exists:organizational_units,id',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('org-structure', 'public');
        }

        \App\Models\OrganizationalUnit::create($data);

        return redirect()->route('admin.org-structure')->with('success', __('admin.org_structure.added'));
    }

    public function editOrgUnit($id)
    {
        $unit = \App\Models\OrganizationalUnit::findOrFail($id);
        $parents = \App\Models\OrganizationalUnit::where('id', '!=', $id)->orderBy('name')->get();
        return view('dashbord.org-structure.edit', compact('unit', 'parents'));
    }

    public function updateOrgUnit(Request $request, $id)
    {
        $unit = \App\Models\OrganizationalUnit::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'name_en' => 'nullable',
            'title' => 'nullable',
            'title_en' => 'nullable',
            'photo' => 'nullable|image',
            'parent_id' => 'nullable|exists:organizational_units,id',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($unit->photo) {
                \Storage::disk('public')->delete($unit->photo);
            }
            $data['photo'] = $request->file('photo')->store('org-structure', 'public');
        }

        $unit->update($data);

        return redirect()->route('admin.org-structure')->with('success', __('admin.org_structure.updated'));
    }

    public function destroyOrgUnit($id)
    {
        \App\Models\OrganizationalUnit::destroy($id);
        return redirect()->route('admin.org-structure')->with('success', __('admin.org_structure.deleted'));
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
