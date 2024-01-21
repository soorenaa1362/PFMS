@extends('users.layouts.app')

@section('title')
    ثبت درآمد
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/persianDatePicker/persian-datepicker.css') }}">
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

                            @if ($card->alias == null)
                                <h6 class="mt-2">ثبت درآمد : {{ $card->name }}</h6>
                            @else
                                <h6 class="mt-2">ثبت درآمد : {{ $card->name }} ({{ $card->alias }})</h6>
                            @endif

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">
                        @if ( count($categories) == 0 )
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
                        <h6 class="text-center text-light p-3 bg-secondary"
                            style="border-radius: 10px;">
                            موجودی : {{ number_format($card->current_cash) }} تومان
                        </h6>
                            <form action="{{ route('users.cards.incomes.store', $card->id) }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6 mt-2">
                                        <label for="title">عنوان</label>
                                        <input class="form-control" name="title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="amount">مبلغ (تومان)</label>
                                        <input class="form-control" name="amount" value="{{ old('amount') }}">
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="category_id">دسته بندی</label>
                                        <select class="form-select" name="category_id" id="category_id">
                                            <option value="">---------</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="date">تاریخ</label>
                                        <input type="text" class="form-control round addpo"
                                            id="dateFake" name="dateFake" readonly required value="">
                                        <input id="date" name="date"
                                            type="hidden" value="">
                                        @error('date')
                                            <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 mt-2">
                                        <label for="description">توضیحات</label>
                                        <textarea name="description" class="form-control">
                                            {{ old('description') }}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-2">
                                    <button class="btn btn-success mt-3" type="submit"
                                        style="border-radius: 15px;">
                                        ثبت
                                    </button>
                                </div>

                            </form>
                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->
                {{-- </div>  --}}
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection

@section('script')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/persianDatePicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persianDatePicker/persian-datepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#dateFake").pDatepicker({
                initialValueType: 'persian',
                initialValue: false,
                format: 'YYYY/MM/DD',
                autoClose: true,
                altField: '#date',
                altFormat: 'X', //timestarmp
            });
        });
    </script>
@endsection
