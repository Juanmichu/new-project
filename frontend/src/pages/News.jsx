import React, { useState } from 'react';
import { ArrowLeft, Calendar, Clock, User, Search, Filter, ChevronRight } from 'lucide-react';

const News = () => {
    const [selectedCategory, setSelectedCategory] = useState('all');
    const [searchQuery, setSearchQuery] = useState('');

    const categories = [
        { id: 'all', name: 'All News' },
        { id: 'fitness', name: 'Fitness Tips' },
        { id: 'nutrition', name: 'Nutrition' },
        { id: 'updates', name: 'App Updates' },
        { id: 'community', name: 'Community' }
    ];

    const newsArticles = [
        {
            id: 1,
            title: "10 Best Exercises for Building Core Strength",
            excerpt: "Discover the most effective exercises to strengthen your core and improve your overall fitness performance.",
            category: "fitness",
            author: "Sarah Johnson",
            date: "June 10, 2025",
            readTime: "5 min read",
            image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop",
            featured: true
        },
        {
            id: 2,
            title: "New Feature: AI-Powered Workout Recommendations",
            excerpt: "Our latest update introduces intelligent workout suggestions based on your fitness goals and progress.",
            category: "updates",
            author: "Tech Team",
            date: "June 9, 2025",
            readTime: "3 min read",
            image: "https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=800&h=400&fit=crop",
            featured: false
        },
        {
            id: 3,
            title: "The Science Behind Post-Workout Nutrition",
            excerpt: "Learn how to fuel your body properly after intense training sessions for optimal recovery and results.",
            category: "nutrition",
            author: "Dr. Michael Chen",
            date: "June 8, 2025",
            readTime: "7 min read",
            image: "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&h=400&fit=crop",
            featured: false
        },
        {
            id: 4,
            title: "Community Spotlight: Member Success Stories",
            excerpt: "Read inspiring transformation stories from our community members who achieved their fitness goals.",
            category: "community",
            author: "Community Team",
            date: "June 7, 2025",
            readTime: "4 min read",
            image: "https://images.unsplash.com/photo-1594737625785-a6cbdabd333c?w=800&h=400&fit=crop",
            featured: false
        },
        {
            id: 5,
            title: "5 Common Workout Mistakes and How to Avoid Them",
            excerpt: "Prevent injury and maximize your results by avoiding these frequent exercise mistakes.",
            category: "fitness",
            author: "Lisa Rodriguez",
            date: "June 6, 2025",
            readTime: "6 min read",
            image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop",
            featured: false
        },
        {
            id: 6,
            title: "Hydration: The Key to Better Workouts",
            excerpt: "Understanding how proper hydration affects your performance and recovery during exercise.",
            category: "nutrition",
            author: "Emma Wilson",
            date: "June 5, 2025",
            readTime: "4 min read",
            image: "https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800&h=400&fit=crop",
            featured: false
        }
    ];

    const filteredArticles = newsArticles.filter(article => {
        const matchesCategory = selectedCategory === 'all' || article.category === selectedCategory;
        const matchesSearch = article.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            article.excerpt.toLowerCase().includes(searchQuery.toLowerCase());
        return matchesCategory && matchesSearch;
    });

    const featuredArticle = newsArticles.find(article => article.featured);
    const regularArticles = filteredArticles.filter(article => !article.featured);

    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900">
            {/* Header */}
            <header className="bg-black/20 backdrop-blur-lg border-b border-white/10 sticky top-0 z-40">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-4">
                            <button className="text-white hover:text-indigo-400 transition-colors">
                                <ArrowLeft className="h-6 w-6" />
                            </button>
                            <h1 className="text-2xl font-bold text-white">Fitness News</h1>
                        </div>

                        <div className="flex items-center space-x-4">
                            <div className="relative">
                                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                <input
                                    type="text"
                                    placeholder="Search articles..."
                                    value={searchQuery}
                                    onChange={(e) => setSearchQuery(e.target.value)}
                                    className="pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:bg-white/10 transition-all w-64"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {/* Main Content */}
            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {/* Category Filter */}
                <div className="flex items-center space-x-2 mb-8 overflow-x-auto">
                    <Filter className="h-5 w-5 text-gray-300 flex-shrink-0" />
                    {categories.map((category) => (
                        <button
                            key={category.id}
                            onClick={() => setSelectedCategory(category.id)}
                            className={`px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap ${
                                selectedCategory === category.id
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-white/5 text-gray-300 hover:bg-white/10 hover:text-white'
                            }`}
                        >
                            {category.name}
                        </button>
                    ))}
                </div>

                {/* Featured Article */}
                {featuredArticle && selectedCategory === 'all' && !searchQuery && (
                    <div className="mb-12">
                        <h2 className="text-2xl font-bold text-white mb-6">Featured Article</h2>
                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden hover:bg-white/10 transition-all group cursor-pointer">
                            <div className="md:flex">
                                <div className="md:w-1/2">
                                    <img
                                        src={featuredArticle.image}
                                        alt={featuredArticle.title}
                                        className="w-full h-64 md:h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    />
                                </div>
                                <div className="md:w-1/2 p-8">
                                    <div className="flex items-center space-x-4 mb-4">
                    <span className="px-3 py-1 bg-indigo-600 text-white text-sm rounded-full">
                      {categories.find(c => c.id === featuredArticle.category)?.name}
                    </span>
                                        <span className="text-sm text-gray-300">Featured</span>
                                    </div>
                                    <h3 className="text-2xl font-bold text-white mb-4 group-hover:text-indigo-400 transition-colors">
                                        {featuredArticle.title}
                                    </h3>
                                    <p className="text-gray-300 mb-6 line-clamp-3">
                                        {featuredArticle.excerpt}
                                    </p>
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center space-x-4 text-sm text-gray-400">
                                            <div className="flex items-center space-x-1">
                                                <User className="h-4 w-4" />
                                                <span>{featuredArticle.author}</span>
                                            </div>
                                            <div className="flex items-center space-x-1">
                                                <Calendar className="h-4 w-4" />
                                                <span>{featuredArticle.date}</span>
                                            </div>
                                            <div className="flex items-center space-x-1">
                                                <Clock className="h-4 w-4" />
                                                <span>{featuredArticle.readTime}</span>
                                            </div>
                                        </div>
                                        <ChevronRight className="h-5 w-5 text-indigo-400 group-hover:translate-x-1 transition-transform" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Articles Grid */}
                <div>
                    <h2 className="text-2xl font-bold text-white mb-6">
                        {selectedCategory === 'all' ? 'Latest Articles' : `${categories.find(c => c.id === selectedCategory)?.name} Articles`}
                    </h2>

                    {regularArticles.length > 0 ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {regularArticles.map((article) => (
                                <div
                                    key={article.id}
                                    className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden hover:bg-white/10 transition-all group cursor-pointer"
                                >
                                    <img
                                        src={article.image}
                                        alt={article.title}
                                        className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                    />
                                    <div className="p-6">
                                        <div className="flex items-center justify-between mb-3">
                      <span className="px-3 py-1 bg-indigo-600/20 text-indigo-400 text-sm rounded-full">
                        {categories.find(c => c.id === article.category)?.name}
                      </span>
                                            <span className="text-sm text-gray-400">{article.readTime}</span>
                                        </div>
                                        <h3 className="text-lg font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors line-clamp-2">
                                            {article.title}
                                        </h3>
                                        <p className="text-gray-300 mb-4 text-sm line-clamp-3">
                                            {article.excerpt}
                                        </p>
                                        <div className="flex items-center justify-between">
                                            <div className="flex items-center space-x-3 text-xs text-gray-400">
                                                <div className="flex items-center space-x-1">
                                                    <User className="h-3 w-3" />
                                                    <span>{article.author}</span>
                                                </div>
                                                <div className="flex items-center space-x-1">
                                                    <Calendar className="h-3 w-3" />
                                                    <span>{article.date}</span>
                                                </div>
                                            </div>
                                            <ChevronRight className="h-4 w-4 text-indigo-400 group-hover:translate-x-1 transition-transform" />
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-12">
                            <div className="text-gray-400 mb-4">
                                <Search className="h-12 w-12 mx-auto opacity-50" />
                            </div>
                            <h3 className="text-xl font-semibold text-white mb-2">No articles found</h3>
                            <p className="text-gray-400">Try adjusting your search or filter criteria.</p>
                        </div>
                    )}
                </div>

                {/* Load More Button */}
                {regularArticles.length > 0 && (
                    <div className="text-center mt-12">
                        <button className="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                            Load More Articles
                        </button>
                    </div>
                )}
            </main>
        </div>
    );
};

export default News;