<template>
    <header class="navbar">
        <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />
        <nav>
            <RouterLink to="/home">Home</RouterLink>
            <RouterLink v-if="showLogoutButton" to="/product/add">Add Product</RouterLink>
            <RouterLink v-if="showLogoutButton" to="/about">About</RouterLink>
            <v-btn v-if="showLogoutButton" @click="logout" color="primary">Logout</v-btn>
        </nav>
    </header>

    <main class="content">
        <ErrorMessage />
        <RouterView />
    </main>
</template>

<script>
import axios from 'axios';
import ErrorMessage from '@/components/ErrorMessage.vue';

export default {
    components: {
        ErrorMessage,
    },

    computed: {
        showLogoutButton() {
            const currentPath = this.$route.path;

            if (currentPath === '/') {
                return false;
            }

            return true;
        },
    },

    methods: {
        async logout() {
            try {
                await axios.post('/api/logout');
                localStorage.removeItem('token');
                this.$router.push({ name: 'Login' });
            } catch (error) {
                console.error('Error during logout', error);
            }
        },
    },
};
</script>

<style scoped>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #a3a3a3;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(82, 82, 82, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    width: 100%;
}

.logo {
    height: 50px;
}

nav {
    display: flex;
    gap: 1rem;
}

nav a {
    text-decoration: none;
    color: #ffffff;
    font-weight: bold;
    font-size: 1rem;
}

nav a.router-link-exact-active {
    color: var(--color-primary);
}

nav a:hover {
    text-decoration: underline;
}

.content {
    width: 100%;
    background-color: #ffffff;
    margin-top: 80px;
    box-sizing: border-box;
}
</style>
