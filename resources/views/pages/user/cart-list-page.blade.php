@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.profile')
    @include('component.user.CartList')
    @include('component.user.Footer')
    <script>
        (async () => {
            await CartList();
            await ProfileDetails();
          //  showLoader();
        })()
    </script>
@endsection





