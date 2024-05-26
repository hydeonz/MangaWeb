@extends('layouts.base')
@section('title', $manga->title)

@section('main')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ $manga->image_path }}" class="img-fluid rounded" alt="{{ $manga->title }}">
            </div>
            <div class="col-lg-6 text-light">
                <h1 class="mb-4">{{ $manga->title }}</h1>
                <p><strong>Автор:</strong> {{ $manga->author_name }}</p>
                <p><strong>Дата выпуска:</strong> {{ $manga->release_date }}</p>
                <p><strong>Жанры:</strong> {{ $manga->genre_names }}</p>
                <p><strong>Описание:</strong></p>
                <p>{{ $manga->description }}</p>
            </div>
        </div>
    </div>
@endsection
