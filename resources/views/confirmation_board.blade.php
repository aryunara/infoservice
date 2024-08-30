@extends('auth.layouts')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Письмо было успешно отправлено</strong></div>
                <div class="card-body">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            Письмо было отправлено на Вашу почту. Вернуться <a href="{{ route('profile') }}">в профиль</a>.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            При отправке письма на почту произошла ошибка. Пожалуйста, <a href="{{ route('profile') }}">попробуйте еще раз</a> или обратитесь в службу поддержки.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
