<?php

namespace App\Http\Interfaces\Dashboard;


interface ProductsInterface
{
    public function index($request);

    public function create();

    public function store($request);

    public function edit($id);

    public function update($request, $product);

    public function destroy($product);

    public function trash();

    public function restore( $id);

    public function forceDelete($id);
}
