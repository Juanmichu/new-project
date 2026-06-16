@extends('layouts.app')

@section('title', 'Article - Details')

@section('content')

    <div class="max-w-4xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600">Articles</a></li>
                <li>/</li>
                <li>{{ $article->title }}</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
        <p class="text-gray-600 mb-6">Publicado el {{ $article->created_at->format('d/m/Y') }}</p>
        <div class="prose max-w-none mb-6">
            {!! $article->content !!}
        </div>

        <h2 class="text-2xl font-semibold mb-4">Related Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($relatedArticles as $relatedArticle)
                <!== Avoid displaying the current article in the related articles section -->
                @if($relatedArticle->_id == $article->_id)
                    @continue
                @endif
                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2">{{ $relatedArticle->title }}</h3>
                    <p class="text-gray-600 mb-2">{{ Str::limit(strip_tags($relatedArticle->content), 100) }}</p>
                    <a href="{{ route('blog.show', $relatedArticle->_id) }}" class="text-blue-600 hover:underline">Read more</a>
                </div>
            @endforeach
        </div>

    </div>

@endsection
