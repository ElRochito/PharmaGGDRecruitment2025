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
          Authorization: `Bearer ${token}`,
          'Content-type': 'application/json',
        },
      });
      setCart(response.data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to update item quantity.');
    }
  };

  const handleRemoveItem = async (cartItemId) => {
    try {
      const response = await fetch(`http://localhost:8000/api/cart/items/${cartItemId}`, {
        method: 'delete',
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-type': 'application/json',
        },
      });
      setCart(response.data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to remove item.');
    }
  };

  const handleClearCart = async () => {
    try {
      const response = await fetch('http://localhost:8000/api/cart', {
        method: 'delete',
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-type': 'application/json',
        },
      });
      setCart(response.data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to clear cart.');
    }
  };

  const calculateTotal = () => {
    if (!cart || !cart.cart_items) return 0;
    return cart.cart_items.reduce((total, item) => total + item.product.price * item.quantity, 0).toFixed(2);
  };

  if (!cart) {
    return <div className="container mx-auto p-4">Loading cart...</div>;
  }

  return (
    <div className="container mx-auto p-4 text-white">
      <h1 className="text-2xl font-bold mb-4">Your Shopping Cart</h1>
      {error && <p className="text-red-500 mb-4">{error}</p>}
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
