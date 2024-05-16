@extends('layouts.base')

@section('title', 'Административная панель')

@section('script')
    <script>
        $(document).ready(function() {
            $('button.edit-btn').click(function() {
                let row = $(this).closest('tr');

                console.log(row);
                if (!row.hasClass('editing')) {
                    row.find('input').each(function() {
                        $(this).data('original-value', $(this).val());
                    });
                    row.addClass('editing');
                }

                row.find('input').prop('readonly', false);
                row.find('.edit-btn, .delete-btn').addClass('d-none');
                row.find('.save-btn, .cancel-btn').removeClass('d-none');
            });

            $('button.cancel-btn').click(function() {
                let row = $(this).closest('tr');
                row.find('input').each(function() {
                    $(this).val($(this).data('original-value'));
                });
                row.removeClass('editing');
                row.find('.edit-btn, .delete-btn').removeClass('d-none');
                row.find('.save-btn, .cancel-btn').addClass('d-none');
            });

            $('button.save-btn').click(function() {
                let row = $(this).closest('tr');
                let updateUrl = $(this).attr('data-url');

                let data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: row.find('input[id="manga_id"]').val(),
                    title: row.find('input[name="title"]').val(),
                    author_name: row.find('input[name="author_name"]').val(),
                    release_date: row.find('input[name="release_date"]').val(),
                    description: row.find('input[name="description"]').val()
                };

                $.ajax({
                    url: 'api' + updateUrl,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        alert('Изменения сохранены успешно.');

                        row.find('input').prop('readonly', true);

                        row.find('input[name="title"]').val(response.title);
                        row.find('input[name="author_name"]').val(response.author_name);
                        row.find('input[name="release_date"]').val(response.release_date);
                        row.find('input[name="description"]').val(response.description);

                        row.find('.save-btn').addClass('d-none');
                        row.find('.edit-btn, .delete-btn').removeClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка при сохранении изменений.');
                        console.error(error);
                    }
                });
            });

            $('button.delete-btn').click(function() {
                let deleteUrl = $(this).attr('data-url');
                let row = $(this).closest('tr');

                $.ajax({
                    url: 'api' + deleteUrl,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Манга удалена успешно.');
                        row.remove();
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка при удалении манги.');
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection

@section('main')
    <div class="container-fluid">
        <a href="{{ route('add_manga') }}" class="btn btn-sm btn-primary m-2">Добавить мангу</a>
        <a href="{{ route('add_author') }}" class="btn btn-sm btn-primary m-2">Добавить автора</a>
        <a href="{{ route('add_genre') }}" class="btn btn-sm btn-primary m-2">Добавить жанр</a>
        <div class="row">
            <main role="main" class="ml-sm-auto col-lg-12 px-md-4">
                <div class="table-responsive">
                    <h3 class="text-white">Манга</h3>
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
                                <td hidden=""><input type="text" id="manga_id" value="{{ $manga->id }}"></td>
                                <td><input type="text" name="title" class="form-control" value="{{ $manga->title }}" readonly></td>
                                <td><input type="text" name="author_name" class="form-control" value="{{ $manga->author_name }}" readonly></td>
                                <td><input type="date" name="release_date" class="form-control" value="{{ $manga->release_date }}" readonly></td>
                                <td><input type="text" name="description" class="form-control" value="{{ $manga->description }}" readonly></td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Редактировать</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-url="/admin/manga/delete/{{ $manga->id }}">Удалить</button>
                                    <button class="btn btn-sm btn-success save-btn d-none" data-url="/admin/manga/update/">Сохранить</button>
                                    <button class="btn btn-sm btn-secondary cancel-btn d-none">Отменить</button>
                                    @csrf
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <h3 class="text-white">Авторы</h3>
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
                    <h3 class="text-white">Жанры</h3>
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
