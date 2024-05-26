@extends('layouts.base')
@section('title', 'Каталог манги')

@section('main')
    <div class="container">
        <div class="row row-cols-5 row-cols-lg-1">
            @foreach($mangas as $manga)
                <div class="col-lg-4 mb-lg-0 mt-lg-3 col-md-1 ">
                    @include('layouts.manga_card')
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('center','Каталог манги')
