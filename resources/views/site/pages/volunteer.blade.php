@extends('site.layouts.app')

@section('title', __('site.volunteer.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<!-- Hero -->
<div class="bg-gradient-to-b from-[#29225c] to-[#372d70] text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-x-2 bg-white/10 px-4 py-1 rounded-full text-sm mb-4">
            <i class="fas fa-hands-helping"></i>
            <span>{{ __('site.volunteer.hero_badge') }}</span>
        </div>

        @php
            $heroTitle = app()->getLocale() === 'en' && $content && $content->hero_title_en 
                ? $content->hero_title_en 
                : ($content->hero_title ?? __('site.volunteer.title'));
        @endphp

        <h1 class="text-5xl font-bold tracking-tight">{{ $heroTitle }}</h1>

        @php
            $rawSub = app()->getLocale() === 'en' && $content && $content->hero_desc_en 
                ? $content->hero_desc_en 
                : ($content->hero_desc ?? __('site.volunteer.hero_subtitle'));
            $heroSub = mb_strlen($rawSub) > 120 ? mb_substr($rawSub, 0, 117) . '...' : $rawSub;
        @endphp

        <p class="mt-3 text-xl text-[#1cc6aa] max-w-xl mx-auto">{{ $heroSub }}</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-6 -mt-8 pb-20">

    <!-- Opportunities from volunteer_contents (only dynamic data) -->
    <div class="mb-12">
        <div class="bg-white border rounded-3xl p-10 shadow-sm">
            <div class="prose prose-lg max-w-none text-gray-700 whitespace-pre-line leading-relaxed text-lg">
                {{ app()->getLocale() === 'en' && $content && $content->opportunities_en 
                    ? $content->opportunities_en 
                    : ($content->opportunities ?? 'لا توجد فرص محددة حالياً.') }}
            </div>
        </div>
    </div>

    <!-- طرق التطوع from donation_methods -->
    @if($donationMethods->count() > 0)
    <div class="mb-16">
        <div class="text-center mb-10">
            <span class="px-4 py-1 bg-[#1cc6aa]/10 text-[#29225c] text-sm font-medium rounded-full">{{ __('site.volunteer.methods_badge') }}</span>
            <h2 class="text-3xl font-bold mt-3">{{ __('site.volunteer.methods_title') }}</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
            @foreach($donationMethods as $method)
                <div class="bg-white border rounded-3xl overflow-hidden shadow-sm modern-card">
                    @if($method->image)
                        <img src="{{ asset('storage/' . $method->image) }}" class="w-full h-40 object-cover" alt="">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-[#29225c] to-[#1cc6aa] flex items-center justify-center">
                            <i class="fas fa-hands-helping text-white text-5xl opacity-80"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2">
                            {{ app()->getLocale() === 'en' && $method->name_en ? $method->name_en : $method->name }}
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ app()->getLocale() === 'en' && $method->description_en ? $method->description_en : $method->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Simple CTA (minimal static) -->
    <div class="text-center">
        <a href="{{ route('site.contact') }}" 
           class="inline-flex items-center justify-center bg-[#29225c] hover:bg-[#372d70] transition text-white px-12 py-4 rounded-3xl font-semibold text-lg">
            <i class="fas fa-envelope ml-3"></i>
            {{ __('site.volunteer.contact_button') }}
        </a>
    </div>

</div>
@endsection
