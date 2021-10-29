@extends('master.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class=" card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h4>کاربر ۱ </h4>
                            <br>
                            <p>name: {{getUser($connect->user_1)->name}}</p>
                            <p>username:@ {{getUser($connect->user_1)->username}}</p>
                            <p>gender : {{getUser($connect->user_1)->gender}}</p>
                            <p>chat id :{{getUser($connect->user_1)->chat_id}}</p>
                            <p>wallet :{{getUser($connect->user_1)->wallet}}</p>
                        </div>
                        <div class="col-6">
                            <h4>کاربر ۲ </h4>
                            <br>
                            <p>name: {{getUser($connect->user_2)->name}}</p>
                            <p>username:@ {{getUser($connect->user_2)->username}}</p>
                            <p>gender : {{getUser($connect->user_2)->gender}}</p>
                            <p>chat id :{{getUser($connect->user_2)->chat_id}}</p>
                            <p>wallet :{{getUser($connect->user_2)->wallet}}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">گفتگو</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">

                        @foreach($log as $l)
                            @if($l->sender == $connect->user_1)
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name float-left">{{getUser($l->sender)->name}}</span>
                                    </div>
                                    <div class="direct-chat-text">
                                        {{$l->caption}}
                                    </div>
                                </div>
                            @else
                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name float-right">{{getUser($l->sender)->name}}</span>
                                    </div>
                                    <div class="direct-chat-text">
                                        {{$l->caption}}
                                    </div>
                                </div>
                            @endif
                    @endforeach

                    <!-- /.direct-chat-pane -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{--                    <form action="#" method="post">--}}
                        {{--                        <div class="input-group">--}}
                        {{--                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">--}}
                        {{--                            <span class="input-group-append">--}}
                        {{--                      <button type="button" class="btn btn-primary">Send</button>--}}
                        {{--                    </span>--}}
                        {{--                        </div>--}}
                        {{--                    </form>--}}
                    </div>
                    <!-- /.card-footer-->
                </div>
            </div>
        </div>
        <!-- /.col -->

@endsection
