@extends('layout.sidenav-layout')
@section('content')
    @include('component.category.category-list')
    @include('component.category.category-delete')
    @include('component.category.category-create')
    @include('component.category.category-update')
@endsection
