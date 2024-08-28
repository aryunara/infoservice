@extends('auth.layouts')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Благодарим за обращение!</strong></div>
                <div class="card-body">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            Ваше обращение создано! Для просмотра обращений <a href="{{ route('login') }}">войдите в аккаунт</a>.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            При создании обращения произошла ошибка. Пожалуйста, <a href="{{ route('main') }}">попробуйте еще раз</a> или обратитесь в службу поддержки.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
