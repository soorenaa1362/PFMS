@extends('users.layouts.app')

@section('title')
    ثبت نام
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6 px-3">
                {{-- <div class="card shadow p-3 mb-5 bg-body"> --}}
                    <div class="card-header bg-primary text-center text-light mt-2">ثبت نام در سیستم</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">نام</label>
                                <input name="name" type="name" class="form-control" id="name" value="{{ old('name') }}" autofocus>
                                @error('name')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobile" class="form-label">شماره موبایل</label>
                                <input name="mobile" type="number" class="form-control" id="mobile" value="{{ old('mobile') }}" autofocus>
                                @error('mobile')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
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

                            <div class="mb-3">
                                <label for="password" class="form-label">تکرار رمز عبور</label>
                                <input name="password_confirmation" type="password" class="form-control" id="password">
                                @error('password_confirmation')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid my-4">
                            {{-- <div class="d-flex justify-content-between"> --}}
                                <button class="btn btn-primary text-light" type="submit">ثبت نام</button>
                            </div>
                            <div class="d-grid justify-content-center">
                                <a href="{{ route("login") }}" class="mt-2">قبلا در سیستم ثبت نام کرده ام.</a>
                            </div>
                        </form>
                    </div> <!-- card body -->
                {{-- </div> --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->
@endsection
