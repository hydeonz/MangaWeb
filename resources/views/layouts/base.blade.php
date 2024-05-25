<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="{{ asset('scripts/jq.js') }}"></script>
    @yield('script')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
</head>
<body class="bg-dark">
<div class="container">
    <nav class="navbar navbar-light bg-dar p-3 text-bg-dark">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{ route('home') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none logo">
                <h5 class="m-0">MangaWiki <span class="badge bg-warning warn__badge">Lite</span></h5>
            </a>
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li>
                <a href="{{route('home')}}" class="nav-link px-2 text-secondary d-flex align-items-center column-gap-2 link-offset-1-hover">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                    </svg>
                    <span>Главная</span>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                    </svg>
                    <span>Лучшее</span>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                        <path d="M2.5 1a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h11a.5.5 0 0 1-.5-.5V1.5a.5.5 0 0 1 .5-.5h-11zM3 14V2h10v12H3z"/>
                        <path fill-rule="evenodd" d="M0 0v16h16V0H0zm10.5 2.5a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5H11a.5.5 0 0 1-.5-.5V2.5zM11 2v11h1V2h-1z"/>
                    </svg>
                    <span>Жанры</span>
                </a>
            </li>
        </ul>
            @guest
                <a href="{{ route('login') }}" type="button" class="btn btn-outline-light me-2 d-flex align-items-center column-gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                    <span>Войти</span>
                </a>
                <a href="{{ route('register') }}" type="button" class="btn btn-warning d-flex align-items-center column-gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                        <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                    </svg>
                    <span>Создать аккаунт</span>
                </a>
            @endguest

        @auth
                @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin') }}" type="button" class="btn btn-outline-light me-2 d-flex align-items-center column-gap-2">
                            <span>Панель администрирования</span>
                        </a>
                @endif
            <form action="{{ route('logout') }}" method="post" class="form-check-inline">
                @csrf
                <input type="submit" class="btn btn-danger" value="Выход">
            </form>
        @endauth
    </nav>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2 border-bottom">
        <h1 class="h2 text-white">@yield('center')</h1>
    </div>
    @yield('main')
</div>
</body>
</html>
