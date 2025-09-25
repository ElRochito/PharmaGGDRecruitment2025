'use client';

import { useState, useEffect } from 'react';
import Link from 'next/link';
import { useSession } from 'next-auth/react';
import { useRouter } from 'next/navigation';

export default function ProductsPage() {
  const [products, setProducts] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [error, setError] = useState('')
  const router = useRouter();

  const user = useSession().data?.user;
  const isAdmin = ['super_admin', 'catalog'].includes(user?.role?.code);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await fetch(`${process.env.NEXT_PUBLIC_BACKEND_URL}/products?page=${currentPage}`,{
          headers: {
            'Content-type': 'application/json'
          }
        });
        const products = await response.json()
        setProducts(products.data);
        setLastPage(products.meta.last_page);
      } catch (err) {
        setError(err.response?.data?.message || 'Failed to fetch products.');
      }
    };

    fetchProducts();
  }, [currentPage]);

  const handlePreviousPage = () => {
    if (currentPage > 1) {
      setCurrentPage(currentPage - 1);
    }
  };

  const handleNextPage = () => {
    if (currentPage < lastPage) {
      setCurrentPage(currentPage + 1);
    }
  };

  const handleAddToCart = async (productId) => {
    try {
      const response = await fetch(`${process.env.NEXT_PUBLIC_BACKEND_URL}/cart`, {
        method: 'POST',
        body: JSON.stringify({
          product_id: productId,
          quantity: 1,
        }),
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-type': 'application/json',
        },
      });
      router.push('/client/cart');
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to add item.');
    }
  };

  return (
    <div className="container mx-auto p-4 text-white">
      <h1 className="text-2xl font-bold mb-4">Products</h1>
      {error && <p className="text-red-500 mb-4">{error}</p>}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {products.map((product) => (
          <div key={product.id} className="border p-4 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold">{product.name}</h2>
            <p className="text-gray-600">{product.description}</p>
            <p className="text-lg font-bold mt-2">{product.price} €</p>
            <p className="text-sm text-gray-500">Stock: {product.stock}</p>
            {
              isAdmin
               ?  <Link href={`/admin/products/edit/${product.id}`} className="mt-2 bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded disabled:opacity-50 cursor-pointer">Edit</Link>
               :
               user ? <button
                    onClick={() => handleAddToCart(product.id)}
                    className="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2"
                  >
                    Add
                  </button> : ''
            }
          </div>
        ))}
      </div>
      <div className="flex justify-between mt-4">
        <button
          onClick={handlePreviousPage}
          disabled={currentPage === 1}
          className="bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded disabled:opacity-50 cursor-pointer"
        >
          Previous
        </button>
        <span className="text-lg">Page {currentPage} of {lastPage}</span>
        <button
          onClick={handleNextPage}
          disabled={currentPage === lastPage}
          className="bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded disabled:opacity-50 cursor-pointer"
        >
          Next
        </button>
      </div>
    </div>
  );
}
