@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.ByCategoryList')
    @include('component.user.Footer')
    <script>
        (async () => {
            await Category();
            await ByCategory();
            // $(".preloader").delay(90).fadeOut(100).addClass('loaded');

        })()
    </script>
@endsection





