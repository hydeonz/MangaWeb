@extends('layouts.base')

@section('title', 'Административная панель')

@section('script')
    <script>
        $(document).ready(function() {
            $('button.edit-btn').click(function() {
                let row = $(this).closest('tr');
                if (!row.hasClass('editing')) {
                    row.find('input, select').each(function() {
                        $(this).data('original-value', $(this).val());
                        console.log($(this).data('original-value'));
                    });
                    row.addClass('editing');
                }
                row.find('input[type="date"]').prop('disabled', false);
                row.find('input[type="date"]').prop('readonly', false);
                row.find('input[type="text"]').prop('disabled', false);
                row.find('input[type="text"]').prop('readonly', false);

                row.find('select').prop('disabled', false);
                row.find('option').each(function() {
                    $(this).removeClass('d-none');
                });
                row.find('.edit-btn, .delete-btn').addClass('d-none');
                row.find('.save-btn, .cancel-btn').removeClass('d-none');
                row.find('input[type="file"]').prop('disabled', false);
            });

            $('button.cancel-btn').click(function() {
                let row = $(this).closest('tr');
                let inputs = row.find('input[type="text"], input[type="date"], select');

                inputs.each(function() {
                    $(this).prop('readonly', true);
                    $(this).prop('disabled', true);
                    $(this).val($(this).data('original-value'));
                });
                row.find('option').each(function() {
                    $(this).addClass('d-none');
                });
                row.find('.edit-btn, .delete-btn').removeClass('d-none');
                row.find('.save-btn, .cancel-btn').addClass('d-none');
                row.find('input[type="file"]').prop('disabled', true).val('');
                row.find('.image-preview').attr('src', row.find('input[name="image_path"]').val());
                row.removeClass('editing');
            });

            $('button.save-btn').click(function() {
                let row = $(this).closest('tr');
                let updateUrl = $(this).attr('data-url');
                let entity = $(this).attr('data-entity');
                let genre_id = row.find('select[name="genre_id"]').val();
                let data = new FormData();
                data.append('_token', $('meta[name="csrf-token"]').attr('content'));

                if (entity === 'manga') {
                    data.append('id', row.find('input[id="manga_id"]').val());
                    data.append('author_id', row.find('select[name="author_id"]').val());
                    data.append('genre_id', row.find('select[name="genre_id"]').val());
                    data.append('title', row.find('input[name="title"]').val());
                    data.append('release_date', row.find('input[name="release_date"]').val());
                    data.append('description', row.find('input[name="description"]').val());

                    $(this).closest('tr').find('select[name="genre_id"] option').attr('selected', false);
                    $(this).closest('tr').find('select[name="genre_id"] option[value="' + genre_id + '"]').attr('selected', true);

                    let fileInput = row.find('input[type="file"]')[0];
                    if (fileInput.files.length > 0) {
                        data.append('image', fileInput.files[0]);
                    }
                } else if (entity === 'author') {
                    data.append('id', row.find('input[id="author_id"]').val());
                    data.append('name', row.find('input[name="author"]').val());
                } else if (entity === 'genre') {
                    data.append('id', row.find('input[id="genre_id"]').val());
                    data.append('name', row.find('input[name="genre"]').val());
                }
                $.ajax({
                    url: 'api' + updateUrl,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if (entity === 'manga') {
                            // Действия при успешном обновлении манги
                            alert('Изменения сохранены успешно.');

                            row.find('option').each(function() {
                                $(this).addClass('d-none');
                                if ($(this).val() == response.oldManga.author_id) {
                                    $(this).prop('selected', false);
                                }
                                if ($(this).val() == response.manga.author_id) {
                                    $(this).prop('selected', true);
                                }
                                if ($(this).val() == response.oldManga.genre_id) {
                                    $(this).prop('selected', false);
                                }
                                if ($(this).val() == response.manga.genre_id) {
                                    $(this).prop('selected', true);
                                }
                            });

                            // Обновление изображения манги
                            row.find('input[name="image_path"]').val(response.manga[0].image_path);
                            row.find('.image-preview').attr('src', response.manga[0].image_path);

                        } else if (entity === 'author') {
                            // Действия при успешном обновлении автора
                            alert('Изменения сохранены успешно.');
                        } else if (entity === 'genre') {
                            alert('Изменения сохранены успешно.');
                            $('.genre-select').each(function() {
                                if ($(this).val() === response.updated_genre_id) {
                                    this.text = response.genre[0].name;
                                }
                            });

                        }
                        row.find('option').each(function() {
                            $(this).addClass('d-none');
                        });
                        let inputs = row.find('input, select');
                        inputs.each(function() {
                            $(this).prop('readonly', true);
                            $(this).prop('disabled', true);
                        });
                        row.find('.edit-btn, .delete-btn').removeClass('d-none');
                        row.find('.save-btn, .cancel-btn').addClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка при сохранении изменений.');
                        console.error(error);
                    }
                });
                row.removeClass('editing');
                row.find('.edit-btn, .delete-btn').removeClass('d-none');
                row.find('.save-btn, .cancel-btn').addClass('d-none');
            });

            $('button.delete-btn').click(function() {
                let deleteUrl = $(this).attr('data-url');
                console.log(deleteUrl);
                let row = $(this).closest('tr');
                let id = $(this).attr('data-id');
                let data = {
                    id: id,
                };
                $.ajax({
                    url: 'api' + deleteUrl,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        alert(response.message);
                        row.remove();
                        $('.genre-select').each(function() {
                            let select = $(this);
                            let currentGenreId = select.val();
                            let genreOptions = response.genres.map(function(genre) {
                                return `<option class="genre-select d-none" value="${genre.id}">${genre.name}</option>`;
                            }).join('');

                            select.html(genreOptions);

                            if (currentGenreId == response.deletedGenreId) {
                                select.val(response.genres[0].id);
                            } else {
                                select.val(currentGenreId);
                            }
                        });
                        row = $(this).closest('tr');
                        let inputs = row.find('input, select');
                        inputs.each(function() {
                            $(this).prop('readonly', true);
                            $(this).prop('disabled', true);
                        });
                        row.find('option').each(function() {
                            $(this).addClass('d-none');
                        });
                        row.find('.edit-btn, .delete-btn').removeClass('d-none');
                        row.find('.save-btn, .cancel-btn').addClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка при удалении записи.');
                        console.error(error);
                    }
                });

            });

            $('input[type="file"]').change(function() {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(this).closest('tr').find('.image-preview').attr('src', e.target.result);
                }.bind(this);
                reader.readAsDataURL(this.files[0]);
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
                            <th>Жанры</th>
                            <th>Изображение</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mangas as $manga)
                            <tr>
                                <td hidden=""><input type="text" id="manga_id" value="{{ $manga->id }}"></td>
                                <td><input type="text" name="title" class="form-control" value="{{ $manga->title }}" readonly></td>
                                <td>
                                    <select name="author_id" class="form-control author-select" readonly>
                                        @foreach($authors as $author)
                                            <option class="author-select d-none" value="{{ $author->id }}" @if($author->id === $manga->author_id) selected @endif>{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="date" name="release_date" class="form-control" value="{{ $manga->release_date }}" readonly></td>
                                <td><input type="text" name="description" class="form-control" value="{{ $manga->description }}" readonly></td>
                                <td>
                                    <select name="genre_id" class="form-control genre-select" readonly>
                                        @foreach($genres as $genre)
                                            <option class="genre-select d-none" value="{{ $genre->id }}" @if($genre->id === $manga->genre_id) selected @endif>{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="file" class="form-control-file" disabled>
                                    <img src="{{ $manga->image_path }}" class="img-thumbnail image-preview mt-2" alt="Manga Image">
                                    <input type="hidden" name="image_path" value="{{ $manga->image_path }}">
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Редактировать</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-entity="manga" data-id ="{{ $manga->id }}" data-url="/manga/delete">Удалить</button>
                                    <button class="btn btn-sm btn-success save-btn d-none" data-entity="manga" data-url="/manga/update">Сохранить</button>
                                    <button class="btn btn-sm btn-secondary cancel-btn d-none">Отменить</button>
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
                                <td hidden=""><input type="text" id="author_id" value="{{ $author->id }}"></td>
                                <td><input type="text" name="author" class="form-control" value="{{ $author->name }}" readonly></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Редактировать</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-entity="author" data-id="{{ $author->id }}" data-url="/author/delete">Удалить</button>
                                    <button class="btn btn-sm btn-success save-btn d-none" data-entity="author" data-url="/author/update">Сохранить</button>
                                    <button class="btn btn-sm btn-secondary cancel-btn d-none">Отменить</button>
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
                                <td hidden=""><input type="text" id="genre_id" value="{{ $genre->id }}"></td>
                                <td><input type="text" name="genre" class="form-control" value="{{ $genre->name }}" readonly></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Редактировать</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-entity="genre" data-id="{{ $genre->id }}" data-url="/genre/delete">Удалить</button>
                                    <button class="btn btn-sm btn-success save-btn d-none" data-entity="genre" data-url="/genre/update/">Сохранить</button>                                    <button class="btn btn-sm btn-secondary cancel-btn d-none">Отменить</button>
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
