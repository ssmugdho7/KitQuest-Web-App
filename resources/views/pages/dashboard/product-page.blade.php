@extends('layout.sidenav-layout')
@section('content')
    @include('component.product.product-list')
    @include('component.product.product-delete')
    @include('component.product.product-create')
    @include('component.product.product-update')
@endsection
