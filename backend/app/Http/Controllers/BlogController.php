<?php

namespace App\Http\Controllers;

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
    public function show($slug)
    {
        $article = $this->getArticleBySlug($slug);
        
        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }
        
        $relatedArticles = $this->getRelatedArticles($article);
        
        return view('blog.show', compact('article', 'relatedArticles'));
    }
    
    /**
     * Mostrar artículos por categoría
     */
    public function category($category)
    {
        $articles = $this->getArticlesByCategory($category);
        $categoryName = ucfirst($category);
        
        return view('blog.category', compact('articles', 'category', 'categoryName'));
    }
    
    /**
     * Mostrar artículos por autor
     */
    public function author($author)
    {
        $articles = $this->getArticlesByAuthor($author);
        $authorName = $this->getAuthorName($author);
        
        return view('blog.author', compact('articles', 'author', 'authorName'));
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
    public function edit($slug)
    {
        $article = $this->getArticleBySlug($slug);
        
        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }
        
        $categories = $this->getCategories();
        
        return view('blog.edit', compact('article', 'categories'));
    }
    
    /**
     * Actualizar artículo
     */
    public function update(Request $request, $slug)
    {
        $article = $this->getArticleBySlug($slug);
        
        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500', 
            'content' => 'required|string',
            'category' => 'required|string',
            'featured_image' => 'nullable|image|max:2048'
        ]);
        
        // Aquí actualizarías en la base de datos
        
        return redirect()->route('blog.show', $slug)
            ->with('success', 'Artículo actualizado exitosamente');
    }
    
    /**
     * Eliminar artículo
     */
    public function destroy($slug)
    {
        $article = $this->getArticleBySlug($slug);
        
        if (!$article) {
            abort(404, 'Artículo no encontrado');
        }
        
        // Aquí eliminarías de la base de datos
        
        return redirect()->route('blog.index')
            ->with('success', 'Artículo eliminado exitosamente');
    }
    
    /**
     * Métodos helper privados
     */
    private function getFilteredArticles(Request $request)
    {
        $allArticles = [
            [
                'id' => 1,
                'title' => 'Los 10 Mejores Ejercicios para Principiantes',
                'slug' => 'mejores-ejercicios-principiantes',
                'excerpt' => 'Descubre los ejercicios fundamentales que todo principiante debe conocer.',
                'category' => 'Ejercicios',
                'read_time' => '4 min',
                'date' => '14 Jun 2025',
                'author' => 'Dr. Fitness',
                'featured' => false
            ],
            [
                'id' => 2,
                'title' => 'Nutrición Pre y Post Entrenamiento',
                'slug' => 'nutricion-pre-post-entrenamiento',
                'excerpt' => 'Aprende qué comer antes y después de entrenar para maximizar tus resultados.',
                'category' => 'Nutrición',
                'read_time' => '6 min',
                'date' => '13 Jun 2025',
                'author' => 'Nutri Coach',
                'featured' => false
            ],
            [
                'id' => 3,
                'title' => 'Rutina de 4 Semanas para Quemar Grasa',
                'slug' => 'rutina-4-semanas-quemar-grasa',
                'excerpt' => 'Un plan completo para transformar tu cuerpo en solo 4 semanas.',
                'category' => 'Rutinas',
                'read_time' => '8 min',
                'date' => '12 Jun 2025',
                'author' => 'Trainer Pro',
                'featured' => false
            ]
        ];
        
        if ($request->filled('category') && $request->category !== 'all') {
            $allArticles = array_filter($allArticles, function($article) use ($request) {
                return strtolower($article['category']) === strtolower($request->category);
            });
        }
        
        return array_values($allArticles);
    }
    
    private function getArticleBySlug($slug)
    {
        $articles = [
            'guia-empezar-gimnasio' => [
                'id' => 1,
                'title' => 'Guía Completa: Cómo Empezar en el Gimnasio',
                'slug' => 'guia-empezar-gimnasio',
                'excerpt' => 'Si eres principiante y quieres comenzar tu journey fitness, esta guía te dará todas las herramientas necesarias para empezar de forma segura y efectiva.',
                'content' => 'Contenido completo del artículo...',
                'category' => 'Consejos',
                'read_time' => '5 min',
                'date' => '15 Jun 2025',
                'author' => 'Admin',
                'author_bio' => 'Entrenador Certificado',
                'featured' => true,
                'meta_description' => 'Guía completa para principiantes que quieren empezar en el gimnasio de forma segura y efectiva.'
            ]
        ];
        
        return $articles[$slug] ?? null;
    }
    
    private function getFeaturedArticle()
    {
        return [
            'id' => 1,
            'title' => 'Guía Completa: Cómo Empezar en el Gimnasio',
            'slug' => 'guia-empezar-gimnasio',
            'excerpt' => 'Si eres principiante y quieres comenzar tu journey fitness, esta guía te dará todas las herramientas necesarias para empezar de forma segura y efectiva...',
            'date' => '15 de Junio, 2025',
            'author' => 'Admin',
            'read_time' => '5 min'
        ];
    }
    
    private function getRelatedArticles($article)
    {
        return [
            [
                'id' => 2,
                'title' => 'Los 10 Mejores Ejercicios para Principiantes',
                'slug' => 'mejores-ejercicios-principiantes',
                'excerpt' => 'Descubre los ejercicios fundamentales que todo principiante debe conocer.'
            ],
            [
                'id' => 3,
                'title' => 'Cómo Evitar Lesiones en el Gimnasio',
                'slug' => 'evitar-lesiones-gimnasio',
                'excerpt' => 'Consejos esenciales para entrenar de forma segura y prevenir lesiones.'
            ]
        ];
    }
    
    private function getCategories()
    {
        return ['Ejercicios', 'Nutrición', 'Consejos', 'Rutinas'];
    }
    
    private function getArticlesByCategory($category)
    {
        // Implementar filtrado por categoría
        return [];
    }
    
    private function getArticlesByAuthor($author)
    {
        // Implementar filtrado por autor
        return [];
    }
    
    private function getAuthorName($author)
    {
        $authors = [
            'admin' => 'Administrador',
            'dr-fitness' => 'Dr. Fitness',
            'nutri-coach' => 'Nutri Coach'
        ];
        
        return $authors[$author] ?? 'Autor Desconocido';
    }
}