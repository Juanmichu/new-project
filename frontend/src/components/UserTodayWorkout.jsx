
/* ---------------------------------------------------------------- */
/* Today's Workout                                                  */
/* ---------------------------------------------------------------- */
import {ProgressRing} from "./ProgressRing";
import {StatCard} from "./StatsCard";
import { Dumbbell, Clock, Target, CheckCircle } from 'lucide-react';

export const TodaySection = ({ todayWorkout, completionPercentage, onToggleExercise }) => {
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