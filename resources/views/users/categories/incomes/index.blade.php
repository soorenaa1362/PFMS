@extends('users.layouts.app')

@section('title')
    لیست دسته بندی های درآمد
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

                            <h6 class="mt-2">لیست دسته بندی های درآمد</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        @if (blank($categories))
                            <div class="d-grid gap-2 mt-2">
                                <h6 class="text-center">
                                    هنوز هیچ دسته بندی در سیستم ثبت نکرده اید.
                                </h6>
                                <a href="{{ route('users.categories.incomes.create') }}"
                                    class="btn btn-success"
                                    style="border-radius: 15px;">
                                    ثبت اطلاعات دسته بندی درآمد
                                </a>
                            </div>
                        @else
                            <div class="d-grid gap-2 m-2">
                                <a class="btn btn-success" href="{{ route('users.categories.incomes.create') }}"
                                    style="border-radius: 15px;">
                                    <i class="fa fa-plus"></i>
                                    دسته بندی جدید
                                </a>
                            </div>
                            <hr>
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>دسته ی والد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <th>
                                                <a href="{{ route('users.categories.incomes.edit', $category->id) }}">
                                                    {{ $category->title }}
                                                </a>
                                            </th>
                                            <th>
                                                @if ($category->parent_id == null)
                                                    ----------
                                                @else
                                                    <a href="{{ route('users.categories.incomes.edit', $category->id) }}">
                                                        {{ $category->parent->title }}
                                                    </a>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- <div class="d-flex justify-content-end">
                                {!! $cards->links() !!}
                            </div> --}}

                        @endif

                        @include('users.sections.footer')

                    </div> <!-- card body -->

                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
