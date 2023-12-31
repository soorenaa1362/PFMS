@extends('users.layouts.app')

@section('title')
    لیست خرجکرد ها
@endsection

@section('content')
    <div class="container mt-3 p-2">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card shadow p-2 mb-5 bg-body">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('users.reports.costs.select') }}" class="text-dark p-1">
                            <i class="fa fa-hand-o-left fa-2x"></i>
                        </a>
                    </div>

                    <div class="card-header text-center text-light bg-primary p-3 m-2"
                        style="border-radius: 15px;">
                        <div class="d-flex justify-content-between">

                            @include('users.sections.profile_icon')

                            <h6 class="mt-2">لیست خرجکردهای هفته</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center" style="margin-bottom: 0 !important">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        @if ( count($costCategories) == 0 )
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center">
                                    برای ذخیره ی خرجکردها ابتدا باید دسته های خرجکردی
                                    در سیستم ثبت نمایید.
                                </h6>
                                <a href="{{ route('users.categories.costs.create') }}" class="btn btn-success"
                                    style="border-radius: 15px;">
                                    ثبت دسته های خرجکرد
                                </a>
                            </div>
                        @else
                            @if (blank($costs))
                                <div class="d-grid gap-2 mt-2">
                                    <h6 class="text-center">
                                        هنوز هیچ خرجکردی در سیستم ثبت نکرده اید.
                                    </h6>
                                    <a href="{{ route('users.costs.create') }}" class="btn btn-success"
                                        style="border-radius: 15px;">
                                        ثبت خرجکرد
                                    </a>
                                </div>
                            @else
                                <h6 class="text-center text-light p-3 bg-secondary"
                                    style="border-radius: 10px;">
                                    مجموع خرجکرد هفته : {{ number_format($totalCost) }} تومان
                                </h6>
                                {{-- <div class="d-grid gap-2 m-2">
                                    <a class="btn btn-success" href="{{ route('users.costs.create') }}"
                                        style="border-radius: 15px;">
                                        <i class="fa fa-plus"></i>
                                        خرجکرد جدید
                                    </a>
                                </div> --}}
                                <hr>
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>عنوان</th>
                                            <th>مبلغ</th>
                                            <th>کارت بانکی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($costs as $cost)
                                            <tr>
                                                <th>
                                                    <a href="{{ route('users.costs.show', $cost->id) }}">
                                                        {{ $cost->getDateJalali() }}
                                                    </a>
                                                </th>
                                                <th>
                                                    <a href="{{ route('users.costs.show', $cost->id) }}">
                                                        {{ $cost->title }}
                                                    </a>
                                                </th>
                                                <th>
                                                    <a href="{{ route('users.costs.show', $cost->id) }}">
                                                        {{ number_format($cost->amount) }} تومان
                                                    </a>
                                                </th>
                                                <th>
                                                    <a href="{{ route('users.costs.show', $cost->id) }}">
                                                        {{ $cost->card->name }}
                                                    </a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $costs->links() }}

                            @endif
                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
