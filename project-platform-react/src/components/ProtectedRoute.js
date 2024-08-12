import React from 'react';
import { Navigate } from 'react-router-dom';
import authService from '../services/authService';

const ProtectedRoute = ({ children }) => {
    if (!authService.getCurrentUser()) {
        return <Navigate to="/login" />;
    }

    return children;
};

export default ProtectedRoute;
