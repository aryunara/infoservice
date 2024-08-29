@extends('auth.layouts')
@section('content')

    <main class="profile-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Смена пароля</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="old-psw"><strong>Старый пароль</strong></label>
                                    <input type="password" class="form-control" name="old-psw" style="margin-top: 10px" required>
                                    @error('old-psw')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="new-psw"><strong>Новый пароль</strong></label>
                                    <input type="password" class="form-control" name="new-psw" style="margin-top: 10px" required>
                                    @error('new-psw')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <br>

                                <button type="submit" class="btn btn-primary mt-3" style="background-color: #006699">Сохранить изменения</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" style="margin-top: 30px">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Подтверждение почты</h3>
                        </div>
                        <div class="card-body">
                            <strong>Ваша электронная почта:</strong> {{ Auth::user()->email }}
                            <br>
                            @if(empty(Auth::user()->email_verified_at))
                                <strong>Статус верификации:</strong> почта не подтверждена.
                                <br><br>
                                <strong>Нажмите на кнопку ниже, чтобы повторно отправить письмо на Вашу электронную почту.</strong>
                                <br>
                                <a href="{{ route('confirm.email') }}"><button type="submit" class="btn btn-primary mt-3" style="background-color: #006699">Отправить</button></a>
                            @else
                                <strong>Статус верификации:</strong> почта подтверждена.
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection
