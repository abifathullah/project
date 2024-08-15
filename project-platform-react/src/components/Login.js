import React, { useState } from 'react';
import authService from '../services/authService';
import { Container, TextField, Button, Typography, Box } from '@mui/material';

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await authService.login(email, password);
            
            if (response.data && response.data.token) { // Ensure the response contains the token
                localStorage.setItem('user', JSON.stringify(response.data)); // Save the entire response or just the token
                window.location.href = '/home'; // Redirect after login
            } else {
                console.error('Login response does not contain the expected token.');
            }
        } catch (error) {
            console.error('Login failed', error);
        }
    };

    return (
        <Container component="main" maxWidth="xs">
            <Box
                sx={{
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    mt: 8,
                }}
            >
                <Typography variant="h5">Login</Typography>
                <Box
                    component="form"
                    onSubmit={handleSubmit}
                    sx={{
                        mt: 1,
                        width: '100%',
                        display: 'flex',
                        flexDirection: 'column',
                        gap: 2,
                    }}
                >
                    <TextField
                        variant="outlined"
                        required
                        fullWidth
                        label="Email"
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                    />
                    <TextField
                        variant="outlined"
                        required
                        fullWidth
                        label="Password"
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                    <Button
                        type="submit"
                        variant="contained"
                        color="primary"
                        fullWidth
                    >
                        Login
                    </Button>
                </Box>
            </Box>
        </Container>
    );
};

export default Login;
