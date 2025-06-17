import React, { useState } from 'react';
import { Calendar, Dumbbell, User, LogOut, Menu, X, Clock, Target, TrendingUp, CheckCircle } from 'lucide-react';

const Dashboard = () => {
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);
    const [completedExercises, setCompletedExercises] = useState([]);

    // Mock data for today's workout
    const todayWorkout = {
        name: "Upper Body Strength",
        date: "June 11, 2025",
        duration: "45 minutes",
        exercises: [
            { id: 1, name: "Push-ups", sets: 3, reps: 15, rest: "60s" },
            { id: 2, name: "Pull-ups", sets: 3, reps: 8, rest: "90s" },
            { id: 3, name: "Bench Press", sets: 4, reps: 10, rest: "120s" },
            { id: 4, name: "Shoulder Press", sets: 3, reps: 12, rest: "60s" },
            { id: 5, name: "Bicep Curls", sets: 3, reps: 15, rest: "45s" }
        ]
    };

    const toggleExerciseComplete = (exerciseId) => {
        setCompletedExercises(prev =>
            prev.includes(exerciseId)
                ? prev.filter(id => id !== exerciseId)
                : [...prev, exerciseId]
        );
    };

    const completionPercentage = Math.round((completedExercises.length / todayWorkout.exercises.length) * 100);

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
                    <a href="#dashboard" className="flex items-center space-x-3 text-blue-400 bg-blue-400/10 px-4 py-3 rounded-lg">
                        <Calendar className="h-5 w-5" />
                        <span>Today's Workout</span>
                    </a>
                    <a href="#progress" className="flex items-center space-x-3 text-white hover:text-blue-400 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors">
                        <TrendingUp className="h-5 w-5" />
                        <span>Progress</span>
                    </a>
                    <a href="#profile" className="flex items-center space-x-3 text-white hover:text-blue-400 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors">
                        <User className="h-5 w-5" />
                        <span>Profile</span>
                    </a>
                </nav>

                <div className="absolute bottom-6 left-6 right-6">
                    <button className="flex items-center space-x-3 text-white hover:text-red-400 w-full px-4 py-3 rounded-lg hover:bg-white/5 transition-colors">
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
                                <h1 className="text-2xl font-bold text-white">Welcome back, John!</h1>
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
                                    <p className="text-3xl font-bold text-white">{todayWorkout.duration}</p>
                                </div>
                                <Clock className="h-12 w-12 text-green-400" />
                            </div>
                        </div>

                        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-300 text-sm">Exercises</p>
                                    <p className="text-3xl font-bold text-white">{completedExercises.length}/{todayWorkout.exercises.length}</p>
                                </div>
                                <Dumbbell className="h-12 w-12 text-purple-400" />
                            </div>
                        </div>
                    </div>

                    {/* Today's Workout */}
                    <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden">
                        <div className="p-6 border-b border-white/10">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h2 className="text-2xl font-bold text-white">{todayWorkout.name}</h2>
                                    <p className="text-gray-300">{todayWorkout.date}</p>
                                </div>
                                <div className="text-right">
                                    <div className="w-16 h-16 relative">
                                        <svg className="w-16 h-16 transform -rotate-90">
                                            <circle cx="32" cy="32" r="28" stroke="currentColor" strokeWidth="4" fill="transparent" className="text-white/20"/>
                                            <circle
                                                cx="32"
                                                cy="32"
                                                r="28"
                                                stroke="currentColor"
                                                strokeWidth="4"
                                                fill="transparent"
                                                strokeDasharray={`${completionPercentage * 1.76} 176`}
                                                className="text-blue-400"
                                            />
                                        </svg>
                                        <div className="absolute inset-0 flex items-center justify-center">
                                            <span className="text-sm font-bold text-white">{completionPercentage}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="p-6">
                            <div className="space-y-4">
                                {todayWorkout.exercises.map((exercise) => {
                                    const isCompleted = completedExercises.includes(exercise.id);
                                    return (
                                        <div
                                            key={exercise.id}
                                            className={`p-4 rounded-lg border transition-all cursor-pointer ${
                                                isCompleted
                                                    ? 'bg-green-500/10 border-green-500/30'
                                                    : 'bg-white/5 border-white/10 hover:bg-white/10'
                                            }`}
                                            onClick={() => toggleExerciseComplete(exercise.id)}
                                        >
                                            <div className="flex items-center justify-between">
                                                <div className="flex items-center space-x-4">
                                                    <div className={`w-6 h-6 rounded-full border-2 flex items-center justify-center ${
                                                        isCompleted
                                                            ? 'bg-green-500 border-green-500'
                                                            : 'border-white/30'
                                                    }`}>
                                                        {isCompleted && <CheckCircle className="h-4 w-4 text-white" />}
                                                    </div>
                                                    <div>
                                                        <h3 className={`font-semibold ${isCompleted ? 'text-green-400' : 'text-white'}`}>
                                                            {exercise.name}
                                                        </h3>
                                                        <p className="text-gray-300 text-sm">
                                                            {exercise.sets} sets × {exercise.reps} reps • Rest: {exercise.rest}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    );
};

export default Dashboard;