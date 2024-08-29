@extends('auth.layouts')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Смена пароля</strong></div>
                <div class="card-body">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            Вы успешно изменили пароль! Вернуться <a href="{{ route('profile') }}">в профиль</a>.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            При обновлении пароля произошла ошибка. Пожалуйста, <a href="{{ route('profile') }}">попробуйте еще раз</a> или обратитесь в службу поддержки.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
