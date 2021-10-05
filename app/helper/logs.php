<?php
function allChat(){
    return \App\Models\ConnectLog::orderBy('id','desc')->get();
}
function getChat($id){
    return \App\Models\ChatLog::where('log_id',$id)->get();
}
