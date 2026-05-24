@extends('site.layouts.app')

@section('title', (app()->getLocale() === 'en' && $article->title_en ? $article->title_en : $article->title) . ' | ' . __('site.footer.org_name'))

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Back Button -->
    <a href="{{ route('site.articles') }}" 
       class="inline-flex items-center text-sm text-gray-600 hover:text-[#29225c] mb-6">
        <i class="fas fa-arrow-left ml-2"></i>
        {{ app()->getLocale() === 'en' ? 'Back to Articles' : 'العودة إلى المقالات' }}
    </a>

    <!-- Article Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold tracking-tight text-[#29225c] mb-3">
            {{ app()->getLocale() === 'en' && $article->title_en ? $article->title_en : $article->title }}
        </h1>
        <div class="text-sm text-gray-500">
            {{ $article->created_at->format('Y/m/d') }}
        </div>
    </div>

    <!-- Main Image -->
    @if($article->image)
        <div class="mb-8 rounded-3xl overflow-hidden border">
            <img src="{{ asset('storage/' . $article->image) }}" 
                 class="w-full max-h-[500px] object-cover" 
                 alt="{{ app()->getLocale() === 'en' && $article->title_en ? $article->title_en : $article->title }}">
        </div>
    @endif

    <!-- Content -->
    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
        {!! nl2br(e(
            app()->getLocale() === 'en' && $article->content_en 
                ? $article->content_en 
                : $article->content
        )) !!}
    </div>

    <!-- Image Gallery -->
    @if($article->images && is_array($article->images) && count($article->images) > 0)
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4 text-[#29225c]">
                {{ app()->getLocale() === 'en' ? 'Gallery' : 'معرض الصور' }}
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($article->images as $img)
                    <div class="rounded-2xl overflow-hidden border aspect-video">
                        <img src="{{ asset('storage/' . $img) }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                             alt="Article image">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back to list -->
    <div class="mt-12 pt-6 border-t">
        <a href="{{ route('site.articles') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-[#29225c] text-white rounded-xl hover:bg-[#1f1a47] transition">
            <i class="fas fa-arrow-left ml-2"></i>
            {{ app()->getLocale() === 'en' ? 'Back to All Articles' : 'العودة إلى جميع المقالات' }}
        </a>
    </div>
</div>
@endsection
