@extends('master.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
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
