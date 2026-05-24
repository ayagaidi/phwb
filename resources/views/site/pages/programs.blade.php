@extends('site.layouts.app')

@section('title', __('site.programs.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<!-- Hero -->
<div class="bg-gradient-to-b from-[#29225c] to-[#372d70] text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-x-2 bg-white/10 px-4 py-1 rounded-full text-sm mb-4">
            <i class="fas fa-project-diagram"></i>
            <span>{{ __('site.programs.hero_badge') }}</span>
        </div>
        <h1 class="text-5xl font-bold tracking-tight">{{ __('site.programs.title') }}</h1>
        <p class="mt-3 text-xl text-[#1cc6aa] max-w-xl mx-auto">{{ __('site.programs.hero_subtitle') }}</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6  pb-16">
    @if($programs->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
        @foreach($programs as $program)
            <div class="bg-white rounded-3xl overflow-hidden border shadow-sm modern-card flex flex-col">
                @if($program->image)
                    <img src="{{ asset('storage/' . $program->image) }}" class="w-full h-52 object-cover" alt="">
                @endif
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-bold text-2xl mb-3">
                        {{ app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed flex-1">
                        {{ app()->getLocale() === 'en' && $program->description_en ? $program->description_en : $program->description }}
                    </p>
                    
                    <div class="mt-4 flex items-center justify-between">
                        @if($program->video_url)
                            <a href="{{ $program->video_url }}" target="_blank" 
                               class="inline-flex items-center text-sm text-[#29225c] font-medium">
                                <i class="fas fa-play-circle ml-2"></i> 
                                {{ app()->getLocale() === 'en' ? 'Watch Video' : 'شاهد الفيديو' }}
                            </a>
                        @else
                            <span></span>
                        @endif

                        <a href="{{ route('site.programs.show', $program->id) }}" 
                           class="inline-flex items-center text-sm font-medium text-[#29225c] hover:text-[#1cc6aa] transition">
                            {{ app()->getLocale() === 'en' ? 'Read More' : 'عرض المزيد' }}
                            <i class="fas fa-arrow-left mr-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p class="text-center text-gray-500">{{ __('site.programs.no_programs') }}</p>
    @endif
</div>
@endsection
