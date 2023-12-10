@extends('users.layouts.app')

@section('title')
    صفحه اصلی
@endsection

@section('content')
    <div class="container mt-5 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card shadow p-2 mb-5 bg-body">
                    <div class="card-header text-center text-light bg-primary p-3 m-2"
                        style="border-radius: 30px 30px 5px 5px;">
                        سیستم مدیریت مالی فراز
                    </div>
                    <div class="card-body">
                        <p class="font-weight-bold text-center text-dark">
                            سیستم مدیریت مالی فراز یک سیستم ساده ی حسابداری است
                            برای مدیریت درآمدها و خرجکردهای شخصی
                        </p>
                        <p class="font-weight-bold text-center text-light bg-secondary p-3"
                            style="border-radius: 5px 5px 30px 30px;">
                            تحلیل - طراحی و پیاده سازی :‌ مجید حیدری نسب
                        </p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}" class="btn btn-success text-white mt-2"
                                style="border-radius: 15px;">
                                ورود
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-info text-white mt-2"
                                style="border-radius: 15px;">
                                ثبت نام
                            </a>
                        </div>
                    </div> <!-- card body -->
                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->
@endsection













