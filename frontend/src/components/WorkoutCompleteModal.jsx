/* ---------------------------------------------------------------- */
/* Workout Completed - Greetings Pop-up                             */
/* ---------------------------------------------------------------- */
import { Trophy, X, TrendingUp, Flame, Clock } from 'lucide-react';

/**
 * Congratulatory modal shown when the user finishes 100% of today's workout.
 *
 * Props:
 *  - workout: the completed workout (used for name / duration / calories)
 *  - onClose: close the modal and stay on the current section
 *  - onViewProgress: close the modal and jump to the Progress section
 */
export const WorkoutCompleteModal = ({ workout, onClose, onViewProgress }) => {
    return (
        <div
            className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            onClick={onClose}
        >
            <div
                className="relative w-full max-w-md bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-white/10 shadow-2xl p-8 text-center"
                onClick={(e) => e.stopPropagation()}
            >
                <button
                    onClick={onClose}
                    className="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors"
                    aria-label="Close"
                >
                    <X className="h-5 w-5" />
                </button>

                <div className="mx-auto mb-6 w-20 h-20 rounded-full bg-gradient-to-r from-yellow-400 to-orange-400 flex items-center justify-center shadow-lg">
                    <Trophy className="h-10 w-10 text-white" />
                </div>

                <h2 className="text-3xl font-bold text-white mb-2">Congratulations! 🎉</h2>
                <p className="text-gray-300 mb-6">
                    You completed <span className="font-semibold text-white">{workout?.name || "today's workout"}</span> at 100%.
                    Awesome work — see you tomorrow!
                </p>

                <div className="grid grid-cols-2 gap-4 mb-8">
                    <div className="bg-white/5 rounded-xl border border-white/10 p-4">
                        <Clock className="h-5 w-5 text-green-400 mx-auto mb-1" />
                        <p className="text-lg font-bold text-white">{workout?.total_duration || 0} min</p>
                        <p className="text-xs text-gray-400">Duration</p>
                    </div>
                    <div className="bg-white/5 rounded-xl border border-white/10 p-4">
                        <Flame className="h-5 w-5 text-orange-400 mx-auto mb-1" />
                        <p className="text-lg font-bold text-white">{workout?.calories_burned || 0} kcal</p>
                        <p className="text-xs text-gray-400">Calories</p>
                    </div>
                </div>

                <div className="flex flex-col sm:flex-row gap-3">
                    <button
                        onClick={onViewProgress}
                        className="flex-1 flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-purple-600 transition-colors"
                    >
                        <TrendingUp className="h-5 w-5" />
                        <span>View Progress</span>
                    </button>
                    <button
                        onClick={onClose}
                        className="flex-1 px-6 py-3 bg-white/5 text-white rounded-lg font-semibold border border-white/10 hover:bg-white/10 transition-colors"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    );
};
