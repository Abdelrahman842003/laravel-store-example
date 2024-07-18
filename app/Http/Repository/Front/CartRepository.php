<?php

namespace App\Http\Repository\Front;

use App\Http\Interfaces\Front\CartInterface;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartInterface
    {
    public function add($request, $quantity = 1)
        {
            // Validate the request inputs
            $request->validate(['product_id' => 'required|int|exists:products,id', 'quantity' => 'nullable|int|min:1',]);

            // Use the provided quantity or default to 1
            $quantity = $request->input('quantity', 1);

            // Find the product to ensure it exists
            Product::findOrFail($request->product_id);

            // Get the current user's cart item for the product
            $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();

            if ($cartItem) {
                // If the product is already in the cart, update the quantity
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // Create a new cart entry if the product is not in the cart
                Cart::create(['user_id' => Auth::id(), 'quantity' => $quantity,
                    'product_id' => $request->product_id]);
            }

            // Redirect to the cart index with a success message
            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully');
        }


        public function get(): Collection
        {
            return Cart::with('product')->get();

        }

        public function update($product, $quantity)
        {
            Cart::where('product_id', $product->id)->update(['quantity' => $quantity]);
        }

        public function empty()
        {
            Cart::query()->delete();
        }

        public function delete($product)
        {
            Cart::where('product_id', $product->id)->delete();
        }

        public function total()
        {
            return Cart::join('products', 'carts.product_id', 'products.id')
                ->selectRaw('SUM(products.price * carts.quantity) as total')->value('total');
        }
    }
