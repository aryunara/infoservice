<!DOCTYPE html>
<html>
<head>
    <title>Custom Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="{{ route('main') }}">Информатика и Сервис</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('main') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Зарегистрироваться</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('main') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leads') }}">Лиды</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Выйти</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    @yield('content')
</div>
</body>
</html>
