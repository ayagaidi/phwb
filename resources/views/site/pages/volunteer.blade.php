@extends('site.layouts.app')

@section('title', __('site.volunteer.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<div class="max-w-4xl mx-auto px-6 py-16 text-center">
    <h1 class="text-4xl font-bold mb-4">{{ __('site.volunteer.title') }}</h1>
    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        {{ app()->getLocale() === 'en' && $content->hero_desc_en ? $content->hero_desc_en : ($content->hero_desc ?? __('site.volunteer.subtitle')) }}
    </p>

    <div class="mt-10 bg-white p-8 rounded-3xl border max-w-xl mx-auto text-right">
        <h3 class="font-semibold mb-4 text-lg">{{ __('site.volunteer.opportunities_title') }}</h3>
        <div class="whitespace-pre-line text-gray-700">
            {{ app()->getLocale() === 'en' && $content->opportunities_en ? $content->opportunities_en : ($content->opportunities ?? '') }}
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('site.contact') }}" 
           class="inline-block bg-[#1e3a8a] hover:bg-[#1e40af] text-white px-10 py-4 rounded-3xl font-semibold text-lg">
            {{ __('site.volunteer.contact_button') }}
        </a>
    </div>
</div>
@endsection
