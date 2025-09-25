<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController
{
    public function viewCart(#[CurrentUser] User $user)
    {
        $cart = $user->cart()
            ->with('cartItems.product')
            ->firstOrCreate([]);

        return response()->json($cart);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate([]);
        $product = Product::query()->find($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available.'], 400);
        }

        $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = $cart->cartItems()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json($cart->load('cartItems.product'));
    }

    public function updateCartItem(#[CurrentUser] User $user, Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        if ($cartItem->cart->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($request->quantity === 0) {
            $cartItem->delete();
        } else {
            if ($cartItem->product->stock < $request->quantity) {
                return response()->json(['message' => 'Not enough stock available.'], 400);
            }
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return response()->json($cartItem->cart->load('cartItems.product'));
    }

    public function removeCartItem(#[CurrentUser] User $user, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json($cartItem->cart->load('cartItems.product'));
    }

    public function clearCart(#[CurrentUser] User $user)
    {
        $cart = $user->cart()->first();

        if ($cart) {
            $cart->cartItems()->delete();
        }

        return response()->json($cart->load('cartItems.product'));
    }
}
