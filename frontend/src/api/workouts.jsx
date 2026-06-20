// Future development to separate API calls into their own files for better organization and maintainability.
// NOT CURRENTLY IN USE
import API from '../services/api';

export const getUserWorkouts = () => API.get('/user/workouts');
export const addWorkout = (data) => API.post('/user/workouts', data);

// Admin-only calls
export const getAllWorkouts = () => API.get('/admin/workouts');
