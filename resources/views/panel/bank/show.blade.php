@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"> بانک {{$bank->title}}
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">
                    <a href="{{route('office.index')}}">
                    بانک ها
                    </a>
                </li>
                <li class="breadcrumb-item active">   بانک {{$bank->title}}
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
                    بانک {{$bank->title}}
                    </h3>

                </div>

                <div class="card-body">

                    <div class="row input-group p-1">
                        <div class="col-md-6">
                            <span>
                                نام بانک:
                                {{$bank->title}}

                            </span>
                        </div>

                        <div class="col-md-6">
                            <span>
                                تلفن:
                                {{$bank->phone}}
                            </span>

                        </div>


                    </div>

                    <div class="row input-group p-1">
                        <div class="col-md-4">
                            <span>
                                استان:{{$bank->state->province->name}}
                            </span>

                        </div>
                        <div class="col-md-4">
                            <span>
                                شهرستان :
                                {{$bank->state->name}}
                            </span>

                        </div>
                        <div class="col-md-4">
                            <span>
                                شهر:
                                {{$bank->city->name}}
                            </span>

                        </div>
                    </div>
                    <div class=" mt-2">

                        <span class="p-1 d-block">
                            آدرس بانک :
                            {{$bank->address}}
                        </span>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
