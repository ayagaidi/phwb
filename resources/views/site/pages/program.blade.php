@extends('site.layouts.app')

@section('title', (app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title) . ' | ' . __('site.footer.org_name'))

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Back Button -->
    <a href="{{ route('site.programs') }}" 
       class="inline-flex items-center text-sm text-gray-600 hover:text-[#29225c] mb-6">
        <i class="fas fa-arrow-left ml-2"></i>
        {{ app()->getLocale() === 'en' ? 'Back to Programs' : 'العودة إلى البرامج' }}
    </a>

    <!-- Program Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold tracking-tight text-[#29225c] mb-3">
            {{ app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title }}
        </h1>
        <div class="text-sm text-gray-500">
            {{ $program->created_at->format('Y/m/d') }}
        </div>
    </div>

    <!-- Main Image -->
    @if($program->image)
        <div class="mb-8 rounded-3xl overflow-hidden border">
            <img src="{{ asset('storage/' . $program->image) }}" 
                 class="w-full max-h-[500px] object-cover" 
                 alt="{{ app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title }}">
        </div>
    @endif

    <!-- Description -->
    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
        {!! nl2br(e(
            app()->getLocale() === 'en' && $program->description_en 
                ? $program->description_en 
                : $program->description
        )) !!}
    </div>

    <!-- Video Link -->
    @if($program->video_url)
        <div class="mt-8">
            <a href="{{ $program->video_url }}" target="_blank" 
               class="inline-flex items-center px-6 py-3 bg-[#29225c] text-white rounded-xl hover:bg-[#1f1a47] transition">
                <i class="fas fa-play-circle ml-3 text-lg"></i>
                <span class="mr-3">
                    {{ app()->getLocale() === 'en' ? 'Watch Video' : 'شاهد الفيديو' }}
                </span>
            </a>
        </div>
    @endif

    <!-- Back to list -->
    <div class="mt-12 pt-6 border-t">
        <a href="{{ route('site.programs') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-[#29225c] text-white rounded-xl hover:bg-[#1f1a47] transition">
            <i class="fas fa-arrow-left ml-2"></i>
            {{ app()->getLocale() === 'en' ? 'Back to All Programs' : 'العودة إلى جميع البرامج' }}
        </a>
    </div>
</div>
@endsection
