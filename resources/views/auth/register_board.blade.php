@extends('auth.layouts')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Благодарим за регистрацию!</strong></div>
                <div class="card-body">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            На указанный Вами адрес было выслано письмо с подтверждением регистрации. Пожалуйста, подтвердите свою электронную почту и <a href="{{ route('login') }}">войдите в аккаунт</a>.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            При регистрации произошла ошибка. Пожалуйста, <a href="{{ route('login') }}">попробуйте еще раз</a> или обратитесь в службу поддержки.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
