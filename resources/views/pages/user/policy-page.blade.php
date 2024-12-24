@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.PolicyList')
    @include('component.user.Footer')
    <script>
        (async () => {
            await Category();
            await Policy()
            // $(".preloader").delay(90).fadeOut(100).addClass('loaded');

        })()
    </script>
@endsection


