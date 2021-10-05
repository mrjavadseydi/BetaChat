@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">اطلاعات طرح</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">طرح ها</li>
                <li class="breadcrumb-item active">اطلاعات طرح</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">اطلاعات طرح
                    </h3>

                </div>

                <div class="card-body">
                    <span>
                        اطلاعات مددجو
                    </span>
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>نام و نام خانوادگی</th>
                            <th>کد ملی</th>
                            <th>نام پدر</th>
                            <th>متولد</th>
                            <th>مدرک</th>
                            <th>نوع حمایت</th>
                            <th>محل سکونت</th>
                            <th>مسافت</th>
                            <th>تلفن ثابت</th>
                            <th>تلفن همراه</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$plan->executer->name}}</td>
                            <td>{{$plan->executer->national_id}}</td>
                            <td>{{$plan->executer->fathername}}</td>
                            <td>{{$plan->executer->birth}}</td>
                            <td>{{$plan->executer->degree}}</td>
                            <td>{{$plan->executer->support_type}}</td>
                            <td>{{$plan->executer->address}}</td>
                            <td>{{$plan->executer->distance}}</td>
                            <td>{{$plan->executer->phone}}</td>
                            <td>{{$plan->executer->mobile}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <span>
                             شناسه رهگیری مستندات طرح (جهت کنترل از سامانه های بر خط)
                    </span>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>بخش مربوطه</th>
                            <th>اطلاعات</th>
                            <th>وضعیت</th>
                            <th>تغییر وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plan->meta()->get() as $meta)
                            <tr>
                                <td>{{$meta->type}}</td>
                                <td>{{$meta->value}}</td>
                                <td>
                                    @if($meta->active)
                                        <span class="badge  badge-success">
                                        تایید شده
                                    </span>
                                    @else
                                        <span class="badge  badge-danger">
                                     عدم تایید
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('plan.meta.active',$meta->id)}}" class="btn btn-info btn-sm">
                                        تغییر وضعیت
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <hr>
                    <span>
                            سوابق مهارتی
                    </span>
                    <table class="table table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th>نوع سابقه</th>
                            <th>اطلاعات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($plan->executer->skill()->get()  as $skill)
                            <tr>
                                <td>{{$skill->type}}</td>
                                <td>{{$skill->value}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <span>
                            مشخصات طرح اشتغال
                    </span>
                    <table class="table table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th>گروه فعالیت</th>
                            <th>عنوان طرح</th>
                            <th>نوع تسهیلات</th>
                            <th>منبع اعتبار</th>
                            <th>بانک عامل</th>
                            <th>اشتغال</th>
                            <th>تاریخ ثبت</th>
                            <th>کد طرح</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>{{$plan->group}}</td>
                            <td>{{$plan->title}}</td>
                            <td>{{$plan->type}}</td>
                            <td>{{$plan->source}}</td>
                            <td>{{$plan->bank}}</td>
                            <td>{{$plan->employment}}</td>
                            <td>{{$plan->date}}</td>
                            <td>{{$plan->code}}</td>
                        </tr>

                        </tbody>
                    </table>
{{--                    <hr>--}}
{{--                    <span>--}}
{{--                            سرمایه طرح--}}
{{--                    </span>--}}
{{--                    <table class="table table-striped table-bordered ">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>آورده مجری</th>--}}
{{--                            <th>ارزش آورده</th>--}}
{{--                            <th>خلاصه اقلام خریداری شده با تسهیلات</th>--}}
{{--                            <th>مبلغ تسهیلات</th>--}}

{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}

{{--                        <tr>--}}
{{--                            <td>{{$plan->fund->executer_summery}}</td>--}}
{{--                            <td>{{$plan->fund->executer_fund}}</td>--}}
{{--                            <td>{{$plan->fund->summery}}</td>--}}
{{--                            <td>{{$plan->fund->fund}}</td>--}}
{{--                        </tr>--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <!-- /.col -->

@endsection
@section('script')
@endsection
