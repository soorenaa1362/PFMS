@extends('users.layouts.app')

@section('title')
    ویرایش دسته بندی درآمد
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

                            <h6 class="mt-2">ویرایش اطلاعات دسته بندی درآمد</h6>

                            @include('users.sections.logout_icon')

                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.categories.incomes.update', $category->id) }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="row">
                                <div class="form-group col-md-6 mt-2">
                                    <label for="title">عنوان</label>
                                    <input class="form-control" name="title" value="{{ $category->title }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mt-2">
                                    <label for="parent_id">دسته بندی والد</label>
                                    <select class="form-select" name="parent_id" id="parent_id">
                                        <option value="">---------</option>
                                        @foreach ($parents as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ $parent->id == $category->parent_id ? 'selected' : ''}}
                                            >
                                                {{ $parent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12 mt-2">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description" class="form-control">
                                        {{ $category->description }}
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
                </div> <!-- card -->
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->

    {{-- @include('users.sections.modal') --}}

@endsection
