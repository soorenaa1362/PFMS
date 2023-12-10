@extends('users.layouts.app')

@section('title')
    صفحه اصلی
@endsection

@section('content')
    <div class="container mt-3 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card shadow p-2 mb-5 bg-body">
                    {{-- <div class="card-header bg-primary text-center text-light mt-2">سیستم مالی فراز</div> --}}
                    <div class="card-header text-center text-light bg-primary p-3 m-2" style="border-radius: 10px;">
                        <div class="d-flex justify-content-evenly">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                {{-- <img class="avatar" src="{{ asset('images/avatar.jpg') }}" alt="user"
                                    style="width: 40px; height: 40px; border-radius:50%;"
                                > --}}
                                <i class="fas fa-user-alt text-light fa-2x"></i>
                            </a>

                            <h6 class="mt-2">سیستم مدیریت مالی فراز</h6>
                        </div>
                    </div>

                    @if (blank($cards))
                        <div class="card-body d-grid gap-2">
                            <h5 class="text-center">
                                راهنمای استفاده از سیستم مدیریت مالی فراز
                            </h5>
                            <hr>
                            <p class="text-center">
                                لطفا ابتدا اطلاعات کارت های بانکی
                                خود را وارد کرده تا بتوانید ثبت تراکنش های
                                مالی را انجام دهید .
                            </p>
                            <a href="{{ route('users.cards.create') }}" class="btn btn-success"
                                style="border-radius: 20px;">
                                ثبت اطلاعات کارت بانکی
                            </a>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="d-flex justify-content-between px-4">
                                <a href="">
                                    <i class="fa fa-desktop text-primary text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-primary" style="font-size: 18px;">
                                        داشبورد
                                    </h5>
                                </a>
                                <a href="{{ route('users.cards.index') }}">
                                    <i class="fa fa-credit-card text-secondary text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-secondary" style="font-size: 18px;">
                                        کارت ها
                                    </h5>
                                </a>
                            </div> <!-- row -->

                            <div class="d-flex justify-content-between px-4 mt-3">
                                <a href="">
                                    <i class="fas fa-donate text-success text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-success" style="font-size: 18px;">
                                        درآمدها
                                    </h5>
                                </a>
                                <a href="">
                                    <i class="fas fa-hand-holding-usd text-danger text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-danger" style="font-size: 18px;">
                                        مخارج
                                    </h5>
                                </a>
                            </div> <!-- row -->

                            <div class="d-flex justify-content-between px-4 mt-3">
                                <a href="">
                                    <i class="fas fa-sitemap text-info text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-info" style="font-size: 18px;">
                                        دسته ها
                                    </h5>
                                </a>
                                <a href="">
                                    <i class="fa fa-newspaper-o text-warning text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-warning" style="font-size: 18px;">
                                        گزارشات
                                    </h5>
                                </a>
                            </div> <!-- row -->

                            <div class="d-flex justify-content-between px-4 mt-3">
                                <a href="#">
                                    <i class="fas fa-wrench text-dark text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-dark" style="font-size: 18px;">
                                        تنظیمات
                                    </h5>
                                </a>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                                >
                                    <i class="fas fa-door-open text-dark text-center fa-3x"></i>
                                    <h5 class="text-center mt-2 text-dark" style="font-size: 18px;">
                                        خروج
                                    </h5>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div> <!-- row -->
                        </div> <!-- card body -->
                    @endif

                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection













