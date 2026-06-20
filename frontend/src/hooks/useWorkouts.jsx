import { useState, useEffect } from 'react';
import { workoutAPI, statsAPI } from '../services/api';

export const useWorkouts = () => {
    const [workouts, setWorkouts] = useState([]);
    const [todayWorkout, setTodayWorkout] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const fetchWorkouts = async () => {
        try {
            setLoading(true);
            const response = await workoutAPI.getWorkouts();
            /* @var response.data.data is structured as { current_page, data:[...] } */
            setWorkouts(response.data.data.data);
        } catch (error) {
            setError(error.response?.data?.message || 'Failed to fetch workouts');
        } finally {
            setLoading(false);
        }
    };

    const fetchTodayWorkout = async () => {
        try {
            const response = await workoutAPI.getTodayWorkout();
            setTodayWorkout(response.data.data);
        } catch (error) {
            console.error('Failed to fetch today\'s workout:', error);
        }
    };

    const markExerciseComplete = async (workoutId, exerciseId, completed) => {
        try {
            await workoutAPI.markExerciseComplete(workoutId, exerciseId, completed);
            // Update local state with the new completion value. Use a functional
            // update so we always build on the latest state, never a stale closure.
            setTodayWorkout(prev => {
                if (!prev || prev.id !== workoutId) {
                    return prev;
                }
                const updatedExercises = prev.exercises.map(ex =>
                    ex.id === exerciseId ? { ...ex, completed } : ex
                );
                return { ...prev, exercises: updatedExercises };
            });
        } catch (error) {
            console.error('Failed to update exercise:', error);
        }
    };

    /**
     * Marks the whole workout as completed (logs a session and locks it).
     * Returns the API response so callers can react (e.g. show a popup),
     * or null if the request failed.
     */
    const completeWorkout = async (workoutId) => {
        try {
            const response = await workoutAPI.completeWorkout(workoutId);
            // Reflect the locked/completed status locally. Use a functional update
            // so we don't clobber the latest exercises (e.g. the final exercise
            // that was just marked complete moments before this call).
            setTodayWorkout(prev =>
                prev && prev.id === workoutId ? { ...prev, status: 'completed' } : prev
            );
            return response.data;
        } catch (error) {
            console.error('Failed to complete workout:', error);
            return null;
        }
    };

    useEffect(() => {
        fetchWorkouts();
        fetchTodayWorkout();
    }, []);

    return {
        workouts,
        todayWorkout,
        loading,
        error,
        fetchWorkouts,
        fetchTodayWorkout,
        markExerciseComplete,
        completeWorkout,
    };
};