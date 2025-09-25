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
  const { data: session, status } = useSession();
  const user = session?.user;
  const token = user?.laravelAccessToken;
  const isAdmin = ['super_admin', 'catalog'].includes(user?.role?.code);
console.warn(status)
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
          'Accept': 'application/json',
          'Content-type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });
      router.push('/client/cart');
    } catch (err) {
      console.warn(err)
      setError(err.response?.data?.message || 'Failed to add item.');
    }
  };

  return (
    <div className="container mx-auto p-4 text-white">
      <h1 className="text-2xl font-bold mb-4">Products</h1>
      {error && <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span className="block sm:inline">{error}</span>
        <span className="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg className="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
      </div>}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {products.map((product) => (
          <div key={product.id} className="border p-4 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold">{product.name}</h2>
            <p className="text-gray-600">{product.description}</p>
            <p className="text-lg font-bold mt-2">{product.price} €</p>
            <p className="text-sm text-gray-500 mb-4">Stock: {product.stock}</p>
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
