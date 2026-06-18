/* ---------------------------------------------------------------- */
/* Profile                                                          */
/* ---------------------------------------------------------------- */

import {useEffect, useState} from "react";
import { Field } from "./Field";
import { User, Save } from 'lucide-react';

const FITNESS_GOALS = [
    'weight_loss', 'muscle_gain', 'strength', 'endurance', 'flexibility', 'general_fitness'
];

export const ProfileSection = ({ user, updateProfile }) => {

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