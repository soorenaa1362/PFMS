@extends('users.layouts.app')

@section('title')
    صفحه اصلی
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6 p-2">
                {{-- <div class="card shadow p-2 mb-5 bg-body"> --}}
                    <div class="card-header text-center text-light bg-primary p-4 mx-3"
                        style="border-radius: 30px 30px 5px 5px;">
                        سیستم مدیریت مالی فراز
                    </div>
                    <div class="card-body">
                        <p class="lh-lg font-weight-bold text-center text-dark p-2">
                            سیستم مدیریت مالی فراز یک سیستم ساده ی حسابداری است
                            برای مدیریت درآمدها و خرجکردهای شخصی
                        </p>
                        <p class="font-weight-bold text-center text-light bg-secondary p-3"
                            style="border-radius: 5px 5px 30px 30px;">
                            تحلیل - طراحی و پیاده سازی :‌ مجید حیدری نسب
                        </p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}" class="btn btn-success text-white p-2 mt-3"
                                style="border-radius: 15px;">
                                ورود
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary text-white p-2 mt-2"
                                style="border-radius: 15px;">
                                ثبت نام
                            </a>
                        </div>
                    </div> <!-- card body -->
                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->
@endsection













