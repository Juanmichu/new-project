import React from 'react';
import { ArrowRight, Dumbbell, Users, Calendar, Trophy } from 'lucide-react';

const Home = () => {
    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
            {/* Navigation */}
            <nav className="bg-black/20 backdrop-blur-lg border-b border-white/10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center py-4">
                        <div className="flex items-center space-x-2">
                            <Dumbbell className="h-8 w-8 text-purple-400" />
                            <span className="text-2xl font-bold text-white">JMSP</span>
                        </div>
                        <div className="hidden md:flex space-x-8">
                            <a href="#home" className="text-white hover:text-purple-400 transition-colors">Home</a>
                            <a href="#features" className="text-white hover:text-purple-400 transition-colors">Features</a>
                            <a href="#blog" className="text-white hover:text-purple-400 transition-colors">Blog</a>
                            <a href="#news" className="text-white hover:text-purple-400 transition-colors">News</a>
                        </div>
                        <div className="flex space-x-4">
                            <button className="px-4 py-2 text-white border border-white/20 rounded-lg hover:bg-white/10 transition-colors">
                                Login
                            </button>
                            <button className="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
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
                            <button className="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 flex items-center justify-center">
                                Get Started <ArrowRight className="ml-2 h-5 w-5" />
                            </button>
                            <button className="px-8 py-4 border border-white/20 text-white rounded-lg font-semibold hover:bg-white/10 transition-colors">
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
            <section id="features" className="py-24 bg-black/20">
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

            {/* CTA Section */}
            <section className="py-24">
                <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                    <h2 className="text-4xl font-bold text-white mb-6">Ready to Transform Your Fitness?</h2>
                    <p className="text-xl text-gray-300 mb-8">Join thousands of users who are already achieving their fitness goals with FitTracker.</p>
                    <button className="px-12 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105">
                        Start Your Journey Today
                    </button>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-black/40 border-t border-white/10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <div className="flex items-center space-x-2 mb-4 md:mb-0">
                            <Dumbbell className="h-6 w-6 text-purple-400" />
                            <span className="text-xl font-bold text-white">FitTracker</span>
                        </div>
                        <div className="text-gray-400 text-sm">
                            © 2025 FitTracker. All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
};

export default Home;