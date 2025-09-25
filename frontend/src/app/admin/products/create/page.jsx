'use client';

import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';
import { adminAuth } from "App/lib/auth-admin";
import { adminAuthConfig } from "App/lib/auth-admin.config.js"
import { useSession } from 'next-auth/react';

export default function CreateProductPage() {
  const [name, setName] = useState('');
  const [description, setDescription] = useState('');
  const [price, setPrice] = useState('');
  const [stock, setStock] = useState('');
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const router = useRouter();
  const token = useSession().data.user.laravelAccessToken;

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setSuccess('');

    try {
      const response = await fetch(`${process.env.NEXT_PUBLIC_BACKEND_URL}/products`, {
        method: "POST",
        body: JSON.stringify({
          name,
          description,
          price: parseFloat(price),
          stock: parseInt(stock, 10),
        }),
        headers: {
          'Content-type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });
      setSuccess('Product created successfully!');
      setName('');
      setDescription('');
      setPrice('');
      setStock('');
      router.push('/admin/dashboard');
    } catch (err) {
      console.log(err);
      setError(err.response?.data?.message || 'Failed to create product.');
    }
  };

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">Create New Product</h1>
      {error && <p className="text-red-500 mb-4">{error}</p>}
      {success && <p className="text-green-500 mb-4">{success}</p>}
      <form onSubmit={handleSubmit} className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div className="mb-4">
          <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="name">
            Product Name:
          </label>
          <input
            type="text"
            id="name"
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            value={name}
            onChange={(e) => setName(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="description">
            Description:
          </label>
          <textarea
            id="description"
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="price">
            Price:
          </label>
          <input
            type="number"
            id="price"
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            value={price}
            onChange={(e) => setPrice(e.target.value)}
            step="0.01"
            required
          />
        </div>
        <div className="mb-6">
          <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="stock">
            Stock:
          </label>
          <input
            type="number"
            id="stock"
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            value={stock}
            onChange={(e) => setStock(e.target.value)}
            required
          />
        </div>
        <div className="flex items-center justify-between">
          <button
            type="submit"
            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            Create Product
          </button>
        </div>
      </form>
    </div>
  );
}
