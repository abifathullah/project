import React from 'react';
import { Menu, Container, Button } from 'semantic-ui-react';
import { useNavigate } from 'react-router-dom';

const Header = () => {
  const navigate = useNavigate();

  const handleLogout = () => {
    // Clear user session or token
    localStorage.removeItem('user');
    // Navigate to login page
    navigate('/');
  };

  return (
    <Menu inverted>
      <Container>
        <Menu.Item header>My App</Menu.Item>
        <Menu.Item name='home' />
        <Menu.Item name='about' />
        <Menu.Item position='right'>
          <Button primary onClick={handleLogout}>Logout</Button>
        </Menu.Item>
      </Container>
    </Menu>
  );
};

export default Header;
