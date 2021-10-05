@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">بانک ها</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">بانک ها</li>
                <li class="breadcrumb-item active">ویرایش بانک</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">ویرایش بانک
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

                    <form action="{{route('bank.update',$bank->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    نام بانک
                                </label>

                                <input type="text" name="title" class="form-control"
                                       value="{{Request()->old('title')??$bank->title}}">
                            </div>
                            <div class="col-md-6">
                                <label>
                                    تلفن
                                </label>
                                <input type="text" name="phone" class="form-control" placeholder=" 05632222222"
                                       value="{{Request()->old('phone')??$bank->phone}}">
                            </div>

                        </div>

                        <div class="row input-group p-1">
                            <div class="col-md-4">
                                <label>
                                    استان
                                </label>
{{--                                @dd($bank->state->province)--}}

                                <select id="province" name="province_id" class="form-control">
                                    <option selected value="{{$bank->state->province_id}}">{{$bank->state->province->name}}</option>

                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}">{{$province->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    شهرستان
                                </label>
                                <select id="state" name="state_id" class="form-control">
                                    <option value="{{$bank->state_id}}">{{$bank->state->name}}</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    شهر
                                </label>
                                <select id="city" name="city_id" class="form-control">
                                    <option value="{{$bank->city_id}}">{{$bank->city->name}}</option>

                                </select>
                            </div>
                        </div>
                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                آدرس بانک :
                            </label>
                            <div class="col-12 ">
                                <textarea name="address" class="form-control p-0">{{Request()->old('address')??$bank->address}}</textarea>
                            </div>
                        </div>
                        <input type="submit" class="m-3 btn btn-success" value="ثبت">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->

@endsection
@section('script')
    <script>

        $(document).ready(function(){
            $("#province").change(()=>{
                var selectedItem = $('#province').children("option:selected").val();
                if(selectedItem.length>0){
                    axios.post('/state',{id:selectedItem})
                        .then(res => {
                            let data = res.data;
                            data = data.map(item => {
                                return `<option value="${item.id}">${item.name}</option>`
                            });
                            $('#state').empty().append("<option value='0'>انتخاب کنید</option>"+data);
                            $('#city').empty();
                        }).catch(err => {
                        console.log(err)
                    });
                }
            });
            $("#state").change(()=>{
                var selectedItem = $('#state').children("option:selected").val();
                if(selectedItem.length>0){
                    axios.post('/city',{id:selectedItem})
                        .then(res => {
                            let data = res.data;
                            data = data.map(item => {
                                return `<option value="${item.id}">${item.name}</option>`
                            });
                            $('#city').empty().append("<option value='0'>انتخاب کنید</option>"+data);
                        }).catch(err => {
                        console.log(err)
                    });
                }
            });
        });
    </script>
@endsection
