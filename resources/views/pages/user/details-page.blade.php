@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.ProductDetails')
    @include('component.user.ProductSpecification')
    @include('component.user.Footer')
    <script>
        (async () => {
            await productDetails();
            await productReview();
           /// $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection

