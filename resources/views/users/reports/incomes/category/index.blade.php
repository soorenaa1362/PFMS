@extends('users.layouts.app')

@section('title')
    لیست درآمد ها
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

                            <h6 class="mt-2">لیست درآمدهای دسته ی {{ $category->title }}</h6>

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
                                @foreach ($incomes as $income)
                                    <tr>
                                        <th>
                                            <a href="{{ route('users.incomes.show', $income->id) }}">
                                                {{ $income->getDateJalali() }}
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('users.incomes.show', $income->id) }}">
                                                {{ $income->title }}
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('users.incomes.show', $income->id) }}">
                                                {{ number_format($income->amount) }} تومان
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('users.incomes.show', $income->id) }}">
                                                {{ $income->card->name }}
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $incomes->links() }}

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                {{-- </div> --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
