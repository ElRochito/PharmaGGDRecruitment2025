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
          'Accept': 'application/json',
          'Content-type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({ message: 'An unknown error occurred parsing the response.' }));
        if (response.status === 433) {
          setError(errorData.message || 'Error 433: You do not have permission to perform this action.');
        } else if (response.status === 422) {
          console.warn(errorData);
          setError(errorData.message || 'Error 422: Validation failed.');
        } else {
          setError(errorData.message || `An unexpected error occurred: ${response.statusText}`);
        }
        return;
      }

      setSuccess('Product created successfully!');
      setName('');
      setDescription('');
      setPrice('');
      setStock('');
      router.push('/admin/dashboard');
    } catch (err) {
      setError('Failed to create product. Please check your network connection.');
    }
  };

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4 text-white">Create New Product</h1>
      {error && <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                      <span className="block sm:inline">{error}</span>
                      <span className="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg className="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                      </span>
                    </div>}
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
            className="cursor-pointer bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            Create Product
          </button>
        </div>
      </form>
    </div>
  );
}
