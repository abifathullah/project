import React, { useState, useEffect } from 'react';
import productService from '../services/productService';
import { Container, Typography, TextField, Button, Box, List, ListItem, ListItemText, IconButton } from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';

function Product() {
    const [products, setProducts] = useState([]);
    const [newProduct, setNewProduct] = useState({ name: '', description: '', price: '' });

    useEffect(() => {
        fetchProducts();
    }, []);

    const fetchProducts = async () => {
        try {
            const response = await productService.getProducts();
            
            if (response.data && response.data.data.original) {
                setProducts(response.data.data.original);
            } else {
                console.error('Unexpected API response structure:', response);
            }
        } catch (error) {
            console.error('Failed to fetch products:', error);
        }
    };

    const handleCreateProduct = async () => {
        await productService.createProduct(newProduct);
        fetchProducts();
        setNewProduct({ name: '', description: '', price: '' }); // Clear input fields
    };

    const handleUpdateProduct = async (id) => {
        await productService.updateProduct(id, newProduct);
        fetchProducts();
    };

    const handleDeleteProduct = async (id) => {
        await productService.deleteProduct(id);
        fetchProducts();
    };

    return (
        <Container>
            <Typography variant="h4" gutterBottom>
                Product List
            </Typography>
            <Box
                sx={{
                    mt: 4,
                    display: 'flex',
                    flexDirection: 'column',
                    gap: 2,
                }}
            >
                <TextField
                    variant="outlined"
                    label="Name"
                    value={newProduct.name}
                    onChange={(e) => setNewProduct({ ...newProduct, name: e.target.value })}
                />
                <TextField
                    variant="outlined"
                    label="Description"
                    value={newProduct.description}
                    onChange={(e) => setNewProduct({ ...newProduct, description: e.target.value })}
                />
                <TextField
                    variant="outlined"
                    label="Price"
                    type="number"
                    value={newProduct.price}
                    onChange={(e) => setNewProduct({ ...newProduct, price: e.target.value })}
                />
                <Button
                    variant="contained"
                    color="primary"
                    onClick={handleCreateProduct}
                >
                    Create Product
                </Button>
            </Box>
            <List>
                {products && products.length > 0 ? (
                    products.map(product => (
                        <ListItem key={product.id} secondaryAction={
                            <>
                                <IconButton edge="end" aria-label="edit" onClick={() => handleUpdateProduct(product.id)}>
                                    <EditIcon />
                                </IconButton>
                                <IconButton edge="end" aria-label="delete" onClick={() => handleDeleteProduct(product.id)}>
                                    <DeleteIcon />
                                </IconButton>
                            </>
                        }>
                            <ListItemText
                                primary={product.name}
                                secondary={`Description: ${product.description} - Price: $${product.price}`}
                            />
                        </ListItem>
                    ))
                ) : (
                    <Typography variant="body1">No products available.</Typography>
                )}
            </List>
        </Container>
    );
}

export default Product;
