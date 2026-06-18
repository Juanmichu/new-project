import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import {
    Calendar, Dumbbell, User, LogOut, Menu, X, Clock, Target, TrendingUp,
    CheckCircle, Flame, Activity, Star, Save
} from 'lucide-react';
import { useAuth } from '../hooks/useAuth';
import { useWorkouts } from '../hooks/useWorkouts';
import { useStats } from '../hooks/useStats';

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
                todayWorkout._id,
                workoutExercise._id,
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

/* ---------------------------------------------------------------- */
/* Today's Workout                                                  */
/* ---------------------------------------------------------------- */
const TodaySection = ({ todayWorkout, completionPercentage, onToggleExercise }) => {
    const completedCount = todayWorkout?.exercises?.filter(ex => ex.completed).length || 0;
    const totalCount = todayWorkout?.exercises?.length || 0;

    return (
        <>
            {/* Stats Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <StatCard label="Completion Rate" value={`${completionPercentage}%`} icon={Target} color="text-blue-400" />
                <StatCard label="Duration" value={`${todayWorkout?.total_duration || 45} min`} icon={Clock} color="text-green-400" />
                <StatCard label="Exercises" value={`${completedCount}/${totalCount}`} icon={Dumbbell} color="text-purple-400" />
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
                            <ProgressRing percentage={completionPercentage} />
                        </div>
                    </div>

                    <div className="p-6">
                        <div className="space-y-4">
                            {todayWorkout.exercises?.map((workoutExercise) => (
                                <div
                                    key={workoutExercise._id}
                                    className={`p-4 rounded-lg border transition-all cursor-pointer ${
                                        workoutExercise.completed
                                            ? 'bg-green-500/10 border-green-500/30'
                                            : 'bg-white/5 border-white/10 hover:bg-white/10'
                                    }`}
                                    onClick={() => onToggleExercise(workoutExercise)}
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
        </>
    );
};

/* ---------------------------------------------------------------- */
/* Progress                                                         */
/* ---------------------------------------------------------------- */
const ProgressSection = ({ dashboardStats, progressStats }) => {
    const sessions = progressStats?.sessions || [];
    const maxDuration = Math.max(1, ...sessions.map(s => s.duration || 0));

    return (
        <>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <StatCard
                    label="Total Workouts"
                    value={progressStats?.total_workouts ?? dashboardStats?.total_workouts ?? 0}
                    icon={Dumbbell}
                    color="text-purple-400"
                />
                <StatCard
                    label="This Week"
                    value={dashboardStats?.week_workouts ?? 0}
                    icon={Calendar}
                    color="text-blue-400"
                />
                <StatCard
                    label="Calories Burned"
                    value={progressStats?.total_calories ?? 0}
                    icon={Flame}
                    color="text-orange-400"
                />
                <StatCard
                    label="Avg Duration"
                    value={`${progressStats?.avg_duration ?? 0} min`}
                    icon={Clock}
                    color="text-green-400"
                />
            </div>

            <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden">
                <div className="p-6 border-b border-white/10 flex items-center justify-between">
                    <div className="flex items-center space-x-3">
                        <Activity className="h-6 w-6 text-blue-400" />
                        <h2 className="text-xl font-bold text-white">Recent Sessions (Last 30 days)</h2>
                    </div>
                    {progressStats?.avg_rating ? (
                        <div className="flex items-center space-x-1 text-yellow-400">
                            <Star className="h-5 w-5 fill-current" />
                            <span className="font-semibold">{progressStats.avg_rating}</span>
                            <span className="text-gray-400 text-sm">avg rating</span>
                        </div>
                    ) : null}
                </div>

                <div className="p-6">
                    {sessions.length === 0 ? (
                        <p className="text-gray-300 text-center py-8">
                            No completed sessions yet. Finish a workout to start tracking your progress!
                        </p>
                    ) : (
                        <div className="space-y-4">
                            {sessions.map((session) => (
                                <div key={session._id} className="flex items-center space-x-4">
                                    <div className="w-28 shrink-0 text-sm text-gray-300">
                                        {session.completed_at
                                            ? new Date(session.completed_at).toLocaleDateString()
                                            : '—'}
                                    </div>
                                    <div className="flex-1 bg-white/5 rounded-full h-4 overflow-hidden">
                                        <div
                                            className="h-4 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full"
                                            style={{ width: `${Math.round(((session.duration || 0) / maxDuration) * 100)}%` }}
                                        ></div>
                                    </div>
                                    <div className="w-20 shrink-0 text-right text-sm text-white">
                                        {session.duration || 0} min
                                    </div>
                                    <div className="w-24 shrink-0 text-right text-sm text-orange-400">
                                        {session.calories_burned || 0} kcal
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </>
    );
};

/* ---------------------------------------------------------------- */
/* Profile                                                          */
/* ---------------------------------------------------------------- */
const FITNESS_GOALS = [
    'weight_loss', 'muscle_gain', 'strength', 'endurance', 'flexibility', 'general_fitness'
];

const ProfileSection = ({ user, updateProfile }) => {
    const [form, setForm] = useState({
        name: '', age: '', weight: '', height: '', fitness_level: 'beginner', goals: []
    });
    const [saving, setSaving] = useState(false);
    const [message, setMessage] = useState(null); // { type: 'success' | 'error', text }

    useEffect(() => {
        if (user) {
            setForm({
                name: user.name || '',
                age: user.age || '',
                weight: user.weight || '',
                height: user.height || '',
                fitness_level: user.fitness_level || 'beginner',
                goals: user.goals || []
            });
        }
    }, [user]);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const toggleGoal = (goal) => {
        setForm(prev => ({
            ...prev,
            goals: prev.goals.includes(goal)
                ? prev.goals.filter(g => g !== goal)
                : [...prev.goals, goal]
        }));
    };

    const bmi = () => {
        if (!form.weight || !form.height) return null;
        const meters = form.height / 100;
        return (form.weight / (meters * meters)).toFixed(1);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSaving(true);
        setMessage(null);

        // Only send filled fields; coerce numerics so backend validation passes.
        const payload = {
            name: form.name,
            fitness_level: form.fitness_level,
            goals: form.goals,
        };
        if (form.age !== '') payload.age = Number(form.age);
        if (form.weight !== '') payload.weight = Number(form.weight);
        if (form.height !== '') payload.height = Number(form.height);

        const result = await updateProfile(payload);
        if (result.success) {
            setMessage({ type: 'success', text: 'Profile updated successfully.' });
        } else {
            setMessage({ type: 'error', text: result.error || 'Failed to update profile.' });
        }
        setSaving(false);
    };

    const currentBmi = bmi();

    return (
        <div className="max-w-3xl">
            <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 p-8">
                <div className="flex items-center space-x-3 mb-6">
                    <User className="h-6 w-6 text-blue-400" />
                    <h2 className="text-2xl font-bold text-white">Your Profile</h2>
                </div>

                {message && (
                    <div className={`rounded-lg p-4 mb-6 border ${
                        message.type === 'success'
                            ? 'bg-green-500/10 border-green-500/20 text-green-400'
                            : 'bg-red-500/10 border-red-500/20 text-red-400'
                    }`}>
                        <p className="text-sm">{message.text}</p>
                    </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <Field label="Full Name">
                            <input
                                type="text" name="name" value={form.name} onChange={handleChange}
                                className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:bg-white/10 transition-all"
                                required
                            />
                        </Field>
                        <Field label="Email">
                            <input
                                type="email" value={user?.email || ''} disabled
                                className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white opacity-60 cursor-not-allowed"
                            />
                        </Field>
                        <Field label="Age">
                            <input
                                type="number" name="age" value={form.age} onChange={handleChange}
                                min="13" max="120"
                                className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:bg-white/10 transition-all"
                            />
                        </Field>
                        <Field label="Fitness Level">
                            <select
                                name="fitness_level" value={form.fitness_level} onChange={handleChange}
                                className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-blue-400 focus:bg-white/10 transition-all"
                            >
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </Field>
                        <Field label="Weight (kg)">
                            <input
                                type="number" name="weight" value={form.weight} onChange={handleChange}
                                min="30" max="500" step="0.1"
                                className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:bg-white/10 transition-all"
                            />
                        </Field>
                        <Field label="Height (cm)">
                            <input
                                type="number" name="height" value={form.height} onChange={handleChange}
                                min="100" max="250" step="0.1"
                                className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:bg-white/10 transition-all"
                            />
                        </Field>
                    </div>

                    {currentBmi && (
                        <div className="bg-white/5 border border-white/10 rounded-lg p-4 flex items-center justify-between">
                            <span className="text-gray-300">Body Mass Index (BMI)</span>
                            <span className="text-xl font-bold text-blue-400">{currentBmi}</span>
                        </div>
                    )}

                    <div>
                        <label className="block text-white text-sm font-medium mb-4">Fitness Goals</label>
                        <div className="grid grid-cols-2 md:grid-cols-3 gap-3">
                            {FITNESS_GOALS.map((goal) => (
                                <button
                                    key={goal}
                                    type="button"
                                    onClick={() => toggleGoal(goal)}
                                    className={`px-4 py-2 rounded-lg text-sm transition-all ${
                                        form.goals.includes(goal)
                                            ? 'bg-purple-600 text-white'
                                            : 'bg-white/5 text-gray-300 hover:bg-white/10'
                                    }`}
                                >
                                    {goal.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                </button>
                            ))}
                        </div>
                    </div>

                    <button
                        type="submit"
                        disabled={saving}
                        className="flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <Save className="h-5 w-5" />
                        <span>{saving ? 'Saving...' : 'Save Changes'}</span>
                    </button>
                </form>
            </div>
        </div>
    );
};

/* ---------------------------------------------------------------- */
/* Shared small components                                          */
/* ---------------------------------------------------------------- */
const StatCard = ({ label, value, icon: Icon, color }) => (
    <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10">
        <div className="flex items-center justify-between">
            <div>
                <p className="text-gray-300 text-sm">{label}</p>
                <p className="text-3xl font-bold text-white">{value}</p>
            </div>
            <Icon className={`h-12 w-12 ${color}`} />
        </div>
    </div>
);

const ProgressRing = ({ percentage }) => (
    <div className="w-16 h-16 relative">
        <svg className="w-16 h-16 transform -rotate-90">
            <circle cx="32" cy="32" r="28" stroke="currentColor" strokeWidth="4" fill="transparent" className="text-white/20" />
            <circle
                cx="32" cy="32" r="28" stroke="currentColor" strokeWidth="4" fill="transparent"
                strokeDasharray={`${(percentage / 100) * 176} 176`}
                className="text-blue-400"
            />
        </svg>
        <div className="absolute inset-0 flex items-center justify-center">
            <span className="text-sm font-bold text-white">{percentage}%</span>
        </div>
    </div>
);

const Field = ({ label, children }) => (
    <div>
        <label className="block text-white text-sm font-medium mb-2">{label}</label>
        {children}
    </div>
);
