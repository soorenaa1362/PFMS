@extends('users.layouts.app')

@section('title')
    لیست کارت ها
@endsection

@section('content')
    <div class="container mt-3 p-2">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card shadow p-2 mb-5 bg-body">

                    <div class="card-header text-center text-light bg-primary p-3 m-2"
                        style="border-radius: 15px;">
                        <div class="d-flex justify-content-between">

                            @include('users.sections.profile_icon')

                            <h6 class="mt-2">لیست کارت های بانکی</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center" style="margin-bottom: 0 !important">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        @if (blank($cards))
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center">
                                    هنوز هیچ کارتی در سیستم ثبت نکرده اید.
                                </h6>
                                <a href="{{ route('users.cards.create') }}" class="btn btn-success"
                                    style="border-radius: 15px;">
                                    ثبت اطلاعات کارت بانکی
                                </a>
                            </div>
                        @else
                            <h6 class="text-center text-light p-3 bg-secondary"
                                style="border-radius: 10px;">
                                @if ($totalCash > 0)
                                    موجودی کل : {{ number_format( $totalCash) }} تومان
                                @else
                                    موجودی ندارید!
                                @endif
                            </h6>
                            <div class="d-grid gap-2 m-2">
                                <a class="btn btn-success" href="{{ route('users.cards.create') }}"
                                    style="border-radius: 15px;">
                                    <i class="fa fa-plus"></i>
                                    کارت جدید
                                </a>
                            </div>
                            <hr>
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>نام بانک</th>
                                        {{-- <th>نام مستعار</th> --}}
                                        <th>موجودی</th>
                                        <th>تاریخ ثبت کارت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cards as $card)
                                        <tr>
                                            <th>
                                                <a href="{{ route('users.cards.show', $card->id) }}">
                                                    {{ $card->name }}
                                                </a>
                                            </th>
                                            {{-- <th>
                                                @if ($card->alias == null)
                                                    ---------
                                                @else
                                                    <a href="{{ route('users.cards.show', $card->id) }}">
                                                        {{ $card->alias }}
                                                    </a>
                                                @endif
                                            </th> --}}
                                            <th>
                                                <a href="{{ route('users.cards.show', $card->id) }}">
                                                    @if( $card->current_cash > 0 )
                                                        {{ number_format($card->current_cash) }} تومان
                                                    @else
                                                        0
                                                    @endif
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ route('users.cards.show', $card->id) }}">
                                                    {{ $card->getDateJalali() }}
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $cards->links() }}

                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
