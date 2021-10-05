@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">انصاب کاربران اداره</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">ادارات</li>
                <li class="breadcrumb-item active">انصاب کاربران اداره</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">انصاب کاربران اداره
                    </h3>

                </div>
                <!-- /.card-header -->
               <div class="card-body">
                    <div class="text-center">
                        <h4>
                            اداره {{$office->name}}
                        </h4>
                    </div>
                    <form method="post" action="{{route('office.users',$office->id)}}">

                          @csrf
                    <div class="row">
                        <label>
                            انتخاب کاربران اداره
                            {{$office->name}}
                        </label>

                        <select class="select2 js-states form-control" name="users[]" multiple="multiple">

                            @foreach($users as $user)
                                    <option  value="{{$user->id}}">{{$user->user_type." - " .$user->name}}</option>
                            @endforeach
                                @foreach($office->users()->get() as $user)
                                    <option selected value="{{$user->user_id}}">{{$user->user->user_type." - " .$user->user->name}}</option>
                                @endforeach

                        </select>
                    </div>
                        <div class="p-2">
                            <input class="btn btn-success" type="submit"  value="ثبت">
                        </div>

                    </form>

               </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col -->

@endsection
@section('script')

    <script>
        $(".select2").select2({
            placeholder: "انتخاب کنید"
        });
    </script>
@endsection
