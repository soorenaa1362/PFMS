@extends('users.layouts.app')

@section('title')
    ورود
@endsection

@section('content')
    <div class="container mt-5 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card shadow p-3 mb-5 bg-body">
                    <div class="card-header bg-success text-center text-light mt-2">ورود به سیستم</div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">ایمیل یا موبایل</label>
                                <input name="email" type="text" class="form-control" id="email" value="{{ old('email') }}" autofocus>
                                {{-- @error('email')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror --}}
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">رمز عبور</label>
                                <input name="password" type="password" class="form-control" id="password">
                                @error('password')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        رمز عبور خود را فراموش کرده ام.
                                    </a>
                                @endif
                                <button class="btn btn-success text-light" type="submit">ورود</button>
                            </div>
                            <hr>

                            <div class="d-flex justify-content-center">
                                <a href="{{ route("register") }}">میخواهم ثبت نام کنم.</a>
                            </div>
                        </form>
                    </div> <!-- card body -->
                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->
@endsection
