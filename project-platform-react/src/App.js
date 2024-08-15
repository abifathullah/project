import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './components/Login';
import Product from './components/Product';
import ProtectedRoute from './components/ProtectedRoute';
import Header from './components/Header';

const App = () => {
  return (
    <Router>
      <Header />
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/home" element={
          <ProtectedRoute>
            <Product />
          </ProtectedRoute>
        } />
      </Routes>
    </Router>
  );
};

export default App;
