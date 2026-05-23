@extends('site.layouts.app')

@section('title', __('site.articles.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<div class="max-w-6xl mx-auto px-6 py-14">
    <h1 class="text-4xl font-bold mb-10 text-center">{{ __('site.articles.title') }}</h1>

    @if($articles->count() > 0)
    <div class="grid md:grid-cols-2 gap-8">
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
