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
            setWorkouts(response.data.data);
        } catch (error) {
            setError(error.response?.data?.message || 'Failed to fetch workouts');
        } finally {
            setLoading(false);
        }
    };

    const fetchTodayWorkout = async () => {
        try {
            const response = await workoutAPI.getTodayWorkout();
            setTodayWorkout(response.data);
        } catch (error) {
            console.error('Failed to fetch today\'s workout:', error);
        }
    };

    const markExerciseComplete = async (workoutId, exerciseId) => {
        try {
            await workoutAPI.markExerciseComplete(workoutId, exerciseId);
            // Update local state
            if (todayWorkout && todayWorkout.id === workoutId) {
                const updatedExercises = todayWorkout.exercises.map(ex =>
                    ex.id === exerciseId ? { ...ex, completed: true } : ex
                );
                setTodayWorkout({ ...todayWorkout, exercises: updatedExercises });
            }
        } catch (error) {
            console.error('Failed to mark exercise complete:', error);
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
    };
};