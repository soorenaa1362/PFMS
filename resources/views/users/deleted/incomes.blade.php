@extends('users.layouts.app')

@section('title')
    لیست درآمد های حذف شده
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

                            <h6 class="mt-2">لیست درآمدهای حذف شده</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center" style="margin-bottom: 0 !important">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        @if ( count($incomeCategories) == 0 )
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center">
                                    برای ذخیره ی درآمدها ابتدا باید دسته های درآمدی
                                    در سیستم ثبت نمایید.
                                </h6>
                                <a href="{{ route('users.categories.incomes.create') }}" class="btn btn-success"
                                    style="border-radius: 15px;">
                                    ثبت دسته های درآمد
                                </a>
                            </div>
                        @else
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>مبلغ (تومان)</th>
                                        <th>کارت بانکی</th>
                                        <th>بازیابی</th>
                                        <th>حذف کلی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $income)
                                        <tr>
                                            <th>
                                                {{ $income->title }}
                                            </th>
                                            <th>
                                                {{ number_format($income->amount) }}
                                            </th>
                                            <th>
                                                {{ $income->card->name }}
                                            </th>
                                            <th>
                                                <a href="{{ route('users.deleted.incomes.restore', $income->id) }}"
                                                    style="border-radius: 15px;"
                                                    onclick="return confirm('آیا میخواهید این درآمد را بازیابی کنید؟')">
                                                    <i class="mt-2 fas fa-undo-alt text-success"></i>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.deleted.incomes.forceDelete', $income->id) }}"
                                                    style="border-radius: 15px;"
                                                    onclick="return confirm('آیا میخواهید این درآمد را به کل حذف کنید؟')">
                                                    <i class="mt-2 fas fa-trash-alt text-danger"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $incomes->links() }}

                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
