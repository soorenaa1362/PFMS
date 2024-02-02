@extends('users.layouts.app')

@section('title')
    ویرایش کارت
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

                            @if ($card->alias === null)
                                <h6 class="mt-2">ویرایش اطلاعات کارت : {{ $card->name }}</h6>
                            @else
                                <h6 class="mt-2">ویرایش اطلاعات کارت : {{ $card->name }} ({{ $card->alias }})</h6>
                            @endif

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.cards.update', $card->id) }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="row">
                                <div class="form-group col-md-6 mt-2">
                                    <label for="name">نام</label>
                                    <input class="form-control" name="name" value="{{ $card->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mt-2">
                                    <label for="alias">نام مستعار</label>
                                    <input class="form-control" name="alias" value="{{ $card->alias }}">
                                    @error('alias')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <label for="date">تاریخ ثبت کارت</label>
                                    <input type="text" class="form-control round addpo"
                                        id="dateFake" name="dateFake" readonly required
                                        value="{{ $card->getDateJalali() }}">
                                    <input id="date" name="date"
                                        type="hidden" value="">
                                    @error('date')
                                        <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <label for="number">شماره کارت</label>
                                    <input class="form-control" name="number" value="{{ $card->number }}">
                                    @error('number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <label for="current_cash">موجودی</label>
                                    <input class="form-control" name="current_cash" value="{{ $card->current_cash }}">
                                    @error('current_cash')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mt-2">
                                    <label for="cash">توضیحات</label>
                                    <textarea name="description" class="form-control">
                                        {{ $card->description }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-2">
                                <button class="btn btn-success mt-3" type="submit"
                                    style="border-radius: 15px;">
                                    بروزرسانی
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
