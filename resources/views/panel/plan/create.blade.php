@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">ایجاد پرونده</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">
                    <a href="{{route('plan.index')}}">
                        پرونده ها
                    </a>
                </li>
                <li class="breadcrumb-item active">ایجاد پرونده</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">ایجاد پرونده
                    </h3>

                </div>
                @if ($errors->any())
                    <div class="alert alert-danger m-1">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">

                    <form action="{{route('plan.store')}}" method="post">
                        @csrf
                        <h4>
                            اطلاعات اولیه
                        </h4>
                        <div class="row input-group p-1">
                            <div class="col-md-4">
                                <label>
                                    نام و نام خانوادگی
                                </label>
                                <input type="name" name="title" class="form-control"
                                       value="{{Request()->old('name')??""}}">
                            </div>

                            <div class="col-md-4">
                                <label>
                                    متولد
                                </label>
                                <input type="number" min="1350" max="1400" name="birth" class="form-control "
                                       value="{{Request()->old('birth')??""}}">
                            </div>
                            <div class="col-md-4">
                                <label>
                                    تلفن همراه
                                </label>
                                <input type="number" name="mobile" class="form-control "
                                       value="{{Request()->old('mobile')??""}}">
                            </div>
                        </div>

                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    وضعیت تاهل
                                </label>
                                <select class="form-control" name="marriage">
                                    <option value="False">مجرد</option>
                                    <option value="True"> متاهل</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    تعداد عائله
                                </label>
                                <input type="number" min="0" name="family" class="form-control"
                                       value="{{Request()->old('family')??""}}">
                            </div>

                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    مدرک تحصیلی
                                </label>
                                <select class="form-control" name="degree">
                                    <option>بدون مدرک</option>
                                    <option>کاردانی</option>
                                    <option> کارشناسی</option>
                                    <option> کارشناسی ارشد</option>
                                    <option> دکتری</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    نوع حمایت
                                </label>
                                <select class="form-control" name="support_type">
                                    <option>1</option>
                                    <option>2</option>
                                    <option> 3</option>
                                </select>
                            </div>
                        </div>
                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                ادرس:
                            </label>
                            <div class="col-12 ">
                                <textarea name="address"
                                          class="form-control p-0 w-99">{{Request()->old('address')??""}}</textarea>

                            </div>
                        </div>
                        <hr>
                        <h4>
                            اظهار نظر مددکار
                        </h4>
                        <div class="row input-group p-1">
                            <div class="col-md-4">
                                <label>
                                    وضعیت اشتغال
                                </label>
                                <select class="form-control" name="employment">
                                    <option value="False">بیکار</option>
                                    <option value="True"> شاغل</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    عنوان شغل
                                </label>
                                <input type="text" name="job_title" class="form-control"
                                       value="{{Request()->old('job_title')??""}}">
                            </div>
                            <div class="col-md-4">
                                <label>
                                    میزان فعالت در هفته (ساعت):
                                </label>
                                <input type="number" name="job_activity" class="form-control"
                                       value="{{Request()->old('job_activity')??""}}">
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-4">
                                <label>
                                    وضعیت سکونت
                                </label>
                                <select class="form-control" name="have_place">
                                    <option value="False">مستاجر</option>
                                    <option value="True"> ملکی</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    امکان تامین فضا جهت شغل خانگی
                                </label>
                                <select class="form-control" name="home_employment">
                                    <option value="False">ندارد</option>
                                    <option value="True"> دارد</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    مساحت:
                                </label>
                                <input type="number" name="area" class="form-control"
                                       value="{{Request()->old('area')??""}}">
                            </div>
                        </div>
                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                سایر املاک و مستغلات:
                            </label>
                            <div class="col-12 ">
                                <textarea name="other_places"
                                          class="form-control p-0 w-99">{{Request()->old('other_places')??""}}</textarea>
                            </div>
                        </div>
                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                سایر مشکلات:
                            </label>
                            <div class="col-12 ">
                                <textarea name="other_problems"
                                          class="form-control p-0 w-99">{{Request()->old('other_problems')??""}}</textarea>

                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-3 pt-1">
                                <label>
                                    استعلام نوع بیمه
                                </label>
                                <select class="form-control" name="force_insurance">
                                    <option value="False">اختیاری</option>
                                    <option value="True">اجباری</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>
                                    کد بیمه:
                                </label>
                                <input type="text" name="insurance_code" class="form-control"
                                       value="{{Request()->old('insurance_code')??""}}">
                            </div>
                            <div class="col-md-3">
                                <label>
                                    اعتبار:
                                </label>
                                <input type="number" name="insurance_expire" class="form-control"
                                       value="{{Request()->old('insurance_expire')??""}}">
                            </div>
                            <div class="col-md-3">
                                <label>
                                    نسبت:
                                </label>
                                <input type="text" name="insurance_relation" class="form-control"
                                       value="{{Request()->old('insurance_relation')??""}}">
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-4">
                                <label>
                                    وضعیت پوشش:
                                </label>
                                <input type="text" name="covering_status" class="form-control"
                                       value="{{Request()->old('covering_status')??""}}">
                            </div>
                            <div class="col-md-4">
                                <label>
                                    کارفرما:
                                </label>
                                <input type="text" name="employer" class="form-control"
                                       value="{{Request()->old('employer')??""}}">
                            </div>
                            <div class="col-md-4">
                                <label>
                                    کد رهگیری:
                                </label>
                                <input type="number" disabled name="tracking_number" class="form-control"
                                       value="{{Request()->old('tracking_number')??""}}">
                            </div>
                        </div>
                        <br>


                                <div class=" d-flex">
                                    <p class="d-block pt-2">
                                        وی استحقاق  خدمات اشتغال را
                                    </p>
                                    <select class="form-control w-25 " name="status">
                                        <option value="0">دارد</option>
                                        <option value="-1">ندارد</option>
                                    </select>

                                </div>

                        {{--                        <div class="row input-group p-1">--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <label>--}}
                        {{--                                    تاریخ ثبت--}}
                        {{--                                </label>--}}

                        {{--                                <input type="text" name="date" class="form-control normal-example" placeholder="*******"--}}
                        {{--                                       value="{{Request()->old('date')}}">--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <label>--}}
                        {{--                                    کد پرونده--}}
                        {{--                                </label>--}}
                        {{--                                <input type="number" name="code" class="form-control" placeholder="123444"--}}
                        {{--                                       value="{{Request()->old('code')}}">--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <label>--}}
                        {{--                                    فضا--}}
                        {{--                                </label>--}}
                        {{--                                <input type="text" name="space" class="form-control" placeholder="31123"--}}
                        {{--                                       value="{{Request()->old('space')}}">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <hr>--}}
                        {{--                        <span>--}}
                        {{--                            سرمایه پرونده--}}
                        {{--                        </span>--}}
                        {{--                        <div class=" mt-2">--}}

                        {{--                            <label class="p-1 d-block">--}}
                        {{--                                آورده مجری (نام اقلام با امکانات):--}}
                        {{--                            </label>--}}
                        {{--                            <div class="col-12 ">--}}
                        {{--                                <textarea name="executer_summery"--}}
                        {{--                                          class="form-control p-0">{{Request()->old('executer_summery')??""}}</textarea>--}}

                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="row input-group p-1">--}}

                        {{--                            <div class="col-md-6">--}}
                        {{--                                <label>--}}
                        {{--                                    ارزش آورده:--}}
                        {{--                                </label>--}}
                        {{--                                <input type="number" name="executer_fund" class="form-control" placeholder="100000000"--}}
                        {{--                                       value="{{Request()->old('executer_fund')}}">--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-6">--}}
                        {{--                                <label>--}}
                        {{--                                    مبلغ تسهیلات:--}}
                        {{--                                </label>--}}
                        {{--                                <input type="number" name="fund" class="form-control" placeholder="100000000"--}}
                        {{--                                       value="{{Request()->old('fund')}}">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class=" mt-2">--}}

                        {{--                            <label class="p-1 d-block">--}}
                        {{--                                خلاصه اقلام خریداری شده با تسهیلات:--}}
                        {{--                            </label>--}}
                        {{--                            <div class="col-12 ">--}}
                        {{--                                <textarea name="summery"--}}
                        {{--                                          class="form-control p-0">{{Request()->old('summery')??""}}</textarea>--}}

                        {{--                            </div>--}}
                        {{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <span>--}}
{{--                            سوابق مهارتی--}}
{{--                        </span>--}}
{{--                        <div id="place1"></div>--}}
{{--                        <hr>--}}
{{--                        <span>--}}
{{--                           شناسه رهگیری مستندات پرونده--}}
{{--                        </span>--}}
{{--                        <div id="place2"></div>--}}

{{--                        <div class="p-2 col-12">--}}
{{--                            <button class="btn btn-sm btn-info" type="button" onclick="f1()">افزودن مهارت</button>--}}
{{--                            <button class="btn btn-sm btn-info" type="button" onclick="f2()">افزودن شناسه رهگیری--}}
{{--                                مستندات--}}
{{--                            </button>--}}

{{--                        </div>--}}
                        <div class="col-12">
                            <input type="submit" class="m-3 btn btn-success btn-block" value="ثبت">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none">
        <div class="clone">
            <div class="row input-group p-1">
                <div class="col-md-6">

                    <label>
                        نوع سابقه مهارتی
                    </label>
                    <select class="form-control" name="skillType[]">
                        <option>سوابق تجربی/شاگردی</option>
                        <option>گواهینامه مهارتی بدون معرفی امداد</option>
                        <option>گواهینامه مهارتی با معرفی امداد</option>
                    </select>


                </div>
                <div class="col-md-6">
                    <label>
                        توضیحات
                    </label>
                    <input type="text" name="skillValue[]" class="form-control" placeholder="توضیحات">
                </div>
            </div>
        </div>
        <div class="clone2">
            <div class="row input-group p-1">
                <div class="col-md-4">

                    <label>
                        بخش مربوطه:
                    </label>
                    <select class="form-control" name="metaType[]">
                        <option>کد رهگیری درخواست</option>
                        <option>شناسه فنی حرفه ای</option>
                        <option>شماره گواهینامه ماشین</option>
                        <option>گواهی دردست اقدام(شماره و تاریخ)</option>
                        <option>شناسه مجوز شغلی</option>
                        <option>کد سامانه رصد</option>
                    </select>


                </div>
                <div class="col-md-5">
                    <label>
                        توضیحات
                    </label>
                    <input type="text" name="metaValue[]" class="form-control" placeholder="توضیحات">
                </div>
                <div class="col-md-3">
                    <label>
                        وضعیت استعلام:
                    </label>
                    <select class="form-control" name="metaActive[]">
                        <option value="true">تایید شده</option>
                        <option value="false"> عدم تایید</option>
                    </select>


                </div>
            </div>
        </div>
    </div>

    <!-- /.col -->

@endsection
@section('script')
    <script src="{{asset('AdminAsset/dist/js/persian-date.min.js')}}"></script>
    <script src="{{asset('AdminAsset/dist/js/persian-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('.normal-example').persianDatepicker({
                format: 'YYYY/MM/DD',
            });
            $("#executor").change(() => {
                var selectedItem = $('#executor').children("option:selected").val();
                if (selectedItem.length > 0) {
                    axios.post('/panel/skill/list', {id: selectedItem})
                        .then(res => {
                            let data = res.data;
                            data = data.map(item => {
                                return `
                                 <div class="row input-group p-1">
                <div class="col-md-6">

                    <label>
                        نوع سابقه مهارتی
                    </label>
                    <select class="form-control" name="skillType[]">
                        <option
${item.type == "سوابق تجربی/شاگردی" ? "selected" : null}
>سوابق تجربی/شاگردی</option>
                        <option
${item.type == "گواهینامه مهارتی بدون معرفی امداد" ? "selected" : null}
>گواهینامه مهارتی بدون معرفی امداد</option>
                        <option
${item.type == "گواهینامه مهارتی با معرفی امداد" ? "selected" : null}
>گواهینامه مهارتی با معرفی امداد</option>
                    </select>


                </div>
                <div class="col-md-6">
                    <label>
                        توضیحات
                    </label>
                    <input type="text" name="skillValue[]" class="form-control" value="${item.value}" placeholder="توضیحات">
                </div>
            </div>
                                `
                            });
                            $("#place1").after(data);
                        }).catch(err => {
                        console.log(err)
                    });
                }
            });


        });

        function f1() {

            var lsthmtl = $(".clone").html();
            $("#place1").after(lsthmtl);
        }

        function f2() {

            var lsthmtl = $(".clone2").html();
            $("#place2").after(lsthmtl);
        }

    </script>

    <script>
        $(".select2").select2({
            placeholder: "انتخاب کنید"
        });
    </script>
@endsection
