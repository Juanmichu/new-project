import { useState, useEffect } from 'react';
import { statsAPI } from '../services/api';

export const useStats = () => {
    const [dashboardStats, setDashboardStats] = useState(null);
    const [progressStats, setProgressStats] = useState(null);
    const [loading, setLoading] = useState(true);

    const fetchDashboardStats = async () => {
        try {
            const response = await statsAPI.getDashboardStats();
            setDashboardStats(response.data);
        } catch (error) {
            console.error('Failed to fetch dashboard stats:', error);
        }
    };

    const fetchProgressStats = async () => {
        try {
            const response = await statsAPI.getProgressStats();
            setProgressStats(response.data);
        } catch (error) {
            console.error('Failed to fetch progress stats:', error);
        }
    };

    useEffect(() => {
        const fetchStats = async () => {
            setLoading(true);
            await Promise.all([
                fetchDashboardStats(),
                fetchProgressStats()
            ]);
            setLoading(false);
        };

        fetchStats();
    }, []);

    return {
        dashboardStats,
        progressStats,
        loading,
        fetchDashboardStats,
        fetchProgressStats,
    };
};