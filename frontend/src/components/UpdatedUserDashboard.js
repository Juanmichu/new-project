import React, { useState, useEffect } from 'react';
import { Calendar, Dumbbell, User, LogOut, Menu, X, Clock, Target, TrendingUp, CheckCircle } from 'lucide-react';
import { useAuth } from '../hooks/useAuth';
import { useWorkouts } from '../hooks/useWorkouts';
import { useStats } from '../hooks/useStats';

export const UpdatedUserDashboard = ({ onNavigate }) => {
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);
    const { user, logout } = useAuth();
    const { todayWorkout, markExerciseComplete, fetchTodayWorkout } = useWorkouts();
    const { dashboardStats, loading: statsLoading } = useStats();

    const handleLogout = async () => {
        await logout();
        onNavigate('home');
    };

    const handleExerciseComplete = async (exerciseId) => {
        if (todayWorkout) {
            await markExerciseComplete(todayWorkout.id, exerciseId);
            fetchTodayWorkout(); // Refresh the workout data
        }
    };

    const getCompletionPercentage = () => {
        if (!todayWorkout || !todayWorkout.exercises || todayWorkout.exercises.length === 0) {
            return 0;
        }
        const completedCount = todayWorkout.exercises.filter(ex => ex.completed).length;
        return Math.round((completedCount / todayWorkout.exercises.length) * 100);
    };

    const completionPercentage = getCompletionPercentage();

    if (statsLoading) {
        return (
            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 flex items-center justify-center">
                <div className="text-white text-xl">Loading your dashboard...</div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
            {/* Mobile Sidebar Overlay */}
            {isSidebarOpen && (
                <div className="fixed inset-0 bg-black/50 z-40 lg:hidden" onClick={() => setIsSidebarOpen(false)}></div>
            )}

            {/* Sidebar */}
            <div className={`fixed inset-y-0 left-0 z-50 w-64 bg-black/20 backdrop-blur-lg border-r border-white/10 transform ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'} transition-transform lg:translate-x-0`}>
                <div className="flex items-center justify-between p-6 border-b border-white/10">
                    <div className="flex items-center space-x-2">
                        <Dumbbell className="h-8 w-8 text-blue-400" />
                        <span className="text-xl font-bold text-white">FitTracker</span>
                    </div>
                    <button className="lg:hidden text-white" onClick={() => setIsSidebarOpen(false)}>
                        <X className="h-6 w-6" />
                    </button>
                </div>

                <nav className="p-6 space-y-4">
                    <button className="flex items-center space-x-3 text-blue-400 bg-blue-400/10 px-4 py-3 rounded-lg w-full text-left">
                        <Calendar className="h-5 w-5" />
                        <span>Today's Workout</span>
                    </button>
                    <button className="flex items-center space-x-3 text-white hover:text-blue-400 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors w-full text-left">
                        <TrendingUp className="h-5 w-5" />
                        <span>Progress</span>
                    </button>
                    <button className="flex items-center space-x-3 text-white hover:text-blue-400 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors w-full text-left">
                        <User className="h-5 w-5" />
                        <span>Profile</span>
                    </button>
                </nav>

                <div className="absolute bottom-6 left-6 right-6">
                    <button
                        onClick={handleLogout}
                        className="flex items-center space-x-3 text-white hover:text-red-400 w-full px-4 py-3 rounded-lg hover:bg-white/5 transition-colors"
                    >
                        <LogOut className="h-5 w-5" />
                        <span>Logout</span>
                    </button>
                </div>
            </div>

            {/* Main Content */}
            <div className="lg:ml-64">
                {/* Header */}
                <header className="bg-black/20 backdrop-blur-lg border-b border-white/10 p-6">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-4">
                            <button
                                className="lg:hidden text-white"
                                onClick={() => setIsSidebarOpen(true)}
                            >
                                <Menu className="h-6 w-6" />
                            </button>
                            <div>
                                <h1 className="text-2xl font-bold text-white">Welcome back, {user?.name}!</h1>
                                <p className="text-gray-300">Ready for today's workout?</p>
                            </div>
                        </div>

                        <div className="flex items-center space-x-4">
                            <div className="hidden sm:block text-right">
                                <p className="text-sm text-gray-300">Today's Progress</p>
                                <p className="text-xl font-bold text-blue-400">{completionPercentage}% Complete</p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                                <User className="h-6 w-6 text-white" />
                            </div>
                        </div>
                    </div>
                </header>

                {/* Dashboard Content */}
                <main className="p-6">
                    {/* Stats Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-300 text-sm">Completion Rate</p>
                                    <p className="text-3xl font-bold text-white">{completionPercentage}%</p>
                                </div>
                                <Target className="h-12 w-12 text-blue-400" />
                            </div>
                        </div>

                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-300 text-sm">Duration</p>
                                    <p className="text-3xl font-bold text-white">{todayWorkout?.total_duration || 45} min</p>
                                </div>
                                <Clock className="h-12 w-12 text-green-400" />
                            </div>
                        </div>

                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-300 text-sm">Exercises</p>
                                    <p className="text-3xl font-bold text-white">
                                        {todayWorkout?.exercises?.filter(ex => ex.completed).length || 0}/
                                        {todayWorkout?.exercises?.length || 0}
                                    </p>
                                </div>
                                <Dumbbell className="h-12 w-12 text-purple-400" />
                            </div>
                        </div>
                    </div>

                    {/* Today's Workout */}
                    {todayWorkout ? (
                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden">
                            <div className="p-6 border-b border-white/10">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <h2 className="text-2xl font-bold text-white">{todayWorkout.name}</h2>
                                        <p className="text-gray-300">{new Date(todayWorkout.workout_date).toLocaleDateString()}</p>
                                    </div>
                                    <div className="text-right">
                                        <div className="w-16 h-16 relative">
                                            <div className="absolute inset-0 flex items-center justify-center">
                                                <span className="text-sm font-bold text-white">{completionPercentage}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="p-6">
                                <div className="space-y-4">
                                    {todayWorkout.exercises?.map((workoutExercise) => (
                                        <div
                                            key={workoutExercise.id}
                                            className={`p-4 rounded-lg border transition-all cursor-pointer ${
                                                workoutExercise.completed
                                                    ? 'bg-green-500/10 border-green-500/30'
                                                    : 'bg-white/5 border-white/10 hover:bg-white/10'
                                            }`}
                                            onClick={() => handleExerciseComplete(workoutExercise.id)}
                                        >
                                            <div className="flex items-center justify-between">
                                                <div className="flex items-center space-x-4">
                                                    <div className={`w-6 h-6 rounded-full border-2 flex items-center justify-center ${
                                                        workoutExercise.completed
                                                            ? 'bg-green-500 border-green-500'
                                                            : 'border-white/30'
                                                    }`}>
                                                        {workoutExercise.completed && <CheckCircle className="h-4 w-4 text-white" />}
                                                    </div>
                                                    <div>
                                                        <h3 className={`font-semibold ${workoutExercise.completed ? 'text-green-400' : 'text-white'}`}>
                                                            {workoutExercise.exercise?.name || 'Exercise'}
                                                        </h3>
                                                        <p className="text-gray-300 text-sm">
                                                            {workoutExercise.sets} sets × {workoutExercise.reps} reps • Rest: {workoutExercise.rest_time}s
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    ) : (
                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 p-8 text-center">
                            <h2 className="text-2xl font-bold text-white mb-4">No Workout Today</h2>
                            <p className="text-gray-300 mb-6">Ready to start your fitness journey? Let's create a workout!</p>
                            <button className="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                Create Workout
                            </button>
                        </div>
                    )}
                </main>
            </div>
        </div>
    );
};