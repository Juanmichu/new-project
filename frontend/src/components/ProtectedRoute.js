import React from 'react';
import { useAuth } from '../hooks/useAuth';
import { LoginPage } from './AuthPages';

export const ProtectedRoute = ({ children, onNavigate }) => {
    const { isAuthenticated, loading } = useAuth();

    if (loading) {
        return (
            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center">
                <div className="text-white text-xl">Loading...</div>
            </div>
        );
    }

    if (!isAuthenticated) {
        return <LoginPage onNavigate={onNavigate} />;
    }

    return children;
};