<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">پروفایل کاربر</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.profile.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-12 mt-2">
                            <label for="name">نام</label>
                            <input class="form-control" name="name" type="text" value="{{ $user->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label for="family">نام خانوادگی</label>
                            <input class="form-control" name="family" type="text" value="{{ $user->family }}">
                            @error('family')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label for="mobile">موبایل</label>
                            <input class="form-control" name="mobile" type="number" value="{{ $user->mobile }}">
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div> <!-- row -->

                    <div class="d-grid gap-2 mt-2">
                        <button class="btn btn-success mt-3" type="submit"
                            style="border-radius: 15px;">
                            ذخیره اطلاعات
                        </button>
                    </div>

                </form>
            </div> <!-- modal body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    بستن
                </button>
            </div>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div> <!-- modal -->
