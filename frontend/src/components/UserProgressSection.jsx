/* ---------------------------------------------------------------- */
/* Progress                                                         */
/* ---------------------------------------------------------------- */
import {StatCard} from "./StatsCard";
import { Calendar, Dumbbell, Clock, Flame, Activity, Star, BarChart3 } from 'lucide-react';

/**
 * Builds 30 day-buckets (oldest → today) and counts how many sessions were
 * completed on each day. Used to draw the last-30-days progress chart.
 */
const buildDailyBuckets = (sessions) => {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const buckets = [];
    const indexByKey = {};
    for (let i = 29; i >= 0; i--) {
        const d = new Date(today);
        d.setDate(today.getDate() - i);
        indexByKey[d.toDateString()] = buckets.length;
        buckets.push({ date: d, count: 0 });
    }

    sessions.forEach((s) => {
        if (!s.completed_at) return;
        const cd = new Date(s.completed_at);
        cd.setHours(0, 0, 0, 0);
        const idx = indexByKey[cd.toDateString()];
        if (idx !== undefined) buckets[idx].count += 1;
    });

    return buckets;
};

const WorkoutProgressChart = ({ sessions }) => {
    const buckets = buildDailyBuckets(sessions);
    const maxCount = Math.max(1, ...buckets.map((b) => b.count));

    return (
        <div className="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 overflow-hidden mb-8">
            <div className="p-6 border-b border-white/10 flex items-center space-x-3">
                <BarChart3 className="h-6 w-6 text-blue-400" />
                <h2 className="text-xl font-bold text-white">Completed Sessions (Last 30 days)</h2>
            </div>

            <div className="p-6">
                <div className="flex items-end justify-between gap-1 h-40">
                    {buckets.map((b, idx) => {
                        const heightPct = b.count > 0 ? Math.max(8, (b.count / maxCount) * 100) : 0;
                        const label = b.date.toLocaleDateString(undefined, { month: 'short', day: 'numeric' });
                        return (
                            <div key={idx} className="flex-1 h-full flex flex-col justify-end" title={`${label}: ${b.count} session${b.count === 1 ? '' : 's'}`}>
                                <div
                                    className={`w-full rounded-t ${b.count > 0 ? 'bg-gradient-to-t from-blue-500 to-purple-400' : 'bg-white/5'}`}
                                    style={{ height: b.count > 0 ? `${heightPct}%` : '2px' }}
                                ></div>
                            </div>
                        );
                    })}
                </div>

                {/* X-axis: show a few date markers across the range */}
                <div className="flex justify-between mt-3 text-xs text-gray-400">
                    {[0, 9, 19, 29].map((i) => (
                        <span key={i}>
                            {buckets[i]?.date.toLocaleDateString(undefined, { month: 'short', day: 'numeric' })}
                        </span>
                    ))}
                </div>
            </div>
        </div>
    );
};

export const ProgressSection = ({ dashboardStats, progressStats }) => {
    const sessions = progressStats?.sessions || [];
    const maxDuration = Math.max(1, ...sessions.map(s => s.duration || 0));

    return (
        <>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <StatCard
                    label="Workouts Completed"
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

            {/* 30-day completed-sessions chart */}
            <WorkoutProgressChart sessions={sessions} />

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