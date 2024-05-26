@extends('layouts.base')

@section('title', 'Добавление автора')

@section('script')
    <script>
        $(document).ready(function() {

            $('button[type="submit"]').click(function(event) {
                let name = $('#name').val();
                if (!name) {
                    alert('Все поля должны быть заполнены.');
                    return;
                }

                let formData = new FormData();
                formData.append('name', name);

                $.ajax({
                    url: '/genre/add',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.message)
                        $('#name').val('');
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка при добавлении жанра.');
                    }
                });
            });
        });
    </script>
@endsection

@section('main')
    <div class="container-fluid">
        <h2 class="text-white mt-4">Добавить жанр</h2>
        <div class="form-group">
            <label for="name" class="text-white">Название</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
@endsection
