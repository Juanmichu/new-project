@extends('layouts.app')

@section('title', 'Blog de Fitness')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Header -->
    <div class="card mb-6">
        <div class="card-body text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Fitness Blog</h1>
            <p class="text-gray-600">Tips, nutrition and everything about fitness world</p>
        </div>
    </div>

    <!-- Featured Article -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex items-center mb-2">
                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Featured</span>
                <span class="mx-2 text-gray-400">•</span>
                <span class="text-sm text-gray-600">{{ date('d M Y', strtotime($featuredArticle->published_at)) }}</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                <a href="{{ route('blog.show', $featuredArticle->_id) }}" class="hover:text-blue-600">
                    {{ $featuredArticle->title }}
                </a>
            </h2>
            <p class="text-gray-600 mb-4">
                {{ Str::limit($featuredArticle->content, 150) }}
            </p>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">By: {{ $featuredArticle->author }}</span>
                    <span class="text-sm text-gray-600">Reading time: {{ $featuredArticle->reading_time }}</span>
                </div>
                <a href="{{ route('blog.show', $featuredArticle->_id) }}" class="btn-primary">
                    Read More
                </a>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold mb-3">Categories</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('blog.index') }}" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category]) }}" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- @var $article \App\Models\Article -->
        @foreach($articles as $article)
            <!-- Avoid displaying the featured article again in the grid -->
            @if($article->is_featured && $article->_id === $featuredArticle->_id)
                @continue
            @endif
            <article class="card hover:shadow-lg transition-shadow">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $article->category }}
                        </span>
                        <span class="text-sm text-gray-500">{{ date('d M Y', strtotime($article->published_at)) }}</span>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="{{ route('blog.show', $article->_id) }}" class="hover:text-blue-600">
                            {{ $article->title }}
                        </a>
                    </h3>

                    <p class="text-gray-600 mb-4">{{ $article->excerpt }}</p>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <span>Por: {{ $article->author }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $article->reading_time }}</span>
                        </div>
                        <a href="{{ route('blog.show', $article->_id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Read more →
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <!-- Pagination with page numbers and navigation. Using tailwind -->
    {{ $articles->links() }}
</div>
@endsection
