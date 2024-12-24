@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.WishList')
    @include('component.user.Footer')
    <script>
        (async () => {
            await WishList();
            // $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection





