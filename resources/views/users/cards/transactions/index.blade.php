@extends('users.layouts.app')

@section('title')
    لیست تراکنش ها
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                {{-- <div class="card shadow p-2 mb-5 bg-body"> --}}
                   
                    <div class="card-header text-center text-light bg-primary p-3 m-1"
                        style="border-radius: 15px;">
                        <div class="d-flex justify-content-between">

                            @include('users.sections.profile_icon')

                            <h6 class="mt-2">
                                @if ($card->alias === null)
                                    لیست تراکنش های کارت : {{ $card->name }}
                                @else
                                    لیست تراکنش های کارت : {{ $card->name }} ({{ $card->alias }})
                                @endif
                            </h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                    <div class="alert alert-success text-center" style="margin-bottom: 0 !important">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">

                        @if (blank($incomes))
                            <h6 class="text-center bg-success p-2 text-light">
                                هنوز هیچ درآمدی ثبت نشده است.
                            </h6>
                        @else
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center text-light p-2 bg-success"
                                    style="border-radius: 10px;">
                                    <i class="fas fa-donate"></i>
                                    لیست درآمدها
                                </h6>
                            </div>
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>عنوان</th>
                                        <th>مبلغ (تومان)</th>
                                        <th>دسته بندی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $income)
                                        <tr>
                                            <th>
                                                <a href="{{ route('users.incomes.show', [$income->id]) }}">
                                                    {{ $income->getDateJalali() }}
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.incomes.show', [$income->id]) }}">
                                                    {{ $income->title }}
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.incomes.show', [$income->id]) }}">
                                                    {{ number_format($income->amount) }}
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.incomes.show', [$income->id]) }}">
                                                    {{ $income->category->title }}
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $incomes->links() }}

                        @endif

                        @if (blank($costs))
                            <h6 class="text-center bg-danger p-2 text-light">
                                هنوز هیچ خرجکردی ثبت نشده است.
                            </h6>
                        @else
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center text-light p-2 bg-danger"
                                    style="border-radius: 10px;">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    لیست خرجکردها
                                </h6>
                            </div>
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>عنوان</th>
                                        <th>مبلغ (تومان)</th>
                                        <th>دسته بندی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($costs as $cost)
                                        <tr>
                                            <th>
                                                <a href="{{ route('users.costs.show', [$cost->id]) }}">
                                                    {{ $cost->getDateJalali() }}
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.costs.show', [$cost->id]) }}">
                                                    {{ $cost->title }}
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.costs.show', [$cost->id]) }}">
                                                    {{ number_format($cost->amount) }}
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.costs.show', [$cost->id]) }}">
                                                    {{ $cost->category->title }}
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $costs->links() }}

                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->
                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
