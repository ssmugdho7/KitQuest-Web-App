@extends('layout.sidenav-layout')
@section('content')
    @include('component.invoice.invoice-list')
    @include('component.invoice.invoice-delete')
    @include('component.invoice.invoice-details')
@endsection
