@extends('site.layouts.app')

@section('title', __('site.programs.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<div class="max-w-6xl mx-auto px-6 py-14">
    <div class="text-center mb-12">
        <span class="px-4 py-1 bg-blue-100 text-[#1e3a8a] text-sm font-medium rounded-full">{{ __('site.programs_label') }}</span>
        <h1 class="text-4xl font-bold mt-3">{{ __('site.programs.subtitle') }}</h1>
    </div>

    @if($programs->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
        @foreach($programs as $program)
            <div class="bg-white rounded-3xl overflow-hidden border shadow-sm modern-card">
                @if($program->image)
                    <img src="{{ asset('storage/' . $program->image) }}" class="w-full h-52 object-cover" alt="">
                @endif
                <div class="p-6">
                    <h3 class="font-bold text-2xl mb-3">
                        {{ app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ app()->getLocale() === 'en' && $program->description_en ? $program->description_en : $program->description }}
                    </p>
                    
                    @if($program->video_url)
                        <a href="{{ $program->video_url }}" target="_blank" 
                           class="inline-flex items-center mt-4 text-sm text-[#1e3a8a] font-medium">
                            <i class="fas fa-play-circle ml-2"></i> {{ app()->getLocale() === 'en' ? 'Watch Video' : 'شاهد الفيديو' }}
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p class="text-center text-gray-500">{{ __('site.programs.no_programs') }}</p>
    @endif
</div>
@endsection
