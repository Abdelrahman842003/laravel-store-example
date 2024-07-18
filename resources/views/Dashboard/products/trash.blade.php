@extends('layouts.dashboard')

@section('title', 'Trashed Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('Dashboard.products.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
</div>

<x-alert type="danger" />
<x-alert type="info" />

<form action="{{ \Illuminate\Support\Facades\URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td><img src="{{  $product->url_image }}" alt="" height="50"></td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->deleted_at }}</td>
            <td>
                <form action="{{ route('Dashboard.products.restore', $product->id) }}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                </form>
            </td>
            <td>
                <form action="{{ route('Dashboard.products.force-delete', $product->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No products defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $products->withQueryString()->appends(['search' => 1])->links() }}

@endsection
