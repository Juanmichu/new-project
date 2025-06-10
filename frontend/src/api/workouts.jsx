// src/api/workouts.js
import API from './api';

export const getUserWorkouts = () => API.get('/user/workouts');
export const addWorkout = (data) => API.post('/user/workouts', data);

// Admin-only calls
export const getAllWorkouts = () => API.get('/admin/workouts');
