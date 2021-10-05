@extends('master.master')
@section('position')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">ادارات</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{route('panel')}}">خانه</a></li>
                <li class="breadcrumb-item ">ادارات</li>
                <li class="breadcrumb-item active">ویرایش اداره</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">ویرایش اداره
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

                    <form action="{{route('office.update',$office->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    نام اداره
                                </label>

                                <input type="text" name="name" class="form-control" placeholder="امداد مرکزی"
                                       value="{{Request()->old('name')??$office->name}}">
                            </div>
                            <div class="col-md-6">
                                <label>
                                    کد
                                </label>

                                <input type="number" name="code" class="form-control" placeholder="12432"
                                       value="{{Request()->old('code')??$office->code}}">
                            </div>

                        </div>
                        <div class="row input-group p-1">


                            <div class="col-md-6">
                                <label>
                                    تلفن
                                </label>
                                <input type="text" name="phone" class="form-control" placeholder=" 05632222222"
                                       value="{{Request()->old('phone')??$office->phone}}">
                            </div>

                            <div class="col-md-6">
                                <label>
                                    نام ریاست اداره
                                </label>
                                <input type="text" name="boss_name" class="form-control"
                                       placeholder="دکتر احمد احمدی" value="{{Request()->old('boss_name')??$office->boss_name}}">
                            </div>
                        </div>

                        <div class="row input-group p-1">
                            <div class="col-md-6">
                                <label>
                                    تلفن دفتر شرکت
                                </label>
                                <input type="text" name="phone_office" class="form-control" placeholder="091549515555"
                                       value="{{Request()->old('phone_office')??$office->phone_office}}">
                            </div>
                            <div class="col-md-6">
                                <label>
                                    مسئول دفتر شرکت
                                </label>
                                <input type="text" name="employment_name" class="form-control" placeholder="مهندس علی عبادی"
                                       value="{{Request()->old('employment_name')??$office->employment_name}}">
                            </div>
                        </div>
                        <div class="row input-group p-1">
                            <div class="col-md-4">
                                <label>
                                    استان
                                </label>
                                <select id="province" name="province_id" class="form-control">

                                    <option value="{{$office->province_id}}">{{$office->province->name}}</option>

                                    @foreach($provines as $province)
                                        <option value="{{$province->id}}">{{$province->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    شهرستان
                                </label>
                                <select id="state" name="state_id" class="form-control">
                                    <option value="{{$office->state_id}}">{{$office->state->name}}</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    شهر
                                </label>
                                <select id="city" name="city_id" class="form-control">
                                    <option value="{{$office->city_id}}">{{$office->city->name}}</option>

                                </select>
                            </div>
                        </div>
                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                آدرس اداره :
                            </label>
                            <div class="col-12 ">

                                <textarea name="address" class="form-control p-0">{{Request()->old('address')??$office->address}}</textarea>

                            </div>
                        </div>
                        <div class=" mt-2">

                            <label class="p-1 d-block">
                                آدرس دفتر شرکت :
                            </label>
                            <div class="col-12 ">

                                <textarea name="address_office" class="form-control p-0">{{Request()->old('address_office')??$office->address_office}}</textarea>

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
