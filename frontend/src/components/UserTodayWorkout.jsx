
/* ---------------------------------------------------------------- */
/* Today's Workout                                                  */
/* ---------------------------------------------------------------- */
import {ProgressRing} from "./ProgressRing";
import {StatCard} from "./StatsCard";
import { Dumbbell, Clock, Target, CheckCircle, Trophy } from 'lucide-react';

export const TodaySection = ({ todayWorkout, completionPercentage, onToggleExercise, isCompleted = false }) => {
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

            {/* Completed banner */}
            {isCompleted && (
                <div className="mb-6 flex items-center space-x-3 bg-green-500/10 border border-green-500/30 rounded-2xl p-4">
                    <Trophy className="h-6 w-6 text-green-400 shrink-0" />
                    <div>
                        <p className="text-green-400 font-semibold">Workout completed for today!</p>
                        <p className="text-gray-300 text-sm">Come back tomorrow for a new session. You did very well today!</p>
                    </div>
                </div>
            )}

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
                                    key={workoutExercise.id}
                                    className={`p-4 rounded-lg border transition-all ${
                                        isCompleted ? 'cursor-not-allowed opacity-90' : 'cursor-pointer'
                                    } ${
                                        workoutExercise.completed
                                            ? 'bg-green-500/10 border-green-500/30'
                                            : 'bg-white/5 border-white/10 hover:bg-white/10'
                                    }`}
                                    onClick={() => !isCompleted && onToggleExercise(workoutExercise)}
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
                                                <p className="text-gray-300 text-sm">
                                                    {workoutExercise.weight ?? 'N/A'} kg  • {workoutExercise.duration ?? 'N/A'} secs
                                                </p>
                                                {workoutExercise.notes && (
                                                    <p className="text-gray-300 text-sm">
                                                        { workoutExercise.notes.split(',').map((note, index) => (
                                                            <p key={index}>{note}</p>
                                                            )
                                                        )}
                                                    </p>
                                                )}
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
                    <p className="text-gray-300 mb-6">Today just relax. Every athlete needs a day to take a break</p>
                </div>
            )}
        </>
    );
};