@extends('users.layouts.app')

@section('title')
    نمایش اطلاعات کارت
@endsection

@section('content')
    <div class="container mt-3 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card shadow p-2 mb-5 bg-body">
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

                        <div class="d-grid gap-2 col-12 mx-auto">
                            <a href="{{ route('users.cards.edit', $card->id) }}"
                                class="btn btn-warning"
                                style="border-radius: 15px;">
                                <i class="fas fa-edit"></i>
                                ویرایش اطلاعات
                            </a>
                            <a href="" class="btn btn-info"
                                style="border-radius: 15px;">
                                <i class="fa fa-exchange"></i>
                                ثبت تراکنش
                            </a>
                            <button type="button" class="btn btn-danger"
                                style="border-radius: 15px;"
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-edit"></i>
                                حذف
                            </button>
                        </div>

                        @include('users.sections.footer')

                    </div> <!-- card body -->
                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
