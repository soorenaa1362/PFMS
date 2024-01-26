@extends('users.layouts.app')

@section('title')
    گزارش خرجکردها
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                {{-- <div class="card shadow p-2 mb-5 bg-body"> --}}

                    <div class="card-header text-center text-light bg-primary p-3 m-2"
                        style="border-radius: 15px;">
                        <div class="d-flex justify-content-between">

                            @include('users.sections.profile_icon')

                            <h6 class="mt-2">گزارش خرجکردها</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-around">

                            <div>
                                <a href="{{ route('users.reports.costs.time.day') }}"
                                    class="text-center text-success d-grid gap-2">
                                    <i class="far fa-file-alt text-success fa-4x"></i>
                                    <span style="font-size: 15px;">گزارش روزانه</span>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('users.reports.costs.time.week') }}"
                                    class="text-center text-info d-grid gap-2">
                                    <i class="far fa-file-alt text-info fa-4x"></i>
                                    <span style="font-size: 15px;">گزارش هفتگی</span>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('users.reports.costs.time.month') }}"
                                    class="text-center text-dark d-grid gap-2">
                                    <i class="far fa-file-alt text-dark fa-4x"></i>
                                    <span style="font-size: 15px;">گزارش ماهانه</span>
                                </a>
                            </div>
                        </div>

                        @include('users.sections.footer')

                    </div> <!-- card body -->
                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
