@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">کاربران</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item active">کاربران</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">ایجاد کاربر
                    </h3>

                </div>
                <div class="alert alert-info p-2 m-2">
                    در صورت خالی گذاشتن کلمه عبور ،‌ کد ملی به عنوان کلمه عبور انتخاب میشود

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

                    <form action="{{route('users.store')}}" method="post">
                        @csrf
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    <span class="red-star">
                                        *
                                    </span>
                                    کد ملی
                                </label>

                                <input type="number" name="national_id" class="form-control"
                                       value="{{Request()->old('national_id')??""}}">
                            </div>
                            <div class="col-md-6">
                                <label>

                                    <span class="red-star">
                                        *
                                    </span>
                                    نام
                                </label>

                                <input type="text" name="name" class="form-control"
                                       value="{{Request()->old('name')??""}}">
                            </div>

                        </div>
                        <div class="row input-group p-1">


                            <div class="col-md-6">
                                <label>
                                    نام پدر
                                </label>
                                <input type="text" name="fathername" class="form-control"
                                       value="{{Request()->old('fathername')??""}}">
                            </div>

                            <div class="col-md-6">
                                <label>

                                    تاریخ تولد
                                </label>
                                <input type="text" name="birth" class="form-control normal-example"
                                       value="{{Request()->old('birth')??""}}">
                            </div>
                        </div>

                        <div class="row input-group p-1">
                            <div class="col-md-6">

                                <label>
                                    مدرک تحصیلی
                                </label>
                                <select class="form-control" name="degree">
                                    <option>دیپلم</option>
                                    <option>کاردانی</option>
                                    <option>کارشناسی</option>
                                    <option>کارشناسی ارشد</option>
                                    <option>دکتری</option>
                                </select>


                            </div>
                            <div class="col-md-6">
                                <label>

                                    <span class="red-star">
                                        *
                                    </span>
                                    تلفن همراه
                                </label>
                                <input type="text" name="mobile" class="form-control"
                                       value="{{Request()->old('mobile')??""}}">
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    تلفن ثابت
                                </label>

                                <input type="text" name="phone" class="form-control"
                                       value="{{Request()->old('phone')??""}}">
                            </div>
                            <div class="col-md-6">
                                <label>
                                    فاصله از مرکز(km)
                                </label>
                                <input type="number" name="distance" class="form-control"
                                       value="{{Request()->old('distance')??""}}">
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    کلمه عبور
                                </label>

                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>
                                    تکرار کلمه عبور
                                </label>
                                <input type="password" name="re_password" class="form-control" >
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>

                                    <span class="red-star">
                                        *
                                    </span>
                                    نوع کاربر
                                </label>
                                <select id="user_type" onchange="f1()" class="form-control" name="user_type">
                                    <option selected>کارمند امداد</option>
                                    <option>کارمند شرکت</option>
                                    <option>مددجو</option>
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label>
                                    نوع حمایت
                                </label>

                                <select id="support_type" disabled="disabled" class="form-control" name="support_type">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-12">
                                <label>

                                    <span class="red-star">
                                        *
                                    </span>
                                    اداره

                                </label>

                                <select   class="form-control" name="office_id">
                                    <option value="0">بدون اداره</option>
                                    @foreach($offices as $office)
                                        <option value="{{$office->id}}">
                                            {{$office->name ." - " . $office->city->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                آدرس :
                            </label>
                                <div class="col-12 ">

                                        <textarea name="address" class="form-control w-99">{{Request()->old('address')??""}}</textarea>


                                </div>





                        </div>
                        <input type="submit" class="m-3 btn btn-info" name="create_new" value="ثبت و ایجاد کاربر جدید">
                        <input type="submit" class="m-3 btn btn-primary" name="create_plan" value="ثبت و ایجاد طرح">
                        <input type="submit" class="m-3 btn btn-success" value="ثبت و بازگشت">
                    </form>
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

        });
        function f1(){
            var data = $('#user_type').val();

            if(data=="مددجو"){
                document.getElementById('support_type').removeAttribute('disabled');
            }else{
                document.getElementById('support_type').setAttribute('disabled','disabled');
            }
        }
    </script>
@endsection
