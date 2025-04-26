import React, { useEffect, useState } from "react";
import { Table, Button, Space, message, Input } from "antd";
import axios from "axios";

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
}

const Product: React.FC = () => {
    const [products, setProducts] = useState<Product[]>([]);
    const [loading, setLoading] = useState<boolean>(false);
    const [search, setSearch] = useState<string>('');
    const [pagination, setPagination] = useState({ current: 1, pageSize: 10 });

    // Fetch products data with pagination and search
    const fetchProducts = async (page = 1, search = '') => {
        setLoading(true);
        try {
            const response = await axios.get("/api/products", {
                params: { search, page },
            });
            setProducts(response.data.data); // Assuming response contains 'data' field for products
            setPagination({ ...pagination, total: response.data.total });
        } catch (error) {
            message.error("Failed to fetch product data.");
            console.error(error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchProducts(); // Fetch products when the component is mounted
    }, []);

    // Handle search
    const handleSearch = () => {
        fetchProducts(1, search); // Fetch with search query
    };

    // Handle pagination change
    const handlePaginationChange = (page: number, pageSize: number) => {
        fetchProducts(page, search); // Fetch based on the current page
    };

    const columns = [
        {
            title: "ID",
            dataIndex: "id",
            key: "id",
        },
        {
            title: "Name",
            dataIndex: "name",
            key: "name",
        },
        {
            title: "Description",
            dataIndex: "description",
            key: "description",
        },
        {
            title: "Price",
            dataIndex: "price",
            key: "price",
            render: (text: number) => `$${text.toFixed(2)}`, // Format price to currency
        },
        {
            title: "Action",
            key: "action",
            render: (_: any, record: Product) => (
                <Space size="middle">
                    <Button type="primary" onClick={() => handleEdit(record.id)}>
                        Edit
                    </Button>
                    <Button type="danger" onClick={() => handleDelete(record.id)}>
                        Delete
                    </Button>
                </Space>
            ),
        },
    ];

    const handleEdit = (id: number) => {
        console.log("Edit product with ID:", id);
        // Add logic to open modal or redirect to an edit page
    };

    const handleDelete = (id: number) => {
        console.log("Delete product with ID:", id);
        // Add logic to delete the product via the API
    };

    return (
        <div>
            <div style={{ marginBottom: 16 }}>
                <Input.Search
                    placeholder="Search products"
                    onSearch={handleSearch}
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    enterButton
                />
            </div>
            <Table
                columns={columns}
                dataSource={products}
                rowKey="id"
                loading={loading}
                pagination={{
                    current: pagination.current,
                    pageSize: pagination.pageSize,
                    total: pagination.total,
                    onChange: handlePaginationChange,
                }}
            />
        </div>
    );
};

export default Product;
