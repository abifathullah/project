import React, { useState, useEffect } from 'react';
import productService from '../services/productService';
import { Container } from 'semantic-ui-react';

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
            <div>
                <h1>Product List</h1>
                <ul>
                    {products && products.length > 0 ? (
                        products.map(product => (
                            <li key={product.id}>
                                {product.name} - ${product.price}
                                <button onClick={() => handleUpdateProduct(product.id)}>Update</button>
                                <button onClick={() => handleDeleteProduct(product.id)}>Delete</button>
                            </li>
                        ))
                    ) : (
                        <p>No products available.</p>
                    )}
                </ul>
                <div>
                    <input
                        type="text"
                        placeholder="Name"
                        value={newProduct.name}
                        onChange={(e) => setNewProduct({ ...newProduct, name: e.target.value })}
                    />
                    <input
                        type="text"
                        placeholder="Description"
                        value={newProduct.description}
                        onChange={(e) => setNewProduct({ ...newProduct, description: e.target.value })}
                    />
                    <input
                        type="number"
                        placeholder="Price"
                        value={newProduct.price}
                        onChange={(e) => setNewProduct({ ...newProduct, price: e.target.value })}
                    />
                    <button onClick={handleCreateProduct}>Create Product</button>
                </div>
            </div>
        </Container>
    );
}

export default Product;
