@extends('master.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title d-inline">لیست چت
                    </h3>

                </div>
                <!-- /.card-header -->
                <div class="table-responsive p-1 " style="overflow: hidden">
                    <table class="table table-striped" >
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>اسم کاربر اول</th>
                            <th>نام کاربری اول</th>
                            <th>جنسیت کاربر اول</th>
                            <th>اسم کاربر دوم</th>
                            <th>نام کاربری دوم</th>
                            <th>جنسیت کاربر دوم</th>
                            <th>زمان ایجاد</th>
                            <th>تعداد</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($chats as $chat)
                            <tr>
                                <td>{{$loop->iteration}}.</td>
                                <td>{{getUser($chat->user_1)->name}}</td>
{{--                                <td>{{getUser($chat->user_1)->chat_id}}</td>/--}}
                                <td>{{getUser($chat->user_1)->username}}</td>
                                <td>{{getUser($chat->user_1)->gender}}</td>
{{--                                <td>{{getUser($chat->user_1)->wallet}}</td>/--}}
{{--                                <td>{{getUser($chat->user_1)->money}}</td>--}}
                                <td>{{getUser($chat->user_2)->name}}</td>
{{--                                <td>{{getUser($chat->user_2)->chat_id}}</td>--}}
                                <td>{{getUser($chat->user_2)->username}}</td>
                                <td>{{getUser($chat->user_2)->gender}}</td>
{{--                                <td>{{getUser($chat->user_2)->wallet}}</td>--}}
{{--                                <td>{{getUser($chat->user_2)->money}}</td>--}}
                                <td>
                                    {{$chat->created_at}}
                                </td>
                                <td>
                                    {{count(getChat($chat->id))}}
                                </td>
                                <td>

                                    <a class="btn btn-sm btn-primary" href="{{route('chat.show',$chat->id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
{{--                                    <button type="button" class="btn btn-sm btn-danger trashbtn" data-id="{{$user->id}}">--}}
{{--                                        <i class="fa fa-trash"></i>--}}
{{--                                    </button>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {{ $chats->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col -->

@endsection
