<template>
    <header class="navbar">
        <img alt="logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />
        <nav>
            <p v-if="! loggedin">Product Store</p>
            <RouterLink v-if="loggedin" to="/home">Home</RouterLink>
            <RouterLink v-if="loggedin" to="/product/add">Add Product</RouterLink>
            <RouterLink v-if="loggedin" to="/about">About</RouterLink>
            <a href="#" v-if="loggedin" @click="logout" color="warning">Logout</a>
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
        loggedin() {
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
                if (confirm("Are you sure you want to logout?")) {
                    await axios.post('/api/logout');
                    localStorage.removeItem('token');
                    this.$router.push({ name: 'Login' });
                }
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
    padding: 1rem;
    box-shadow: 0 2px 4px #fff;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    width: 100%;
    background-color: #171717;
}

.logo {
    height: 25px;
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
    margin-top: 80px;
    box-sizing: border-box;
}
</style>
