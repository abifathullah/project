<template>
    <v-container>
        <h2 class="mb-4 font-semibold text-xl leading-tight">About</h2>

        <v-card class="elevation-0 border">
            <v-card-text>
                <p v-if="loading">Loading...</p>
                <template v-else>
                    <p>List of related version:</p>
                    <v-divider class="my-4" />
                    <p>PHP Version: {{ phpVersion }}</p>
                    <p>Laravel Version: {{ laravelVersion }}</p>
                    <p>Vue Version: {{ vueVersion }}</p>
                </template>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import { useVersionsStore } from '@/stores/versions';

export default {
    name: 'About',

    data() {
        return {
            loading: true,
        };
    },

    computed: {
        phpVersion() {
            return this.versionsStore.phpVersion;
        },

        laravelVersion() {
            return this.versionsStore.laravelVersion;
        },

        vueVersion() {
            return this.versionsStore.vueVersion;
        },
    },

    created() {
        this.versionsStore = useVersionsStore();
        this.versionsStore.fetchVersions();
        this.loading = false;
    },
};
</script>
