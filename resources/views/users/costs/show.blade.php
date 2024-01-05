@extends('users.layouts.app')

@section('title')
    نمایش جزییات خرجکرد
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
                                نمایش جزییات خرجکرد
                            </h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                عنوان : {{ $cost->title }}
                            </div>
                            <div class="col-md-6 mb-2">
                                تاریخ : {{ $cost->getDateJalali() }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                کارت : {{ $cost->card->name}}
                            </div>
                            <div class="col-md-6 mb-2">
                                مبلغ : {{ number_format($cost->amount) }} تومان
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                @if ( $cost->category->parent == null )
                                    دسته بندی : {{ $cost->category->title }}
                                @else
                                    دسته بندی : {{ $cost->category->title }} ({{ $cost->category->parent->title }})
                                @endif
                            </div>
                            @if ($cost->description === null)

                            @else
                            <div class="col-md-6 mb-8">
                                    توضیحات : <br> {{ $cost->description }}
                                </div>
                            @endif
                        </div>
                        <hr>

                        <div class="d-grid gap-2 col-12 mx-auto">
                            <a href="{{ route('users.costs.edit', $cost->id) }}"
                                class="btn btn-warning"
                                style="border-radius: 15px;">
                                <i class="fas fa-edit"></i>
                                ویرایش اطلاعات
                            </a>
                            <a href="{{ route('users.costs.delete', $cost->id) }}"
                                style="border-radius: 15px;"
                                class="btn btn-danger"
                                onclick="return confirm('آیا میخواهید این خرجکرد را حذف کنید؟')">
                                <i class="fas fa-trash-alt"></i>
                                حذف
                            </a>
                        </div>

                        @include('users.sections.footer')

                    </div> <!-- card body -->
                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
