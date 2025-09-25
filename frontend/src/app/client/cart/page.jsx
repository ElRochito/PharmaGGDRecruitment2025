'use client';

import { useState, useEffect } from 'react';
import Link from 'next/link';
import { useSession } from 'next-auth/react';

export default function CartPage() {
  const [cart, setCart] = useState(null);
  const [error, setError] = useState('');
  const token = useSession().data.user.laravelAccessToken;

  const fetchCart = async () => {
    try {
      const response = await fetch(`${process.env.NEXT_PUBLIC_BACKEND_URL}/cart`, {
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-type': 'application/json',
        },
      });
      const data = await response.json()
      setCart(data);
    } catch (err) {
      console.warn(err)
      setError(err.response?.data?.message || 'Failed to fetch cart.');
    }
  };

  useEffect(() => {
    fetchCart();
  }, []);

  const handleUpdateQuantity = async (cartItemId, newQuantity) => {
    if (newQuantity < 0) return;
    try {
      const response = await fetch(`${process.env.NEXT_PUBLIC_BACKEND_URL}/cart/items/${cartItemId}`, {
        method: 'PUT',
        body: JSON.stringify({
          quantity: newQuantity,
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

      const data = await response.json()
      setCart(data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to update item quantity.');
    }
  };

  const handleRemoveItem = async (cartItemId) => {
    try {
      const response = await fetch(`http://localhost:8000/api/cart/items/${cartItemId}`, {
        method: 'delete',
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });
      const data = await response.json()
      setCart(data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to remove item.');
    }
  };

  const handleClearCart = async () => {
    try {
      const response = await fetch('http://localhost:8000/api/cart', {
        method: 'delete',
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });
      const data = await response.json()
      setCart(data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to clear cart.');
    }
  };

  const calculateTotal = () => {
    if (!cart || !cart.cart_items) return 0;
    return cart.cart_items.reduce((total, item) => total + item.product.price * item.quantity, 0).toFixed(2);
  };

  if (!cart) {
    return <div className="container mx-auto p-4">   cart...</div>;
  }

  return (
    <div className="container mx-auto p-4 text-white">
      <h1 className="text-2xl font-bold mb-4">Your Shopping Cart</h1>
      {error && <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                      <span className="block sm:inline">{error}</span>
                      <span className="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg className="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                      </span>
                    </div>}
      {
        !cart.cart_items || cart.cart_items.length === 0 ? (
          <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 text-black">
          <p className="mb-4">Your cart is empty.</p>
          <Link href="/products" className="cursor-pointer bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded">Start shopping</Link>
        </div>
        ) : (
          <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            {cart.cart_items.map((item) => (
              <div key={item.id} className="flex justify-between items-center border-b py-2 text-black">
                <div>
                  <h2 className="text-xl font-semibold">{item.product.name}</h2>
                  <p className="text-gray-600">{item.product.price} € x {item.quantity}</p>
                </div>
                <div className="flex items-center">
                  <button
                    onClick={() => handleUpdateQuantity(item.id, item.quantity - 1)}
                    className="cursor-pointer bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2"
                  >
                    -
                  </button>
                  <span className="text-lg">{item.quantity}</span>
                  <button
                    onClick={() => handleUpdateQuantity(item.id, item.quantity + 1)}
                    className="cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded ml-2"
                  >
                    +
                  </button>
                  <button
                    onClick={() => handleRemoveItem(item.id)}
                    className="cursor-pointer bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-1 px-2 rounded ml-4"
                  >
                    Remove
                  </button>
                </div>
              </div>
            ))}
            <div className="flex justify-between items-center mt-4">
              <h2 className="text-2xl font-bold">Total: ${calculateTotal()}</h2>
              <button
                onClick={handleClearCart}
                className="cursor-pointer bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded"
              >
                Clear Cart
              </button>
            </div>
          </div>
        )
      }
    </div>
  );
}
