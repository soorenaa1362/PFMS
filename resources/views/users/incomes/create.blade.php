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

                            <h6 class="mt-2">ثبت درآمد</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.incomes.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-5 mt-2">
                                    <label for="title">عنوان</label>
                                    <input class="form-control" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-danger" style="font-size: 14px;">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3 mt-2">
                                    <label for="amount">مبلغ (تومان)</label>
                                    <input class="form-control" name="amount" value="{{ old('amount') }}">
                                    @error('amount')
                                        <span class="text-danger" style="font-size: 14px;">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <label for="card_id">کارت بانکی</label>
                                    <select class="form-select" name="card_id" id="card_id">
                                        <option value="">---------</option>
                                        @foreach ($cards as $card)
                                            <option value="{{ $card->id }}">{{ $card->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('card_id')
                                        <span class="text-danger" style="font-size: 14px;">
                                            {{ $message }}
                                        </span>
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
                                    @error('category_id')
                                        <span class="text-danger" style="font-size: 14px;">
                                            {{ $message }}
                                        </span>
                                    @enderror
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
