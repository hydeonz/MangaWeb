@extends('layouts.base')

@section('title', 'Административная панель')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <main role="main" class="ml-sm-auto col-lg-12 px-md-4">
                <h2>Манга</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Автор</th>
                            <th>Дата выпуска</th>
                            <th>Описание</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mangas as $manga)
                            <tr>
                                <td>{{ $manga->title }}</td>
                                <td>{{ $manga->author_name }}</td>
                                <td>{{ $manga->release_date }}</td>
                                <td>{{ $manga->description }}</td>
                                <td>
                                    <a href="/admin/manga/edit/{{ $manga->id }}" class="btn btn-sm btn-primary">Редактировать</a>
                                    <form action="/admin/manga/delete/{{ $manga->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h2>Авторы</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($authors as $author)
                            <tr>
                                <td>{{ $author->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="/admin/author/edit/{{ $author->id }}" class="btn btn-sm btn-primary">Редактировать</a>
                                    <form action="/admin/author/delete/{{ $author->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h2>Жанры</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($genres as $genre)
                            <tr>
                                <td>{{ $genre->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="/admin/genre/edit/{{ $genre->id }}" class="btn btn-sm btn-primary">Редактировать</a>
                                    <form action="/admin/genre/delete/{{ $genre->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
@endsection
@section('center','Панель администрирования')
