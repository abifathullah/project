import React, { useState } from 'react';
import authService from '../services/authService';
import { Container } from 'semantic-ui-react';

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    // In the handleSubmit function of the Login component
    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await authService.login(email, password);
            // console.log(response.data.token);
            
            if (response.data && response.data.token) { // Ensure the response contains the token
                localStorage.setItem('user', JSON.stringify(response.data)); // Save the entire response or just the token
                window.location.href = '/dashboard'; // Redirect after login
            } else {
                console.error('Login response does not contain the expected token.');
            }
        } catch (error) {
            console.error('Login failed', error);
        }
    };

    return (
        <Container>
            <div>
                <h1>Login</h1>
                <form onSubmit={handleSubmit}>
                    <input
                        type="email"
                        placeholder="Email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                    />
                    <input
                        type="password"
                        placeholder="Password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                    <button type="submit">Login</button>
                </form>
            </div>
        </Container>
        
    );
};

export default Login;
