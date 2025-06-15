// src/App.js - Complete Integration
import React, { useState } from 'react';
import './workout-app.css';
import './App.css';
import { AuthProvider } from './hooks/useAuth';
import { LoginPage, RegisterPage } from './components/AuthPages';
import { ProtectedRoute } from './components/ProtectedRoute';
import { UpdatedUserDashboard } from './components/UpdatedUserDashboard';

// Import Lucide React icons
import { ArrowRight, Dumbbell, Users, Calendar, Trophy, ArrowLeft, Clock, User, LogOut, Menu, X, Target, TrendingUp, CheckCircle, Search, Filter, ChevronRight, Heart, MessageCircle, Share2, BookOpen, Tag } from 'lucide-react';

// Updated HomePage with auth integration
const HomePage = ({ onNavigate }) => {
    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
            {/* Navigation */}
            <nav className="bg-black/20 backdrop-blur-lg border-b border-white/10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center py-4">
                        <div className="flex items-center space-x-2">
                            <Dumbbell className="h-8 w-8 text-purple-400" />
                            <span className="text-2xl font-bold text-white">FitTracker</span>
                        </div>
                        <div className="hidden md:flex space-x-8">
                            <button onClick={() => onNavigate('home')} className="text-white hover:text-purple-400 transition-colors">Home</button>
                            <button onClick={() => onNavigate('news')} className="text-white hover:text-purple-400 transition-colors">News</button>
                            <button onClick={() => onNavigate('blog')} className="text-white hover:text-purple-400 transition-colors">Blog</button>
                        </div>
                        <div className="flex space-x-4">
                            <button
                                onClick={() => onNavigate('login')}
                                className="px-4 py-2 text-white border border-white/20 rounded-lg hover:bg-white/10 transition-colors"
                            >
                                Login
                            </button>
                            <button
                                onClick={() => onNavigate('register')}
                                className="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                            >
                                Sign Up
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="relative overflow-hidden">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div className="text-center">
                        <h1 className="text-5xl md:text-7xl font-bold text-white mb-6">
                            Track Your
                            <span className="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400"> Fitness</span>
                            <br />Journey
                        </h1>
                        <p className="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
                            Plan your daily workouts, track your progress, and achieve your fitness goals with our comprehensive workout tracking platform.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <button
                                onClick={() => onNavigate('register')}
                                className="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 flex items-center justify-center"
                            >
                                Get Started <ArrowRight className="ml-2 h-5 w-5" />
                            </button>
                            <button
                                onClick={() => onNavigate('login')}
                                className="px-8 py-4 border border-white/20 text-white rounded-lg font-semibold hover:bg-white/10 transition-colors"
                            >
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>

                {/* Floating Elements */}
                <div className="absolute top-20 left-10 w-20 h-20 bg-purple-500/20 rounded-full blur-xl animate-pulse"></div>
                <div className="absolute bottom-20 right-10 w-32 h-32 bg-pink-500/20 rounded-full blur-xl animate-pulse delay-700"></div>
            </section>

            {/* Features Section */}
            <section className="py-24 bg-black/20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl font-bold text-white mb-4">Why Choose FitTracker?</h2>
                        <p className="text-gray-300 text-lg">Everything you need to stay on track with your fitness goals</p>
                    </div>

                    <div className="grid md:grid-cols-3 gap-8">
                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition-all">
                            <Calendar className="h-12 w-12 text-purple-400 mb-4" />
                            <h3 className="text-xl font-semibold text-white mb-4">Daily Workout Plans</h3>
                            <p className="text-gray-300">Get personalized daily workout routines tailored to your fitness level and goals.</p>
                        </div>

                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition-all">
                            <Trophy className="h-12 w-12 text-purple-400 mb-4" />
                            <h3 className="text-xl font-semibold text-white mb-4">Progress Tracking</h3>
                            <p className="text-gray-300">Monitor your progress with detailed analytics and achievement tracking.</p>
                        </div>

                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition-all">
                            <Users className="h-12 w-12 text-purple-400 mb-4" />
                            <h3 className="text-xl font-semibold text-white mb-4">Community Support</h3>
                            <p className="text-gray-300">Connect with other fitness enthusiasts and share your journey.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};

// Enhanced News Page with API integration
const NewsPage = ({ onNavigate }) => {
    const [news, setNews] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedCategory, setSelectedCategory] = useState('all');

    // Mock news data - in real app, fetch from API
    const mockNews = [
        {
            id: 1,
            title: "10 Best Exercises for Building Core Strength",
            excerpt: "Discover the most effective exercises to strengthen your core and improve your overall fitness performance.",
            category: "fitness",
            author_name: "Sarah Johnson",
            published_at: "2025-06-14",
            views: 127,
            featured_image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop"
        },
        {
            id: 2,
            title: "New Feature: AI-Powered Workout Recommendations",
            excerpt: "Our latest update introduces intelligent workout suggestions based on your fitness goals and progress.",
            category: "updates",
            author_name: "Tech Team",
            published_at: "2025-06-13",
            views: 89,
            featured_image: "https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=800&h=400&fit=crop"
        }
    ];

    React.useEffect(() => {
        // Simulate API call
        setTimeout(() => {
            setNews(mockNews);
            setLoading(false);
        }, 1000);
    }, []);

    if (loading) {
        return (
            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 flex items-center justify-center">
                <div className="text-white text-xl">Loading news...</div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900">
            <header className="bg-black/20 backdrop-blur-lg border-b border-white/10 sticky top-0 z-40">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-4">
                            <button
                                onClick={() => onNavigate('home')}
                                className="text-white hover:text-indigo-400 transition-colors"
                            >
                                <ArrowLeft className="h-6 w-6" />
                            </button>
                            <h1 className="text-2xl font-bold text-white">Fitness News</h1>
                        </div>
                    </div>
                </div>
            </header>

            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {news.map((article) => (
                        <div
                            key={article.id}
                            className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden hover:bg-white/10 transition-all group cursor-pointer"
                        >
                            <img
                                src={article.featured_image}
                                alt={article.title}
                                className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                            <div className="p-6">
                                <h3 className="text-lg font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors">
                                    {article.title}
                                </h3>
                                <p className="text-gray-300 mb-4 text-sm">
                                    {article.excerpt}
                                </p>
                                <div className="flex items-center justify-between text-xs text-gray-400">
                                    <span>{article.author_name}</span>
                                    <span>{new Date(article.published_at).toLocaleDateString()}</span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </main>
        </div>
    );
};

// Enhanced Blog Page with API integration
const BlogPage = ({ onNavigate }) => {
    const [articles, setArticles] = useState([]);
    const [loading, setLoading] = useState(true);

    // Mock blog data
    const mockArticles = [
        {
            id: 1,
            title: "The Ultimate Guide to Home Workouts: No Equipment Needed",
            excerpt: "Transform your living room into a personal gym with these effective bodyweight exercises.",
            author: { name: "Alex Thompson", avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" },
            published_at: "2025-06-14",
            likes: 127,
            comments: 23,
            featured_image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop"
        },
        {
            id: 2,
            title: "Meal Prep Made Simple: 7 Days of Healthy Eating",
            excerpt: "Discover how to prepare a week's worth of nutritious meals in just 2 hours every Sunday.",
            author: { name: "Sarah Martinez", avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face" },
            published_at: "2025-06-13",
            likes: 89,
            comments: 15,
            featured_image: "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&h=400&fit=crop"
        }
    ];

    React.useEffect(() => {
        setTimeout(() => {
            setArticles(mockArticles);
            setLoading(false);
        }, 1000);
    }, []);

    if (loading) {
        return (
            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center">
                <div className="text-white text-xl">Loading blog...</div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
            <header className="bg-black/20 backdrop-blur-lg border-b border-white/10 sticky top-0 z-40">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div className="flex items-center space-x-4">
                        <button
                            onClick={() => onNavigate('home')}
                            className="text-white hover:text-purple-400 transition-colors"
                        >
                            <ArrowLeft className="h-6 w-6" />
                        </button>
                        <div className="flex items-center space-x-2">
                            <BookOpen className="h-6 w-6 text-purple-400" />
                            <h1 className="text-2xl font-bold text-white">Fitness Blog</h1>
                        </div>
                    </div>
                </div>
            </header>

            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="space-y-8">
                    {articles.map((article) => (
                        <article
                            key={article.id}
                            className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 hover:bg-white/10 transition-all group"
                        >
                            <div className="md:flex">
                                <div className="md:w-1/3">
                                    <img
                                        src={article.featured_image}
                                        alt={article.title}
                                        className="w-full h-48 md:h-full object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-t-none group-hover:scale-105 transition-transform duration-300"
                                    />
                                </div>
                                <div className="md:w-2/3 p-6">
                                    <h3 className="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                                        {article.title}
                                    </h3>
                                    <p className="text-gray-300 mb-4">
                                        {article.excerpt}
                                    </p>
                                    <div className="flex items-center justify-between mb-4">
                                        <div className="flex items-center space-x-3">
                                            <img
                                                src={article.author.avatar}
                                                alt={article.author.name}
                                                className="w-8 h-8 rounded-full"
                                            />
                                            <span className="text-white text-sm font-medium">{article.author.name}</span>
                                        </div>
                                        <span className="text-xs text-gray-400">
                      {new Date(article.published_at).toLocaleDateString()}
                    </span>
                                    </div>
                                    <div className="flex items-center justify-between pt-4 border-t border-white/10">
                                        <div className="flex items-center space-x-4">
                                            <button className="flex items-center space-x-1 text-sm text-gray-400 hover:text-red-400 transition-colors">
                                                <Heart className="h-4 w-4" />
                                                <span>{article.likes}</span>
                                            </button>
                                            <button className="flex items-center space-x-1 text-sm text-gray-400 hover:text-white transition-colors">
                                                <MessageCircle className="h-4 w-4" />
                                                <span>{article.comments}</span>
                                            </button>
                                        </div>
                                        <button className="text-purple-400 hover:text-purple-300 transition-colors text-sm font-medium">
                                            Read More →
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    ))}
                </div>
            </div>
        </div>
    );
};

// Main App Component
function App() {
    const [currentPage, setCurrentPage] = useState('home');

    const renderPage = () => {
        switch(currentPage) {
            case 'login':
                return <LoginPage onNavigate={setCurrentPage} />;
            case 'register':
                return <RegisterPage onNavigate={setCurrentPage} />;
            case 'dashboard':
                return (
                    <ProtectedRoute onNavigate={setCurrentPage}>
                        <UpdatedUserDashboard onNavigate={setCurrentPage} />
                    </ProtectedRoute>
                );
            case 'news':
                return <NewsPage onNavigate={setCurrentPage} />;
            case 'blog':
                return <BlogPage onNavigate={setCurrentPage} />;
            default:
                return <HomePage onNavigate={setCurrentPage} />;
        }
    };

    return (
        <AuthProvider>
            {renderPage()}
        </AuthProvider>
    );
}

export default App;