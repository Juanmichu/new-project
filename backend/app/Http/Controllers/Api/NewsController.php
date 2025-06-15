<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsController extends Controller
{
	public function index(Request $request)
	{
		$query = NewsArticle::where('status', 'published');

		if ($request->has('category')) {
			$query->where('category', $request->category);
		}

		$news = $query->orderBy('published_at', 'desc')
			->paginate(10);

		return response()->json($news);
	}

	public function show($slug)
	{
		$article = NewsArticle::where('slug', $slug)
			->where('status', 'published')
			->firstOrFail();

		// Increment view count
		$article->increment('views');

		return response()->json($article);
	}

	public function breaking()
	{
		$breakingNews = NewsArticle::where('status', 'published')
			->where('is_breaking', true)
			->orderBy('published_at', 'desc')
			->take(5)
			->get();

		return response()->json($breakingNews);
	}
}
