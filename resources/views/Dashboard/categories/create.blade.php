@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

    <form action="{{ route('Dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('Dashboard.categories._form')
    </form>

@endsection
