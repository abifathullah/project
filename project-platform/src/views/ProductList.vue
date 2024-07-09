<template>
    <v-container>
        <h2 class="mb-4 font-semibold text-xl text-black leading-tight">Products</h2>

        <v-row class="mb-2">
            <v-col cols="3">
                <v-text-field
                    v-model="productName"
                    label="Search Product Name (Partial)"
                    solo-inverted
                ></v-text-field>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    v-model="categoryName"
                    label="Search Category Name (Exact)"
                    solo-inverted
                ></v-text-field>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    v-model="minPrice"
                    label="Min Price"
                    type="number"
                    solo-inverted
                    @input="validatePrice"
                    :error-messages="errorMessages.minPrice"
                ></v-text-field>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    v-model="maxPrice"
                    label="Max Price"
                    type="number"
                    solo-inverted
                    @input="validatePrice"
                    :error-messages="errorMessages.maxPrice"
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-btn flat @click="filterProducts" color="primary" :disabled="error">Search</v-btn>
                <v-btn flat class="ml-3" @click="resetFilters" color="error">Reset Filters</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-data-table :headers="headers" :items="filteredProducts" class="elevation-1">
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title>Products</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.id`]="{ item }">
                        <span>{{ item.id }}.</span>
                    </template>
                    <template v-slot:[`item.price`]="{ item }">
                        <span>{{ formatCurrency(item.price) }}</span>
                    </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <v-btn flat color="primary" @click="viewProduct(item.id)">View</v-btn>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <v-alert v-if="loading" type="info" class="mt-4">Loading products data...</v-alert>
        <v-alert v-if="error" type="error" class="mt-4">Error loading products data.</v-alert>
    </v-container>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
    name: 'ProductList',

    data() {
        return {
            products: [],
            filteredProducts: [],
            productName: '',
            categoryName: '',
            minPrice: '',
            maxPrice: '',
            errorMessages: {
                minPrice: '',
                maxPrice: '',
            },
            loading: false,
            error: false,
            headers: [
                { title: 'No.', value: 'id', sortable: true },
                { title: 'Category', value: 'category.name', sortable: true },
                { title: 'Name', value: 'name', sortable: true },
                { title: 'Price', value: 'price', align: 'end', sortable: true },
                { title: 'Actions', value: 'actions', align: 'end', sortable: false },
            ],
        };
    },

    created() {
        this.fetchProducts();
    },

    methods: {
        fetchProducts() {
            this.loading = true;
            this.error = false;

            axios
                .get(`/api/products`, {
                    params: {
                        with: 'category',
                    },
                })
                .then((response) => {
                    this.products = response.data.data.original;
                    this.filteredProducts = this.products;
                    const toast = useToast();
                    toast.success(response.data.message);
                    this.loading = false;
                })
                .catch((error) => {
                    this.error = true;
                    const toast = useToast();
                    toast.error(error.response.data.message);
                    this.loading = false;
                });
        },

        validatePrice() {
            this.errorMessages.minPrice = '';
            this.errorMessages.maxPrice = '';
            this.error = false;

            if (this.minPrice !== '' && parseFloat(this.minPrice) < 0) {
                this.errorMessages.minPrice = 'Price cannot be negative';
                this.minPrice = '';
                return;
            }

            if (this.maxPrice !== '' && parseFloat(this.maxPrice) < 0) {
                this.errorMessages.maxPrice = 'Price cannot be negative';
                this.maxPrice = '';
                return;
            }

            if (
                this.minPrice !== '' &&
                this.maxPrice !== '' &&
                parseFloat(this.minPrice) > parseFloat(this.maxPrice)
            ) {
                this.errorMessages.maxPrice = 'Max Price cannot be lower than Min Price';
                this.error = true;
                return;
            }
        },

        filterProducts() {
            if (this.error) {
                return;
            }

            let params = {};

            if (this.productName.trim() !== '') {
                params.productName = this.productName.trim();
            }

            if (this.categoryName.trim() !== '') {
                params.categoryName = this.categoryName.trim();
            }

            if (
                this.minPrice !== '' &&
                !isNaN(parseFloat(this.minPrice)) &&
                parseFloat(this.minPrice) >= 0
            ) {
                params.minPrice = parseFloat(this.minPrice);
            }

            if (
                this.maxPrice !== '' &&
                !isNaN(parseFloat(this.maxPrice)) &&
                parseFloat(this.maxPrice) >= 0
            ) {
                params.maxPrice = parseFloat(this.maxPrice);
            }

            axios
                .get(`/api/products-filter`, { params })
                .then((response) => {
                    this.filteredProducts = response.data.data || [];
                    const toast = useToast();
                    toast.success(response.data.message);
                })
                .catch((error) => {
                    this.error = true;
                    const toast = useToast();
                    toast.error(error.data.message);
                });
        },

        resetFilters() {
            this.productName = '';
            this.categoryName = '';
            this.minPrice = '';
            this.maxPrice = '';
            this.errorMessages.minPrice = '';
            this.errorMessages.maxPrice = '';
            this.filteredProducts = this.products;
        },

        viewProduct(id) {
            this.$router.push({ name: 'ProductDetail', params: { id } });
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(value);
        },
    },
};
</script>

<style scoped>
.elevation-1 {
    box-shadow:
        0px 1px 3px rgba(0, 0, 0, 0.12),
        0px 1px 2px rgba(0, 0, 0, 0.24);
}
</style>
