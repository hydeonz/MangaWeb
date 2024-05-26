@extends('layouts.base')

@section('title', 'Добавление манги')

@section('script')
    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function() {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(this).closest('.form-group').find('.image-preview').attr('src', e.target.result);
                }.bind(this);
                reader.readAsDataURL(this.files[0]);
            });

            $('button[type="submit"]').click(function(event) {
                event.preventDefault();

                let title = $('#title').val();
                let author_id = $('#author_id').val();
                let release_date = $('#release_date').val();
                let description = $('#description').val();
                let genre_id = $('#genre_id').val();
                let image = $('#image')[0].files[0];

                if (!title || !author_id || !release_date || !description || !genre_id || !image) {
                    alert('Все поля должны быть заполнены.');
                    return;
                }

                let formData = new FormData();
                formData.append('title', title);
                formData.append('author_id', author_id);
                formData.append('release_date', release_date);
                formData.append('description', description);
                formData.append('genre_id', genre_id);
                formData.append('image', image);

                $.ajax({
                    url: '/manga/add',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.message)
                        // Дополнительно: Очистить поля формы после успешного добавления
                        $('#title').val('');
                        $('#author_id').val('');
                        $('#release_date').val('');
                        $('#description').val('');
                        $('#genre_id').val('');
                        $('#image').val('');
                        $('.image-preview').attr('src', '');
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка при добавлении манги.');
                    }
                });
            });
        });
    </script>
@endsection

@section('main')
    <div class="container-fluid">
        <h2 class="text-white mt-4">Добавить мангу</h2>
        <div class="form-group">
            <label for="title" class="text-white">Название</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="author_id" class="text-white">Автор</label>
            <select class="form-control" id="author_id" name="author_id">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="release_date" class="text-white">Дата выпуска</label>
            <input type="date" class="form-control" id="release_date" name="release_date">
        </div>
        <div class="form-group">
            <label for="description" class="text-white">Описание</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="genre_id" class="text-white">Жанры</label>
            <select class="form-control" id="genre_id" name="genre_id" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image" class="text-white">Изображение</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <img src="" class="img-thumbnail image-preview mt-2 w-25 h-25" alt="Manga Image">
            <input type="hidden" name="image_path" value="">
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
@endsection
