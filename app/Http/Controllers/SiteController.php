<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Article;
use App\Models\OrganizationalUnit;
use App\Models\ContactSetting;
use App\Models\VolunteerContent;
use App\Models\MembershipApplication;
use App\Models\DonationMethod;
use App\Models\Slider;

class SiteController extends Controller
{
    public function home()
    {
        $sliders = \App\Models\Slider::where('is_published', true)->latest()->get();
        $programs = Program::where('is_published', true)->latest()->take(3)->get();
        $contact = ContactSetting::first();

        return view('site.pages.home', compact('sliders', 'programs', 'contact'));
    }

    public function programs()
    {
        $sliders = \App\Models\Slider::where('is_published', true)->latest()->get();
        $programs = Program::where('is_published', true)->latest()->get();
        $contact = ContactSetting::first();
        return view('site.pages.programs', compact('sliders', 'programs', 'contact'));
    }

    public function showProgram(Program $program)
    {
        if (!$program->is_published) {
            abort(404);
        }

        $contact = ContactSetting::first();
        return view('site.pages.program', compact('program', 'contact'));
    }

    public function volunteer()
    {
        $content = VolunteerContent::first();
        $donationMethods = DonationMethod::all();
        $contact = ContactSetting::first();
        return view('site.pages.volunteer', compact('content', 'donationMethods', 'contact'));
    }

    public function membership()
    {
        $contact = ContactSetting::first();
        return view('site.pages.membership', compact('contact'));
    }

    public function storeMembership(Request $request)
    {
        $validated = $request->validate([
            'full_name'            => 'required|string|max:255',
            'date_of_birth'        => 'nullable|date',
            'gender'               => 'nullable|in:male,female,other',
            'phone'                => 'required|string|max:30',
            'whatsapp'             => 'nullable|string|max:30',
            'email'                => 'required|email|max:255',
            'city'                 => 'required|string|max:100',
            'address'              => 'nullable|string|max:500',

            'qualification'        => 'nullable|string|max:255',
            'university'           => 'nullable|string|max:255',
            'graduation_year'      => 'nullable|string|max:10',
            'license_number'       => 'nullable|string|max:100',
            'current_workplace'    => 'nullable|string|max:255',
            'years_experience'     => 'nullable|string|max:50',
            'specialization'       => 'nullable|string|max:255',

            'membership_type'      => 'required|in:full_member,student_member,supporter',
            'reason'               => 'required|string|min:20',
            'contribution_areas'   => 'nullable|string|max:1000',
            'available_for_fieldwork' => 'nullable|boolean',
        ]);

        $validated['available_for_fieldwork'] = $request->boolean('available_for_fieldwork');

        MembershipApplication::create($validated);

        return redirect()->route('site.membership')
            ->with('success', __('site.membership.form_success'));
    }

    public function articles()
    {
        $articles = Article::where('is_published', true)->latest()->get();
        $contact = ContactSetting::first();
        return view('site.pages.articles', compact('articles', 'contact'));
    }

    public function showArticle(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        $contact = ContactSetting::first();
        return view('site.pages.article', compact('article', 'contact'));
    }

    public function org()
    {
        $units = OrganizationalUnit::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
        $contact = ContactSetting::first();
        return view('site.pages.org', compact('units', 'contact'));
    }

    public function contact()
    {
        $contact = ContactSetting::first();
        return view('site.pages.contact', compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
