@extends('site.layouts.app')

@section('title', __('site.articles.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<!-- Hero -->
<div class="bg-gradient-to-b from-[#29225c] to-[#372d70] text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-x-2 bg-white/10 px-4 py-1 rounded-full text-sm mb-4">
            <i class="fas fa-newspaper"></i>
            <span>{{ __('site.articles.hero_badge') }}</span>
        </div>
        <h1 class="text-5xl font-bold tracking-tight">{{ __('site.articles.title') }}</h1>
        <p class="mt-3 text-xl text-[#1cc6aa] max-w-xl mx-auto">{{ __('site.articles.hero_subtitle') }}</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6  pb-16">
    @if($articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
        @foreach($articles as $article)
            <div class="bg-white border rounded-3xl p-7 modern-card">
                <h3 class="font-bold text-2xl mb-3">
                    {{ app()->getLocale() === 'en' && $article->title_en ? $article->title_en : $article->title }}
                </h3>
                <div class="prose prose-sm text-gray-600">
                    {!! nl2br(e(Str::limit($article->content, 280))) !!}
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    {{ $article->created_at->format('Y/m/d') }}
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p class="text-center text-gray-500">{{ __('site.articles.no_articles') }}</p>
    @endif
</div>
@endsection
