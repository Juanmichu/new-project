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
            // Update local state with the new completion value
            if (todayWorkout && todayWorkout.id === workoutId) {
                const updatedExercises = todayWorkout.exercises.map(ex =>
                    ex.id === exerciseId ? { ...ex, completed } : ex
                );
                setTodayWorkout({ ...todayWorkout, exercises: updatedExercises });
            }
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
            // Reflect the locked/completed status locally.
            if (todayWorkout && todayWorkout.id === workoutId) {
                setTodayWorkout({ ...todayWorkout, status: 'completed' });
            }
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