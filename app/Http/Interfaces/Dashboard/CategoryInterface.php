<?php

namespace App\Http\Interfaces\Dashboard;

interface CategoryInterface
{
    public function index();

    public function create();

    public function store( $request);

    public function edit( $category);

    public function update( $request,  $category);

    public function destroy( $category);

    public function trash();

    public function restore(   $id);

    public function forceDelete( $id);
}
