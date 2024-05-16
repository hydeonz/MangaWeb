@extends('layouts.base')

@section('title', 'Авторизация')

@section('script')
    <script>
        $(document).ready(function () {
            $('button[type="submit"]').click(function (event) {
                event.preventDefault();
                let mail = $('#email').val();
                let password = $('#password').val();

                if (!mail || !password) {
                    alert('Заполнены не все поля!');
                    return;
                }

                let data = {
                    email: mail,
                    password: password,
                };

                $.ajax({
                    url: 'login',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    success: function (response) {
                        alert('Авторизация прошла успешно!');
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = 'Произошла ошибка при авторизации';
                        if (xhr.status === 400 || xhr.status === 401) {
                            let responseJson = JSON.parse(xhr.responseText);
                            errorMessage = 'Произошла ошибка при авторизации: ' + responseJson.message;
                        }
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Авторизация</div>

                <div class="card-body">
                    <div class="mb-3">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <label for="email" class="form-label">E-Mail</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </div>
        </div>
    </div>
@endsection
