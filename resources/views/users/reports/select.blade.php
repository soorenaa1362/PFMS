@extends('users.layouts.app')

@section('title')
    گزارشات
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

                            <h6 class="mt-2">گزارشات</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-around">

                            <div>
                                <a href="{{ route('users.reports.incomes.select') }}"
                                    class="text-center text-success d-grid gap-2">
                                    <i class="fas fa-donate text-success fa-4x"></i>
                                    <span style="font-size: 15px;">گزارش درآمدها</span>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('users.reports.costs.select') }}"
                                    class="text-center text-danger d-grid gap-2">
                                    {{-- <i class="fas fa-hand-holding-usd text-danger fa-4x"></i> --}}
                                    <i class="far fa-money-bill-alt text-danger fa-4x"></i>
                                    <span style="font-size: 15px;">گزارش خرجکردها</span>
                                </a>
                            </div>

                        </div>
                        <br>
                        <div class="d-flex justify-content-around">

                            <div>
                                <a href="{{ route('users.deleted.select') }}"
                                    class="text-center text-secondary d-grid gap-2">
                                    <i class="far fa-trash-alt text-secondary fa-4x"></i>
                                    <span style="font-size: 15px;">تراکنش های حذف شده</span>
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
