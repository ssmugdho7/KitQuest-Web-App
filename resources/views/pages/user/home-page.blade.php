@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    @include('component.user.HeroSlider')
    @include('component.user.TopCategories')
    @include('component.user.ExclusiveProducts')
    @include('component.user.Footer')
    <script>
        (async () => {
            await Category();
            await Hero();
            await TopCategory();
            await Popular();
            await New();
            await Top();

    
        })()
    </script>
@endsection

