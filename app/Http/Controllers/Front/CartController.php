<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Front\CartInterface;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
    {
    public $CardInterface;

    public function __construct(CartInterface $CardInterface)
    {
        $this->CardInterface = $CardInterface;
    }

    public function index()
    {
        $items = $this->CardInterface->get();
        $total = $this->CardInterface->total();
        return view('front.cart', ['cart' => $items, 'total' => $total]);

    }


    public function store(Request $request) {

        return $this->CardInterface->add($request, $request->quantity);
    }


    public function update(Product $product,Cart $cart) {

        return $this->CardInterface->update($product, $cart->quantity);
    }


    public function destroy(Product $product) {
        return $this->CardInterface->delete($product);
    }
    }
