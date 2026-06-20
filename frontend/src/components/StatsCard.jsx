import React from "react";

export const StatCard = ({ label, value, icon: Icon, color }) => {
    return (
        <div className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10">
            <div className="flex items-center justify-between">
                <div>
                    <p className="text-gray-300 text-sm">{label}</p>
                    <p className="text-3xl font-bold text-white">{value}</p>
                </div>
                <Icon className={`h-12 w-12 ${color}`}/>
            </div>
        </div>
    );
};