@extends('auth.layouts')
@section('content')

    <main class="signup-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <h3 class="card-header text-center">Регистрация</h3>
                        <div class="card-body">
                            <form action="{{ route('post.register') }}" method="POST">
                                @csrf

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Имя пользователя" id="username" class="form-control" name="username"
                                           required autofocus>
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Электронная почта" id="email_address" class="form-control"
                                           name="email" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Пароль" id="password" class="form-control"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block" style="background-color: #006699">Зарегистрироваться</button>
                                </div>

                                <div style="margin-top: 20px; margin-left: 153px">
                                    <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
