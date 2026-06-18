import React from "react";

export const ProgressRing = ({ percentage }) => {
    return (
        <div className="w-16 h-16 relative">
            <svg className="w-16 h-16 transform -rotate-90">
                <circle cx="32" cy="32" r="28" stroke="currentColor" strokeWidth="4" fill="transparent"
                        className="text-white/20"/>
                <circle
                    cx="32" cy="32" r="28" stroke="currentColor" strokeWidth="4" fill="transparent"
                    strokeDasharray={`${(percentage / 100) * 176} 176`}
                    className="text-blue-400"
                />
            </svg>
            <div className="absolute inset-0 flex items-center justify-center">
                <span className="text-sm font-bold text-white">{percentage}%</span>
            </div>
        </div>
    )
};