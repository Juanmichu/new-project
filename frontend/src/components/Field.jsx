import React from "react";

export const Field = ({ label, children }) => (
    <div>
        <label className="block text-white text-sm font-medium mb-2">{label}</label>
        {children}
    </div>
);