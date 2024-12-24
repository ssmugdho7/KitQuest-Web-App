@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.Verify')
    @include('component.user.Footer')
    <script>
        (async () => {
           // $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection

