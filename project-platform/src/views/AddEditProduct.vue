<template>
    <v-container>
        <h2 class="mb-4">{{ mode === 'edit' ? 'Edit Product' : 'Add Product' }}</h2>

        <v-form @submit.prevent="saveProduct">
            <v-row>
                <v-col cols="12" sm="6">
                    <v-text-field v-model="product.name" label="Name" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-text-field
                        v-model.number="product.price"
                        label="Price"
                        type="number"
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-textarea v-model="product.description" label="Description"></v-textarea>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-select
                        v-model="product.product_category_id"
                        :items="categories"
                        item-title="name"
                        item-value="id"
                        label="Category"
                        required
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-btn type="submit" color="primary">{{
                        mode === 'edit' ? 'Save Changes' : 'Add Product'
                    }}</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
    name: 'AddEditProduct',

    props: ['mode', 'productId'],

    data() {
        return {
            product: {
                name: '',
                price: null,
                description: '',
                product_category_id: null,
            },
            categories: [],
        };
    },

    created() {
        if (this.mode === 'edit') {
            this.fetchProduct();
        }
        this.fetchCategories();
    },

    methods: {
        async fetchProduct() {
            try {
                const response = await axios.get(`/api/products/${this.$route.params.id}`);
                this.product = response.data.data;
                const toast = useToast();
                toast.success(response.data.message);
            } catch (error) {
                const toast = useToast();
                toast.error(error.response.data.message);
            }
        },

        async fetchCategories() {
            try {
                const response = await axios.get('/api/product-categories');
                this.categories = response.data.data.original;
            } catch (error) {
                const toast = useToast();
                toast.error('Error fetching categories');
            }
        },

        async saveProduct() {
            try {
                if (this.mode === 'edit') {
                    await axios.put(`/api/products/${this.$route.params.id}`, this.product);
                } else {
                    await axios.post('/api/products', this.product);
                }
                const toast = useToast();
                toast.success(
                    `${this.mode === 'edit' ? 'Product updated' : 'Product added'} successfully`
                );
                this.$router.push({ name: 'Home' });
            } catch (error) {
                const toast = useToast();
                toast.error(`Error ${this.mode === 'edit' ? 'updating' : 'adding'} product`);
            }
        },
    },
};
</script>
