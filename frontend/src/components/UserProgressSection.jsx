/* ---------------------------------------------------------------- */
/* Progress                                                         */
/* ---------------------------------------------------------------- */
import {StatCard} from "./StatsCard";
import { Calendar, Dumbbell, Clock, Flame, Activity, Star } from 'lucide-react';

export const ProgressSection = ({ dashboardStats, progressStats }) => {
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
                                <div key={session.id} className="flex items-center space-x-4">
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