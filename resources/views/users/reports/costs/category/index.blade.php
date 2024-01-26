@extends('users.layouts.app')

@section('title')
    لیست خرجکرد ها
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">

                    <div class="card-header text-center text-light bg-primary p-3 m-2"
                        style="border-radius: 15px;">
                        <div class="d-flex justify-content-between">

                            @include('users.sections.profile_icon')

                            <h6 class="mt-2">لیست خرجکردهای دسته ی {{ $category->title }}</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center" style="margin-bottom: 0 !important">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
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

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                {{-- </div> --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
