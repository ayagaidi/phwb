<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_programs' => \App\Models\Program::count(),
            'total_articles' => \App\Models\Article::count(),
            'pending_memberships' => \App\Models\MembershipApplication::where('status', 'pending')->orWhereNull('status')->count(),
        ];

        $recentApplications = \App\Models\MembershipApplication::latest()->take(5)->get();

        // Chart data
        $membershipByType = \App\Models\MembershipApplication::selectRaw('membership_type, COUNT(*) as count')
            ->groupBy('membership_type')
            ->pluck('count', 'membership_type');

        // Last 6 months applications
        $monthlyApps = \App\Models\MembershipApplication::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('dashbord.dashboard', compact('stats', 'recentApplications', 'membershipByType', 'monthlyApps'));
    }

    public function users()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }
        $users = \App\Models\User::where('id','!=',1)->latest()->get();
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

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff',
            'password' => 'nullable|min:6|confirmed',
        ];

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        $message = $request->filled('password') 
            ? __('admin.password_changed') 
            : __('admin.user_updated');

        return redirect()->route('admin.users')->with('success', $message);
    }

    public function toggleUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.users')->with('success', __('admin.user_toggled'));
    }

    // Sliders
    public function sliders()
    {
        $sliders = \App\Models\Slider::latest()->get();
        return view('dashbord.sliders.index', compact('sliders'));
    }

    public function createSlider()
    {
        return view('dashbord.sliders.create');
    }

    public function storeSlider(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $data['is_published'] = false;
        \App\Models\Slider::create($data);

        return redirect()->route('admin.sliders')->with('success', __('admin.sliders.added'));
    }

    public function editSlider($id)
    {
        $slider = \App\Models\Slider::findOrFail($id);
        return view('dashbord.sliders.edit', compact('slider'));
    }

    public function updateSlider(Request $request, $id)
    {
        $slider = \App\Models\Slider::findOrFail($id);
        $data = $request->validate([
            'image' => 'nullable|image',
            'remove_image' => 'nullable|string',
        ]);

        $currentImage = $slider->image;

        if ($request->filled('remove_image') && $request->remove_image === $currentImage) {
            \Storage::disk('public')->delete($currentImage);
            $currentImage = null;
        }

        if ($request->hasFile('image')) {
            if ($currentImage) {
                \Storage::disk('public')->delete($currentImage);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        } elseif ($currentImage) {
            $data['image'] = $currentImage;
        }

        $slider->update($data);
        return redirect()->route('admin.sliders')->with('success', __('admin.sliders.updated'));
    }

    public function toggleSlider($id)
    {
        $slider = \App\Models\Slider::findOrFail($id);
        $slider->is_published = !$slider->is_published;
        $slider->save();
        return redirect()->route('admin.sliders')->with('success', __('admin.sliders.toggled'));
    }

    public function destroySlider($id)
    {
        $slider = \App\Models\Slider::findOrFail($id);
        if ($slider->image) {
            \Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('admin.sliders')->with('success', __('admin.sliders.deleted'));
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
            'remove_image' => 'nullable|string',
        ]);

        $currentImage = $program->image;

        // Handle explicit removal of current image
        if ($request->filled('remove_image') && $request->remove_image === $currentImage) {
            Storage::disk('public')->delete($currentImage);
            $currentImage = null;
        }

        if ($request->hasFile('image')) {
            // Replace: delete old if exists
            if ($currentImage) {
                Storage::disk('public')->delete($currentImage);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        } elseif ($currentImage) {
            $data['image'] = $currentImage;
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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('articles', 'public');
            }
        }

        $data['images'] = $imagePaths;
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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
        ]);

        $currentImages = $article->images ?? [];

        // Remove selected images (actual deletion from storage + DB array)
        $removeImages = $request->input('remove_images', []);
        if (!empty($removeImages)) {
            foreach ($removeImages as $imgToRemove) {
                if (($key = array_search($imgToRemove, $currentImages)) !== false) {
                    Storage::disk('public')->delete($imgToRemove);
                    unset($currentImages[$key]);
                }
            }
            $currentImages = array_values($currentImages);
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $currentImages[] = $file->store('articles', 'public');
            }
        }

        $data['images'] = $currentImages;

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

    public function editDonationMethod($id)
    {
        $method = \App\Models\DonationMethod::findOrFail($id);
        return view('dashbord.donation-methods.edit', compact('method'));
    }

    public function updateDonationMethod(Request $request, $id)
    {
        $method = \App\Models\DonationMethod::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'name_en' => 'nullable',
            'description' => 'required',
            'description_en' => 'nullable',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            if ($method->image) {
                \Storage::disk('public')->delete($method->image);
            }
            $data['image'] = $request->file('image')->store('donation-methods', 'public');
        }

        $method->update($data);
        return redirect()->route('admin.donation-methods')->with('success', __('admin.donation_methods.updated'));
    }

    public function destroyDonationMethod($id)
    {
        \App\Models\DonationMethod::destroy($id);
        return redirect()->route('admin.donation-methods')->with('success', __('admin.donation_methods.deleted'));
    }

    // Membership Applications
    public function membershipApplications()
    {
        $query = \App\Models\MembershipApplication::query();

        $status = request('status');
        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $applications = $query->latest()->get();

        // Always get all for the stats cards
        $allApplications = \App\Models\MembershipApplication::all();

        return view('dashbord.membership-applications.index', compact('applications', 'allApplications', 'status'));
    }

    public function showMembershipApplication($id)
    {
        $application = \App\Models\MembershipApplication::findOrFail($id);
        return view('dashbord.membership-applications.show', compact('application'));
    }

    public function updateMembershipApplication(Request $request, $id)
    {
        $application = \App\Models\MembershipApplication::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $application->update($validated);

        return redirect()->route('admin.membership-applications.show', $application->id)
            ->with('success', __('admin.membership_applications.updated_success'));
    }

    public function markMembershipAsRead($id)
    {
        $application = \App\Models\MembershipApplication::findOrFail($id);
        if (is_null($application->read_at)) {
            $application->read_at = now();
            $application->save();
        }

        return back();
    }

    public function markAllMembershipAsRead()
    {
        \App\Models\MembershipApplication::whereNull('read_at')
            ->where(function($q) {
                $q->whereNull('status')->orWhere('status', 'pending');
            })
            ->update(['read_at' => now()]);

        return back();
    }

    public function exportMembershipApplications()
    {
        $query = \App\Models\MembershipApplication::query();

        if ($status = request('status')) {
            if (in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }
        }

        $applications = $query->latest()->get();

        $filename = "طلبات-العضوية-" . now()->format('Y-m-d') . ".xls";

        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // UTF-8 BOM for Arabic support in Excel
        echo "\xEF\xBB\xBF";

        // CSV Headers (Arabic)
        echo "الاسم الكامل,البريد الإلكتروني,رقم الهاتف,الواتساب,المدينة,نوع العضوية,الحالة,تاريخ التقديم,ملاحظات\n";

        foreach ($applications as $app) {
            $row = [
                $app->full_name,
                $app->email,
                $app->phone,
                $app->whatsapp ?? '',
                $app->city,
                $app->membership_type,
                $app->status ?? 'pending',
                $app->created_at->format('Y-m-d H:i'),
                str_replace(["\n", "\r"], ' ', $app->admin_notes ?? '')
            ];

            echo '"' . implode('","', array_map(fn($v) => str_replace('"', '""', $v), $row)) . '"' . "\n";
        }

        exit;
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
            'remove_photo' => 'nullable|string',
        ]);

        $currentPhoto = $unit->photo;

        // Handle explicit removal of current photo
        if ($request->filled('remove_photo') && $request->remove_photo === $currentPhoto) {
            \Storage::disk('public')->delete($currentPhoto);
            $currentPhoto = null;
        }

        if ($request->hasFile('photo')) {
            // Replace: delete old if exists
            if ($currentPhoto) {
                \Storage::disk('public')->delete($currentPhoto);
            }
            $data['photo'] = $request->file('photo')->store('org-structure', 'public');
        } elseif ($currentPhoto) {
            $data['photo'] = $currentPhoto;
        }

        $unit->update($data);

        return redirect()->route('admin.org-structure')->with('success', __('admin.org_structure.updated'));
    }

    public function destroyOrgUnit($id)
    {
        \App\Models\OrganizationalUnit::destroy($id);
        return redirect()->route('admin.org-structure')->with('success', __('admin.org_structure.deleted'));
    }

    // Contact Settings
    public function contactSettings()
    {
        $contact = \App\Models\ContactSetting::firstOrCreate([]);
        return view('dashbord.contact-settings', compact('contact'));
    }

    public function updateContactSettings(Request $request)
    {
        $contact = \App\Models\ContactSetting::firstOrCreate([]);

        $data = $request->validate([
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address_ar' => 'nullable|string',
            'address_en' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'working_hours_ar' => 'nullable|string',
            'working_hours_en' => 'nullable|string',
        ]);

        $contact->update($data);

        return redirect()->route('admin.contact-settings')->with('success', __('admin.contact_settings.updated'));
    }

    // Profile
    public function profile()
    {
        $user = Auth::user();
        return view('dashbord.profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('admin.profile.current_password_incorrect')]);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('admin.profile')->with('success', __('admin.profile.password_changed'));
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
