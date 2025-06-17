import React, { useState } from 'react';
import { ArrowLeft, Calendar, Clock, User, Heart, MessageCircle, Share2, BookOpen, Tag } from 'lucide-react';

const Blog = () => {
    const [likedPosts, setLikedPosts] = useState([]);
    const [selectedTag, setSelectedTag] = useState('all');

    const tags = [
        { id: 'all', name: 'All Posts', count: 12 },
        { id: 'workouts', name: 'Workouts', count: 5 },
        { id: 'nutrition', name: 'Nutrition', count: 3 },
        { id: 'motivation', name: 'Motivation', count: 2 },
        { id: 'lifestyle', name: 'Lifestyle', count: 2 }
    ];

    const blogPosts = [
        {
            id: 1,
            title: "The Ultimate Guide to Home Workouts: No Equipment Needed",
            excerpt: "Transform your living room into a personal gym with these effective bodyweight exercises that deliver real results.",
            content: "In today's fast-paced world, finding time to get to the gym can be challenging. But here's the good news: you don't need expensive equipment or a gym membership to get in fantastic shape...",
            author: {
                name: "Alex Thompson",
                avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face",
                role: "Certified Personal Trainer"
            },
            date: "June 11, 2025",
            readTime: "8 min read",
            image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop",
            tags: ['workouts', 'lifestyle'],
            likes: 127,
            comments: 23,
            featured: true
        },
        {
            id: 2,
            title: "Meal Prep Made Simple: 7 Days of Healthy Eating",
            excerpt: "Discover how to prepare a week's worth of nutritious meals in just 2 hours every Sunday.",
            content: "Meal prepping is one of the most effective strategies for maintaining a healthy diet while saving time and money...",
            author: {
                name: "Sarah Martinez",
                avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face",
                role: "Nutritionist"
            },
            date: "June 10, 2025",
            readTime: "6 min read",
            image: "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&h=400&fit=crop",
            tags: ['nutrition', 'lifestyle'],
            likes: 89,
            comments: 15,
            featured: false
        },
        {
            id: 3,
            title: "Breaking Through Fitness Plateaus: 5 Science-Backed Strategies",
            excerpt: "Feeling stuck in your fitness journey? Learn how to overcome plateaus and continue making progress.",
            content: "Every fitness enthusiast faces plateaus at some point in their journey. These frustrating periods can make you feel like you're spinning your wheels...",
            author: {
                name: "Dr. Michael Chen",
                avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face",
                role: "Sports Scientist"
            },
            date: "June 9, 2025",
            readTime: "10 min read",
            image: "https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&h=400&fit=crop",
            tags: ['workouts', 'motivation'],
            likes: 156,
            comments: 31,
            featured: false
        },
        {
            id: 4,
            title: "The Psychology of Habit Formation: Building Lasting Fitness Routines",
            excerpt: "Understanding the science behind habit formation can help you create sustainable fitness routines that stick.",
            content: "Why do some people seem to effortlessly maintain their fitness routines while others struggle to stick with it for more than a few weeks?",
            author: {
                name: "Emma Wilson",
                avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face",
                role: "Behavioral Psychologist"
            },
            date: "June 8, 2025",
            readTime: "7 min read",
            image: "https://images.unsplash.com/photo-1594737625785-a6cbdabd333c?w=800&h=400&fit=crop",
            tags: ['motivation', 'lifestyle'],
            likes: 203,
            comments: 45,
            featured: false
        }
    ];

    const toggleLike = (postId) => {
        setLikedPosts(prev =>
            prev.includes(postId)
                ? prev.filter(id => id !== postId)
                : [...prev, postId]
        );
    };

    const filteredPosts = selectedTag === 'all'
        ? blogPosts
        : blogPosts.filter(post => post.tags.includes(selectedTag));

    const featuredPost = blogPosts.find(post => post.featured);

    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
            {/* Header */}
            <header className="bg-black/20 backdrop-blur-lg border-b border-white/10 sticky top-0 z-40">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-4">
                            <button className="text-white hover:text-purple-400 transition-colors">
                                <ArrowLeft className="h-6 w-6" />
                            </button>
                            <div className="flex items-center space-x-2">
                                <BookOpen className="h-6 w-6 text-purple-400" />
                                <h1 className="text-2xl font-bold text-white">Fitness Blog</h1>
                            </div>
                        </div>
                        <div className="text-sm text-gray-300">
                            {filteredPosts.length} {filteredPosts.length === 1 ? 'post' : 'posts'}
                        </div>
                    </div>
                </div>
            </header>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="lg:grid lg:grid-cols-4 lg:gap-8">
                    {/* Sidebar */}
                    <div className="lg:col-span-1 mb-8 lg:mb-0">
                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 p-6 sticky top-24">
                            <h3 className="text-lg font-bold text-white mb-4 flex items-center space-x-2">
                                <Tag className="h-5 w-5 text-purple-400" />
                                <span>Categories</span>
                            </h3>
                            <div className="space-y-2">
                                {tags.map((tag) => (
                                    <button
                                        key={tag.id}
                                        onClick={() => setSelectedTag(tag.id)}
                                        className={`w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors ${
                                            selectedTag === tag.id
                                                ? 'bg-purple-600 text-white'
                                                : 'text-gray-300 hover:bg-white/5 hover:text-white'
                                        }`}
                                    >
                                        <span>{tag.name}</span>
                                        <span className="text-xs opacity-75">({tag.count})</span>
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Main Content */}
                    <div className="lg:col-span-3">
                        {/* Featured Post */}
                        {featuredPost && selectedTag === 'all' && (
                            <div className="mb-12">
                                <div className="flex items-center space-x-2 mb-4">
                                    <div className="w-2 h-2 bg-purple-400 rounded-full"></div>
                                    <span className="text-purple-400 font-medium">Featured Post</span>
                                </div>
                                <article className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden hover:bg-white/10 transition-all group">
                                    <img
                                        src={featuredPost.image}
                                        alt={featuredPost.title}
                                        className="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                                    />
                                    <div className="p-8">
                                        <div className="flex items-center space-x-2 mb-4">
                                            {featuredPost.tags.map((tag) => (
                                                <span
                                                    key={tag}
                                                    className="px-3 py-1 bg-purple-600/20 text-purple-400 text-sm rounded-full"
                                                >
                          {tags.find(t => t.id === tag)?.name}
                        </span>
                                            ))}
                                        </div>
                                        <h2 className="text-2xl font-bold text-white mb-4 group-hover:text-purple-400 transition-colors">
                                            {featuredPost.title}
                                        </h2>
                                        <p className="text-gray-300 mb-6">
                                            {featuredPost.excerpt}
                                        </p>
                                        <div className="flex items-center justify-between">
                                            <div className="flex items-center space-x-4">
                                                <img
                                                    src={featuredPost.author.avatar}
                                                    alt={featuredPost.author.name}
                                                    className="w-12 h-12 rounded-full"
                                                />
                                                <div>
                                                    <p className="text-white font-medium">{featuredPost.author.name}</p>
                                                    <p className="text-gray-400 text-sm">{featuredPost.author.role}</p>
                                                </div>
                                            </div>
                                            <div className="flex items-center space-x-4 text-sm text-gray-400">
                                                <div className="flex items-center space-x-1">
                                                    <Calendar className="h-4 w-4" />
                                                    <span>{featuredPost.date}</span>
                                                </div>
                                                <div className="flex items-center space-x-1">
                                                    <Clock className="h-4 w-4" />
                                                    <span>{featuredPost.readTime}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="flex items-center justify-between mt-6 pt-6 border-t border-white/10">
                                            <div className="flex items-center space-x-6">
                                                <button
                                                    onClick={() => toggleLike(featuredPost.id)}
                                                    className={`flex items-center space-x-2 transition-colors ${
                                                        likedPosts.includes(featuredPost.id)
                                                            ? 'text-red-400'
                                                            : 'text-gray-400 hover:text-red-400'
                                                    }`}
                                                >
                                                    <Heart className={`h-5 w-5 ${likedPosts.includes(featuredPost.id) ? 'fill-current' : ''}`} />
                                                    <span>{featuredPost.likes + (likedPosts.includes(featuredPost.id) ? 1 : 0)}</span>
                                                </button>
                                                <button className="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors">
                                                    <MessageCircle className="h-5 w-5" />
                                                    <span>{featuredPost.comments}</span>
                                                </button>
                                            </div>
                                            <button className="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors">
                                                <Share2 className="h-5 w-5" />
                                                <span>Share</span>
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        )}

                        {/* Blog Posts Grid */}
                        <div className="space-y-8">
                            <h2 className="text-2xl font-bold text-white">
                                {selectedTag === 'all' ? 'Latest Posts' : `${tags.find(t => t.id === selectedTag)?.name} Posts`}
                            </h2>

                            {filteredPosts.filter(post => !post.featured || selectedTag !== 'all').map((post) => (
                                <article
                                    key={post.id}
                                    className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 hover:bg-white/10 transition-all group"
                                >
                                    <div className="md:flex">
                                        <div className="md:w-1/3">
                                            <img
                                                src={post.image}
                                                alt={post.title}
                                                className="w-full h-48 md:h-full object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-t-none group-hover:scale-105 transition-transform duration-300"
                                            />
                                        </div>
                                        <div className="md:w-2/3 p-6">
                                            <div className="flex items-center space-x-2 mb-3">
                                                {post.tags.map((tag) => (
                                                    <span
                                                        key={tag}
                                                        className="px-2 py-1 bg-purple-600/20 text-purple-400 text-xs rounded-full"
                                                    >
                            {tags.find(t => t.id === tag)?.name}
                          </span>
                                                ))}
                                            </div>
                                            <h3 className="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                                                {post.title}
                                            </h3>
                                            <p className="text-gray-300 mb-4">
                                                {post.excerpt}
                                            </p>
                                            <div className="flex items-center justify-between mb-4">
                                                <div className="flex items-center space-x-3">
                                                    <img
                                                        src={post.author.avatar}
                                                        alt={post.author.name}
                                                        className="w-8 h-8 rounded-full"
                                                    />
                                                    <div>
                                                        <p className="text-white text-sm font-medium">{post.author.name}</p>
                                                        <p className="text-gray-400 text-xs">{post.author.role}</p>
                                                    </div>
                                                </div>
                                                <div className="flex items-center space-x-3 text-xs text-gray-400">
                                                    <div className="flex items-center space-x-1">
                                                        <Calendar className="h-3 w-3" />
                                                        <span>{post.date}</span>
                                                    </div>
                                                    <div className="flex items-center space-x-1">
                                                        <Clock className="h-3 w-3" />
                                                        <span>{post.readTime}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="flex items-center justify-between pt-4 border-t border-white/10">
                                                <div className="flex items-center space-x-4">
                                                    <button
                                                        onClick={() => toggleLike(post.id)}
                                                        className={`flex items-center space-x-1 text-sm transition-colors ${
                                                            likedPosts.includes(post.id)
                                                                ? 'text-red-400'
                                                                : 'text-gray-400 hover:text-red-400'
                                                        }`}
                                                    >
                                                        <Heart className={`h-4 w-4 ${likedPosts.includes(post.id) ? 'fill-current' : ''}`} />
                                                        <span>{post.likes + (likedPosts.includes(post.id) ? 1 : 0)}</span>
                                                    </button>
                                                    <button className="flex items-center space-x-1 text-sm text-gray-400 hover:text-white transition-colors">
                                                        <MessageCircle className="h-4 w-4" />
                                                        <span>{post.comments}</span>
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

                        {/* Load More */}
                        <div className="text-center mt-12">
                            <button className="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                                Load More Posts
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Blog;