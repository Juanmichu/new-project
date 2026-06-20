<?php

namespace App\Http\Controllers;

use App\Http\Constants\Articles;
use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Mostrar lista de artículos del blog
     */
    public function index(Request $request)
    {
        $articles = $this->getFilteredArticles($request);
        $categories = $this->getCategories();
        $featuredArticle = $this->getFeaturedArticle();

        return view('blog.index', compact('articles', 'categories', 'featuredArticle'));
    }

    /**
     * Mostrar un artículo específico
     */
    public function show(string $id)
    {
        $article = $this->getArticleById($id);

        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }

        $relatedArticles = $this->getRelatedArticles($article->tags);

        return view('blog.show', compact('article', 'relatedArticles'));
    }

    /**
     * Mostrar artículos por categoría
     */
    public function category(string $category)
    {
        $articles = $this->getArticlesByCategory($category);
        $categoryName = ucfirst($category);

        return view('blog.category', compact('articles', 'category', 'categoryName'));
    }

    /**
     * Mostrar artículos por autor
     */
    public function author(string $author)
    {
        $articles = $this->getArticlesByAuthor($author);

        return view('blog.author', compact('articles', 'author'));
    }

    /**
     * Mostrar formulario para crear artículo
     */
    public function create()
    {
        $categories = $this->getCategories();

        return view('blog.create', compact('categories'));
    }

    /**
     * Guardar nuevo artículo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_posts,slug',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'meta_description' => 'nullable|string|max:160'
        ]);

        // Aquí guardarías en la base de datos

        return redirect()->route('blog.index')
            ->with('success', 'Artículo creado exitosamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(string $id)
    {
        $article = $this->getArticleById($id);

        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }

        $categories = $this->getCategories();

        return view('blog.edit', compact('article', 'categories'));
    }

    /**
     * Actualizar artículo
     */
    public function update(Request $request, string $id)
    {
        $article = $this->getArticleById($id);

        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:100',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|image|max:2048',
            'author' => 'required|string|max:100',
            'reading_time' => 'nullable|string|max:10',
        ]);

        // Aquí actualizarías en la base de datos
        Article::where('id', $id)->update($validated);

        return redirect()->route('blog.show', $id)
            ->with('success', 'Artículo actualizado exitosamente');
    }

    /**
     * Eliminar artículo
     */
    public function destroy(string $id)
    {
        $article = $this->getArticleById($id);

        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }

        // Aquí eliminarías de la base de datos
        $article->delete();

        return redirect()->route('blog.index')
            ->with('success', 'Artículo eliminado exitosamente');
    }

    /**
     * @param Request $request
     * @param bool $isFeatured - Determines if the articles should be featured or not
     * @return Article[]
     */
    private function getFilteredArticles(Request $request, bool $isFeatured = false)
    {
        $allArticles = Article::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $allArticles = $allArticles->where('category', $request->category);
        }

        if(!$isFeatured) {
            $allArticles = $allArticles->where('is_featured', $isFeatured);
        }

        return $allArticles->paginate(6);
    }

    private function getArticleById(string $id): ?Article
    {
        return Article::where('_id', $id)->first();
    }

    private function getFeaturedArticle()
    {
        // Get the featured article from mongo database

        return Article::where('is_featured', true)->first();
    }

    private function getRelatedArticles(array $tags)
    {
        // Get related articles from mongo database based on tags
        return Article::whereIn('tags', $tags)->take(3)->get();
    }

    private function getCategories(): array
    {
        return Articles::CATEGORIES;
    }

    private function getArticlesByCategory(string $category)
    {
        // Implementar filtrado por categoría
        return Article::where('category', $category)->paginate(6);
    }

    private function getArticlesByAuthor(string $author)
    {
        // Implementar filtrado por autor
        return Article::where('author', 'like', '%' . $author . '%')->paginate(6);
    }
}
