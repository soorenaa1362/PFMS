@extends('users.layouts.app')

@section('title')
    راهنمای کار با سیستم
@endsection

@section('content')

    {{-- <div class="container mt-3 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">

                <div class="card-header text-center text-light bg-primary p-3 m-2" style="border-radius: 10px;">
                    <div class="d-flex justify-content-evenly">
                        <h6 class="mt-2">راهنمای کار با سیستم مدیریت مالی فراز</h6>
                    </div>
                </div>

                <div class="card-body d-grid gap-2">
                    <p class="text-center">
                        برای شروع به کار ابتدا باید اطلاعات کارت های بانکی
                        خود را در بخش کارت ها وارد کرده و سپس به ثبت
                        تراکنش های مالی خود بپردازید.
                    </p>
                    <hr>
                    <div>
                        <i class="fa fa-credit-card text-secondary fa-2x"></i>
                        <p>
                            <span class="h5 text-secondary">کارت ها :</span>
                            در این بخش لیست کارت های بانکی و فرم ثبت اطلاعات کارت بانکی
                            برای شما نمایش داده می شود.
                            برای ثبت اطلاعات کارت بانکی باید روی گزینه ی
                            <span class="text-success">+ کارت جدید</span>
                            کلیک نمایید .
                            <br>
                            <span class="p-4">موارد دریافتی =></span>
                            <br>
                            <span class="p-5">نام : نام بانک</span>
                            <br>
                            <span class="p-5">
                                نام مستعار : نامی اختیاری که میتوانید
                                برای کارت خود در نظر بگیرید تا مانع از اشتباه گرفتن
                                آن با سایر کارت ها شود.
                            </span>
                            <br>
                        </p>
                    </div>
                </div>

            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> <!-- container --> --}}

    <div class="container mt-3 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">

                <div class="card-header text-center text-light bg-primary p-3 m-2" style="border-radius: 10px;">
                    <div class="d-flex justify-content-evenly">
                        <h6 class="mt-2">راهنمای کار با سیستم مدیریت مالی فراز</h6>
                    </div>
                </div>

                <div class="card-body d-grid gap-2">
                    <p class="text-center">
                        برای شروع به کار ابتدا باید اطلاعات کارت های بانکی
                        خود را در بخش کارت ها وارد کرده و سپس به ثبت
                        تراکنش های مالی خود بپردازید.
                    </p>

                    <div class="accordion" id="accordionCardsOpen">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="cardsOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#cardsOpen-collapseOne" aria-expanded="true"
                                    aria-controls="cardsOpen-collapseOne">
                                    <i class="fa fa-credit-card text-secondary fa-2x mx-2"></i>
                                    <strong class="mx-2 text-secondary">کارت ها</strong>
                                </button>
                            </h2>
                            <div id="cardsOpen-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="cardsOpen-headingOne">
                                <div class="accordion-body">
                                    <p>
                                        در این بخش , لیست کارت های بانکی و فرم ثبت اطلاعات کارت بانکی
                                        برای شما نمایش داده می شود.
                                        برای ثبت اطلاعات کارت بانکی باید روی گزینه ی
                                        <a href="{{ route('users.cards.create') }}">
                                            <span class="text-success">
                                                + کارت جدید
                                            </span>
                                        </a>
                                        کلیک نمایید .
                                        <br>
                                        <hr>
                                        <strong class="text-success">
                                            موارد دریافتی =>
                                        </strong>
                                        <br>

                                        <strong>* نام :</strong>
                                        نام بانک
                                        <br>

                                        <strong>* نام مستعار :</strong>
                                        نامی اختیاری که میتوانید
                                        برای کارت خود در نظر بگیرید تا مانع از اشتباه گرفتن
                                        آن با سایر کارت ها شود.
                                        <br>

                                        <strong>* شماره کارت :</strong>
                                        شماره ی کارت مورد نظر
                                        <br>

                                        <strong>* موجودی :</strong>
                                        موجودی فعلی کارت
                                        <br>

                                        <strong>* توضیحات :</strong>
                                        شاید لازم بدانید برای کارت بانکی خود توضیحاتی
                                        در نظر بگیرید .
                                        <br>

                                        <hr>
                                        <span class="text-danger">
                                            دقت داشته باشید که در هنگام ثبت اطلاعات کارت بانکی
                                            فیلدهای نام , شماره کارت و موجودی الزامی می باشند.
                                            یعنی در صورت وارد نکردن آنها , کارت در سیستم ثبت
                                            نخواهد شد .
                                        </span>
                                    </p>
                                </div> <!-- accordion-body -->
                            </div> <!-- accordion-collapse -->
                        </div> <!-- accordion-item -->
                    </div> <!-- accordion -->

                    <div class="accordion" id="accordionIncomesOpen">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="incomesOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#incomesOpen-collapseOne" aria-expanded="true"
                                    aria-controls="incomesOpen-collapseOne">
                                    <i class="fas fa-donate text-success fa-2x mx-2"></i>
                                    <strong class="mx-2 text-success">درآمدها</strong>
                                </button>
                            </h2>
                            <div id="incomesOpen-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="incomesOpen-headingOne">
                                <div class="accordion-body">
                                    <p>
                                        در این بخش , لیست و فرم ثبت درآمدها
                                        برای شما نمایش داده می شود.
                                        برای ثبت اطلاعات درآمدی خود باید روی گزینه ی
                                        <a href="{{ route('users.incomes.create') }}">
                                            <span class="text-success">
                                                + ثبت درآمد جدید
                                            </span>
                                        </a>
                                        کلیک نمایید .
                                        <br>
                                        <hr>
                                        <strong class="text-success">
                                            موارد دریافتی =>
                                        </strong>
                                        <br>

                                        <strong>* عنوان :</strong>
                                        عنوان مشخص کننده ی درآمد , مانند حقوق یا وصول طلب
                                        <br>

                                        <strong>* مبلغ :</strong>
                                        مبلغ درآمد
                                        <br>

                                        <strong>* کارت :</strong>
                                        کارتی که مبلغ درآمد به آن واریز شده است .
                                        <br>

                                        <strong>* دسته بندی :</strong>
                                        دسته بندی که در نظر دارید درآمد را به آن نسبت دهید ,
                                        مثلا درآمد ثابت -> حقوق شرکت فلان یا درآمد غیر ثابت -> وصول طلب از فلانی
                                        <br>

                                        <strong>* تاریخ :</strong>
                                        تاریخی که درآمد به حسابتان واریز شده است .
                                        <br>

                                        <strong>* توضیحات :</strong>
                                        شاید لازم باشد برای این درآمد توضیحاتی نیز در نظر بگیرید .
                                        <br>

                                        <hr>
                                        <span class="text-danger">
                                            دقت داشته باشید که در هنگام ثبت اطلاعات درآمدی
                                            تمامی فیلدها بجز فیلد توضیحات , باید وارد شود .
                                        </span>
                                    </p>
                                </div> <!-- accordion-body -->
                            </div> <!-- accordion-collapse -->
                        </div> <!-- accordion-item -->
                    </div> <!-- accordion -->

                    <div class="accordion" id="accordionCostsOpen">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="costsOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#costsOpen-collapseOne" aria-expanded="true"
                                    aria-controls="costsOpen-collapseOne">
                                    <i class="fas fa-hand-holding-usd text-danger fa-2x mx-2"></i>
                                    <strong class="mx-2 text-danger">خرجکردها</strong>
                                </button>
                            </h2>
                            <div id="costsOpen-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="costsOpen-headingOne">
                                <div class="accordion-body">
                                    <p>
                                        در این بخش , لیست و فرم ثبت خرجکرد
                                        برای شما نمایش داده می شود.
                                        برای ثبت اطلاعات درآمدی خود باید روی گزینه ی
                                        <a href="{{ route('users.costs.create') }}">
                                            <span class="text-success">
                                                + ثبت خرجکرد جدید
                                            </span>
                                        </a>
                                        کلیک نمایید .
                                        <br>
                                        <hr>
                                        <strong class="text-success">
                                            موارد دریافتی =>
                                        </strong>
                                        <br>

                                        <strong>* عنوان :</strong>
                                        عنوان مشخص کننده ی خرجکرد , مانند واریز حقوق کارمندان یا پرداخت بدهی
                                        <br>

                                        <strong>* مبلغ :</strong>
                                        مبلغ خرجکرد
                                        <br>

                                        <strong>* کارت :</strong>
                                        کارتی که مبلغ خرجکرد از آن کسر شده است .
                                        <br>

                                        <strong>* دسته بندی :</strong>
                                        دسته بندی که در نظر دارید خرجکرد را به آن نسبت دهید ,
                                        مثلا خرجکرد ثابت -> اجاره ی منزل یا خرجکرد غیر ثابت -> هزینه ی تعمیر ماشین
                                        <br>

                                        <strong>* تاریخ :</strong>
                                        تاریخی که خرجکرد از حسابتان کم شده است .
                                        <br>

                                        <strong>* توضیحات :</strong>
                                        شاید لازم باشد برای این خرجکرد توضیحاتی نیز در نظر بگیرید .
                                        <br>

                                        <hr>
                                        <span class="text-danger">
                                            دقت داشته باشید که در هنگام ثبت اطلاعات خرجکرد
                                            تمامی فیلدها بجز فیلد توضیحات , باید وارد شود .
                                        </span>
                                    </p>
                                </div> <!-- accordion-body -->
                            </div> <!-- accordion-collapse -->
                        </div> <!-- accordion-item -->
                    </div> <!-- accordion -->

                    <div class="accordion" id="accordionCategoriesOpen">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="categoriesOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#categoriesOpen-collapseOne" aria-expanded="true"
                                    aria-controls="categoriesOpen-collapseOne">
                                    <i class="fas fa-sitemap text-info fa-2x mx-2"></i>
                                    <strong class="mx-2 text-info">دسته بندی ها</strong>
                                </button>
                            </h2>
                            <div id="categoriesOpen-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="categoriesOpen-headingOne">
                                <div class="accordion-body">
                                    <p>
                                        در این بخش دو گزینه وجود دارد که یکی حاوی لیست و فرم دسته های
                                        درآمدی و دیگری شامل لیست و فرم دسته های خرجکرد است که با
                                        کلیک بر روی هر کدام وارد بخش مربوط به آن می شوید .
                                        برای ایجاد دسته بندی جدید باید روی گزینه ی
                                        <a href="{{ route('users.categories.select') }}">
                                            <span class="text-success">
                                                + دسته بندی جدید
                                            </span>
                                        </a>
                                        کلیک نمایید .
                                        <hr>
                                        در هنگام ثبت دسته بندی , میتوان دسته ها را به شکل دسته و
                                        زیر دسته ایجاد کرد . مثلا درآمد ثابت با زیر دسته ی حقوق
                                        یا خرجکرد ثابت با زیر دسته ی پرداخت قسط وام بانکی
                                        <br>
                                        <hr>
                                        <strong class="text-success">
                                            موارد دریافتی در فرم =>
                                        </strong>
                                        <br>

                                        <strong>* عنوان :</strong>
                                        عنوان مشخص کننده ی دسته بندی , مانند درآمد ثابت -
                                        خرجکرد غیر ثابت - اجاره منزل - دریافت طلب
                                        <br>

                                        <strong>* دسته بندی والد :</strong>
                                        دسته ای که دسته ی در حال ثبتمان زیر دسته ی آن
                                        به حساب می آید . مانند دسته ی اجاره ی منزل که دسته بندی
                                        والد آن میشود خرجکرد ثابت
                                        <br>

                                        <strong>* توضیحات :</strong>
                                        شاید لازم باشد برای این دسته بندی توضیحاتی نیز در نظر بگیرید .
                                        <br>

                                        <hr>
                                        <span class="text-danger">
                                            دقت داشته باشید که در هنگام ثبت اطلاعات دسته بندی
                                            تنها فیلد عنوان اجباری بوده و وارد کردن آن به
                                            تنهایی کافیست , اما توصیه میشود که در صورت وجود
                                            دسته بندی والد , دسته ی والد هم مشخص گردد .
                                        </span>
                                    </p>
                                </div> <!-- accordion-body -->
                            </div> <!-- accordion-collapse -->
                        </div> <!-- accordion-item -->
                    </div> <!-- accordion -->

                    <div class="accordion" id="accordionReportsOpen">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="reportsOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#reportsOpen-collapseOne" aria-expanded="true"
                                    aria-controls="reportsOpen-collapseOne">
                                    <i class="fa fa-newspaper-o text-warning fa-2x mx-2"></i>
                                    <strong class="mx-2 text-warning">گزارشات</strong>
                                </button>
                            </h2>
                            <div id="reportsOpen-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="reportsOpen-headingOne">
                                <div class="accordion-body">
                                    <p>
                                        در این بخش میتوانید گزارش تمامی درآمدها , خرجکردها
                                        و تراکنشهای حذف شده ی خود را مشاهده کنید . فقط کافیست روی
                                        گزینه ی مورد نظر کلیک کرده تا به اطلاعات مد نظر دست
                                        پیدا کنید .
                                        <hr>
                                        <strong class="text-success">
                                            گزارش درآمدها =>
                                        </strong>
                                        <br>

                                        <strong>* گزارش روزانه :</strong>
                                        لیست تمامی درآمدهای امروز را به نمایش می گذارد .
                                        <br>

                                        <strong>* گزارش هفتگی :</strong>
                                        لیست تمامی درآمدهای هفت روز گذشته را به نمایش می گذارد .
                                        <br>

                                        <strong>* گزارش ماهانه :</strong>
                                        لیست تمامی درآمدهای سی روز گذشته را به نمایش می گذارد .
                                        <br>

                                        <hr>
                                        <strong class="text-success">
                                            گزارش خرجکردها =>
                                        </strong>
                                        <br>

                                        <strong>* گزارش روزانه :</strong>
                                        لیست تمامی خرجکردهای امروز را به نمایش می گذارد .
                                        <br>

                                        <strong>* گزارش هفتگی :</strong>
                                        لیست تمامی خرجکردهای هفت روز گذشته را به نمایش می گذارد .
                                        <br>

                                        <strong>* گزارش ماهانه :</strong>
                                        لیست تمامی خرجکردهای سی روز گذشته را به نمایش می گذارد .
                                        <br>

                                        <hr>
                                        <strong class="text-success">
                                            تراکنش های حذف شده =>
                                        </strong>
                                        <p>
                                            به جهت حفظ اطلاعات , در این سیستم قابلیتی در نظر گرفته شده
                                            که بر اساس آن کاربر نمی تواند به شکل مستقیم
                                            اطلاعات را از دیتابیس حذف کند . به عبارت دیگر
                                            هر مورد که خواسته یا ناخواسته توسط کاربر حذف شده
                                            باشد , در لیست تراکنش های حذف شده قرار میگیرد
                                            تا کاربر بتواند آنرا بازیابی کند .
                                            البته که اگر کاربر قصد داشته باشد موردی را به شکل
                                            کامل از دیتابیس حذف کند باید از این بخش اقدام کند .
                                        </p>

                                        <strong>* درآمدهای حذف شده :</strong>
                                        لیست تمامی درآمدهای حذف شده را به نمایش می گذارد .
                                        <br>

                                        <strong>* خرجکردهای حذف شده :</strong>
                                        لیست تمامی خرجکردهای حذف شده را به نمایش می گذارد .
                                        <br>
                                    </p>
                                </div> <!-- accordion-body -->
                            </div> <!-- accordion-collapse -->
                        </div> <!-- accordion-item -->
                    </div> <!-- accordion -->

                </div> <!-- card-body -->

            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> <!-- container -->







@endsection













