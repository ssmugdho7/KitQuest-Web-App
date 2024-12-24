@extends('layout.sidenav-layout')
@section('content')
    @include('component.customer.customer-list')
    @include('component.customer.customer-delete')
    @include('component.customer.customer-create')
    @include('component.customer.customer-update')
@endsection
