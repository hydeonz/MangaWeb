@extends('layouts.base')

@section('title', 'Регистрация')

@section('script')
    <script>
        $(document).ready(function () {
            $('button[type="submit"]').click(function (event) {
                event.preventDefault();

                let name = $('#name').val();
                let mail = $('#email').val();
                let password = $('#password').val();
                let password_confirmation = $('#password_confirmation').val();

                if (!name || !mail || !password || !password_confirmation) {
                    alert('Заполнены не все поля!');
                    return;
                }

                let data = {
                    name: name,
                    email: mail,
                    password: password,
                    password_confirmation: password_confirmation,
                };

                $.ajax({
                    url: '/register',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    success: function (response) {
                        alert('Регистрация прошла успешно!');
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = 'Произошла ошибка при регистрации';
                        if (xhr.status === 400 || xhr.status === 500) {
                            let responseJson = JSON.parse(xhr.responseText);
                            errorMessage = 'Произошла ошибка при регистрации: ' + responseJson.message;
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
                <div class="card-header">Регистрация</div>

                <div class="card-body">
                    <form method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
