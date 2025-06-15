<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
	public function index(Request $request)
	{
		$query = Article::where('status', 'published')
			->with('author');

		if ($request->has('category')) {
			$query->where('category', $request->category);
		}

		if ($request->has('featured')) {
			$query->where('is_featured', true);
		}

		$articles = $query->orderBy('published_at', 'desc')
			->paginate(10);

		return response()->json($articles);
	}

	public function show($slug)
	{
		$article = Article::where('slug', $slug)
			->where('status', 'published')
			->with('author')
			->firstOrFail();

		// Increment view count
		$article->increment('views');

		return response()->json($article);
	}

	public function like(Request $request, $id)
	{
		$article = Article::findOrFail($id);
		$article->increment('likes');

		return response()->json([
			'message' => 'Article liked',
			'likes' => $article->likes
		]);
	}
}
