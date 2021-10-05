@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"> اداره {{$office->name}}
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">
                    <a href="{{route('office.index')}}">
                    ادارات
                    </a>
                </li>
                <li class="breadcrumb-item active">   اداره {{$office->name}}
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">
                    اداره {{$office->name}}
                    </h3>

                </div>

                <div class="card-body">

                    <div class="row input-group p-1">
                        <div class="col-md-6">
                            <span>
                                نام اداره:
                                {{$office->name}}

                            </span>
                        </div>
                        <div class="col-md-6">
                            <span>
                                کد:

                            </span>
                            <h3 class="badge badge-info">
                                {{$office->code}}
                            </h3>


                        </div>

                    </div>
                    <div class="row input-group p-1">


                        <div class="col-md-6">
                            <span>
                                تلفن:
                                {{$office->phone}}
                            </span>

                        </div>

                        <div class="col-md-6">
                            <span>
                                نام ریاست:
                                {{$office->boss_name}}
                            </span>

                        </div>
                    </div>

                    <div class="row input-group p-1">
                        <div class="col-md-6">
                            <span>
                                تلفن دفتر مشاغل:
                                {{$office->phone_office}}
                            </span>

                        </div>
                        <div class="col-md-6">
                            <span>
                                مسئول دفتر مشاغل
                                {{$office->employment_name}}

                            </span>

                        </div>
                    </div>
                    <div class="row input-group p-1">
                        <div class="col-md-4">
                            <span>
                                استان:{{$office->province->name}}
                            </span>

                        </div>
                        <div class="col-md-4">
                            <span>
                                شهرستان :
                                {{$office->state->name}}
                            </span>

                        </div>
                        <div class="col-md-4">
                            <span>
                                شهر:
                                {{$office->city->name}}
                            </span>

                        </div>
                    </div>
                    <div class=" mt-2">

                        <span class="p-1 d-block">
                            آدرس اداره :
                            {{$office->address}}
                        </span>

                    </div>
                    <div class=" mt-2">

                        <span class="p-1 d-block">
                            آدرس دفتر مشاغل :
                              {{$office->address_office}}
                        </span>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
