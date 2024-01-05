@extends('users.layouts.app')

@section('title')
    لیست خرجکرد ها
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card shadow p-2 mb-5 bg-body">

                    <div class="card-header text-center text-light bg-primary p-3 m-2"
                        style="border-radius: 15px;">
                        <div class="d-flex justify-content-between">

                            @include('users.sections.profile_icon')

                            @if($card->alias === null)
                                <h6 class="mt-2">لیست خرجکردهای کارت : {{ $card->name }}</h6>
                            @else
                                <h6 class="mt-2">لیست خرجکردهای کارت : {{ $card->name }} ({{ $card->alias }})</h6>
                            @endif

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                    <div class="alert alert-success text-center" style="margin-bottom: 0 !important">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">

                        <h6 class="text-center text-light p-3 bg-secondary"
                            style="border-radius: 10px;">
                            خرجکرد کل : {{ number_format($totalCost) }} تومان
                        </h6>
                        <div class="d-grid gap-2 m-2">
                            <a class="btn btn-success" href="{{ route('users.cards.costs.create', $card->id) }}"
                                style="border-radius: 15px;">
                                <i class="fa fa-plus"></i>
                                خرجکرد جدید
                            </a>
                        </div>
                        <hr>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>تاریخ</th>
                                    <th>عنوان</th>
                                    <th>مبلغ</th>
                                    <th>دسته بندی</th>
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
                                                {{ $cost->category->title }}
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                        {{ $costs->links() }}

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
