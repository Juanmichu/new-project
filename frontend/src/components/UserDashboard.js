import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import {
    Calendar, Dumbbell, User, LogOut, Menu, X, Clock, Target, TrendingUp,
    CheckCircle, Flame, Activity, Star, Save
} from 'lucide-react';
import { useAuth } from '../hooks/useAuth';
import { useWorkouts } from '../hooks/useWorkouts';
import { useStats } from '../hooks/useStats';
import { TodaySection } from "./UserTodayWorkout";
import { ProgressSection } from "./UserProgressSection";
import { ProfileSection } from "./UserProfileSection";

const NAV_ITEMS = [
    { key: 'today', label: "Today's Workout", icon: Calendar },
    { key: 'progress', label: 'Progress', icon: TrendingUp },
    { key: 'profile', label: 'Profile', icon: User },
];

export const UserDashboard = () => {
    const navigate = useNavigate();
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);
    const [activeSection, setActiveSection] = useState('today');
    const { user, logout, updateProfile } = useAuth();
    const { todayWorkout, markExerciseComplete } = useWorkouts();
    const { dashboardStats, progressStats, loading: statsLoading } = useStats();

    const handleLogout = async () => {
        await logout();
        navigate('/');
    };

    const handleExerciseToggle = async (workoutExercise) => {
        if (todayWorkout) {
            await markExerciseComplete(
                todayWorkout.id,
                workoutExercise.id,
                !workoutExercise.completed
            );
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

    const goToSection = (key) => {
        setActiveSection(key);
        setIsSidebarOpen(false);
    };

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
                    {NAV_ITEMS.map(({ key, label, icon: Icon }) => (
                        <button
                            key={key}
                            onClick={() => goToSection(key)}
                            className={`flex items-center space-x-3 px-4 py-3 rounded-lg w-full text-left transition-colors ${
                                activeSection === key
                                    ? 'text-blue-400 bg-blue-400/10'
                                    : 'text-white hover:text-blue-400 hover:bg-white/5'
                            }`}
                        >
                            <Icon className="h-5 w-5" />
                            <span>{label}</span>
                        </button>
                    ))}
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
                                <p className="text-gray-300">
                                    {activeSection === 'today' && "Ready for today's workout?"}
                                    {activeSection === 'progress' && 'Here is how you have been doing.'}
                                    {activeSection === 'profile' && 'Manage your account details.'}
                                </p>
                            </div>
                        </div>

                        <div className="flex items-center space-x-4">
                            {activeSection === 'today' && (
                                <div className="hidden sm:block text-right">
                                    <p className="text-sm text-gray-300">Today's Progress</p>
                                    <p className="text-xl font-bold text-blue-400">{completionPercentage}% Complete</p>
                                </div>
                            )}
                            <div className="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                                <User className="h-6 w-6 text-white" />
                            </div>
                        </div>
                    </div>
                </header>

                {/* Dashboard Content */}
                <main className="p-6">
                    {activeSection === 'today' && (
                        <TodaySection
                            todayWorkout={todayWorkout}
                            completionPercentage={completionPercentage}
                            onToggleExercise={handleExerciseToggle}
                        />
                    )}
                    {activeSection === 'progress' && (
                        <ProgressSection
                            dashboardStats={dashboardStats}
                            progressStats={progressStats}
                        />
                    )}
                    {activeSection === 'profile' && (
                        <ProfileSection user={user} updateProfile={updateProfile} />
                    )}
                </main>
            </div>
        </div>
    );
};
