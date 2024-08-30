@extends('auth.layouts')
@section('content')

    <main class="main-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <h3 class="card-header text-center">Форма обращения</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('main') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Имя" id="name" class="form-control" name="name"
                                           required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Фамилия" id="surname" class="form-control"
                                           name="surname" required>
                                    @if ($errors->has('surname'))
                                        <span class="text-danger">{{ $errors->first('surname') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="tel" placeholder="Номер телефона" id="phone" class="form-control"
                                           name="phone" required>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" placeholder="Электронная почта" id="email" class="form-control"
                                           name="email" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <textarea placeholder="Текст обращения" rows="5" id="text" class="form-control"
                                              name="text" required></textarea>
                                    @if ($errors->has('text'))
                                        <span class="text-danger">{{ $errors->first('text') }}</span>
                                    @endif
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block" style="background-color: #006699">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
