@extends('layouts.dashboard')

@section('title', 'Create Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

    <form action="{{ route('Dashboard.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('Dashboard.products._form')
    </form>

@endsection
