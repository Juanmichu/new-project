import axios from 'axios';

const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';

// Create axios instance
const api = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true,
});

// Request interceptor to add auth token
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('auth_token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Response interceptor to handle auth errors
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

// Auth API
export const authAPI = {
    register: (userData) => api.post('/auth/register', userData),
    login: (credentials) => api.post('/auth/login', credentials),
    logout: () => api.post('/auth/logout'),
    getUser: () => api.get('/auth/user'),
    updateProfile: (userData) => api.put('/user/profile', userData),
};

// Workout API
export const workoutAPI = {
    getWorkouts: (page = 1) => api.get(`/workouts?page=${page}`),
    getTodayWorkout: () => api.get('/workouts/today'),
    createWorkout: (workoutData) => api.post('/workouts', workoutData),
    getWorkout: (id) => api.get(`/workouts/${id}`),
    updateWorkout: (id, data) => api.put(`/workouts/${id}`, data),
    deleteWorkout: (id) => api.delete(`/workouts/${id}`),
    markExerciseComplete: (workoutId, exerciseId) =>
        api.post(`/workouts/${workoutId}/exercises/${exerciseId}/complete`),
};

// Exercise API
export const exerciseAPI = {
    getExercises: (params = {}) => {
        const queryString = new URLSearchParams(params).toString();
        return api.get(`/exercises${queryString ? `?${queryString}` : ''}`);
    },
    getExercise: (id) => api.get(`/exercises/${id}`),
    getCategories: () => api.get('/exercises/categories'),
};

// Article API (Blog)
export const articleAPI = {
    getArticles: (params = {}) => {
        const queryString = new URLSearchParams(params).toString();
        return api.get(`/articles${queryString ? `?${queryString}` : ''}`);
    },
    getArticle: (slug) => api.get(`/articles/${slug}`),
    likeArticle: (id) => api.post(`/articles/${id}/like`),
};

// News API
export const newsAPI = {
    getNews: (params = {}) => {
        const queryString = new URLSearchParams(params).toString();
        return api.get(`/news${queryString ? `?${queryString}` : ''}`);
    },
    getNewsArticle: (slug) => api.get(`/news/${slug}`),
    getBreakingNews: () => api.get('/news/breaking'),
};

// Stats API
export const statsAPI = {
    getDashboardStats: () => api.get('/stats/dashboard'),
    getProgressStats: () => api.get('/stats/progress'),
};

// Workout Session API
export const sessionAPI = {
    getSessions: (page = 1) => api.get(`/workout-sessions?page=${page}`),
    startSession: (workoutId, totalExercises) =>
        api.post('/workout-sessions', { workout_id: workoutId, total_exercises: totalExercises }),
    completeSession: (sessionId, data) =>
        api.put(`/workout-sessions/${sessionId}/complete`, data),
};

// Utility functions
export const setAuthToken = (token) => {
    if (token) {
        localStorage.setItem('auth_token', token);
    } else {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
    }
};

export const getAuthToken = () => {
    return localStorage.getItem('auth_token');
};

export const isAuthenticated = () => {
    return !!getAuthToken();
};

export default api;