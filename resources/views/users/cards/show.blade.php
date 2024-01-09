@extends('users.layouts.app')

@section('title')
    نمایش اطلاعات کارت
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
                                نمایش اطلاعات کارت
                            </h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                نام کارت : {{ $card->name }}
                            </div>
                            <div class="col-md-6 mb-2">
                                @if ($card->alias === null)
                                    نام مستعار : - - - - - - - -
                                @else
                                    نام مستعار : {{ $card->alias }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                شماره کارت : {{ $card->number }}
                            </div>
                            <div class="col-md-6 mb-2">
                                موجودی : {{ number_format($card->current_cash) }} تومان
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                تاریخ ثبت کارت : {{ $card->getDateJalali() }}
                            </div>
                            @if ($card->description === null)

                            @else
                            <div class="col-md-6 mb-8">
                                    توضیحات : <br> {{ $card->description }}
                                </div>
                            @endif
                        </div>
                        <hr>

                        <div class="d-grid gap-2 col-6 mx-auto">
                            @if ( count($incomes) == 0 )
                                <a href="{{ route('users.cards.edit', $card->id) }}"
                                    class="btn btn-warning"
                                    style="border-radius: 15px;">
                                    <i class="fas fa-edit"></i>
                                    ویرایش اطلاعات
                                </a>
                            @else
                                <button type="button" class="btn btn-warning"
                                    style="border-radius: 15px;"
                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i>
                                    ویرایش اطلاعات
                                </button>
                            @endif
                            <a href="{{ route('users.cards.transaction.select', $card->id) }}"
                                class="btn btn-info"
                                style="border-radius: 15px;">
                                <i class="fa fa-exchange"></i>
                                ثبت تراکنش
                            </a>
                            {{-- <a href="{{ route('users.cards.delete', $card->id) }}"
                                style="border-radius: 15px;"
                                class="btn btn-danger"
                                onclick="return confirm('آیا میخواهید این کارت بانکی را حذف کنید؟')">
                                <i class="fas fa-trash-alt"></i>
                                حذف
                            </a> --}}
                        </div>

                        @if ( !blank($incomes) )
                            <hr>
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center text-light p-2 bg-success"
                                    style="border-radius: 10px;">
                                    <i class="fas fa-donate"></i>
                                    آخرین درآمدها
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
                            @if ( $incomeCount > 3 )
                                <a href="{{ route('users.cards.incomes.index', $card->id) }}"
                                    class="d-flex justify-content-end text-secondary">
                                    نمایش موارد بیشتر
                                </a>
                            @endif
                        @endif

                        @if ( !blank($costs) )
                            <hr>
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center text-light p-2 bg-danger"
                                    style="border-radius: 10px;">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    آخرین خرجکردها
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
                            @if ( $costCount > 3 )
                                <a href="{{ route('users.cards.costs.index', $card->id) }}"
                                    class="d-flex justify-content-end text-secondary">
                                    نمایش موارد بیشتر
                                </a>
                            @endif
                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->
                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">ویرایش کارت</h5>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        برای این کارت تراکنش ذخیره شده است .
                        <a href="{{ route('users.cards.checkTransactions', $card->id) }}" class="btn btn-sm btn-info">
                            تراکنش ها را بررسی میکنم .
                        </a>
                        <a href="{{ route('users.cards.edit', $card->id) }}" class="btn btn-warning mt-3"
                            style="border-radius: 15px;">
                            <i class="fas fa-edit"></i>
                            مهم نیست در هر صورت ویرایش میکنم .
                        </a>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        بستن پنجره
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('users.sections.modal') --}}

@endsection
