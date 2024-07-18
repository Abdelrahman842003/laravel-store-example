<?php

namespace App\Http\Interfaces\Front;


use http\Env\Request;
use Illuminate\Support\Collection;

interface CartInterface
{
    public function get() : Collection;

    public function add( $request ,$quantity);

    public function update( $product, $quantity);

    public function delete( $product);

    public function empty();

    public function total();

}
