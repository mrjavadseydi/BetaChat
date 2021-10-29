<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public  $chat_id , $text , $markup , $markdown;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chat_id, $text,$markup,$markdown)
    {
        $this->chat_id = $chat_id;
        $this->text = $text;
        $this->markup = $markup;
        $this->markdown = $markdown;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $arr = [
            'chat_id'=>$this->chat_id,
            'text'=>$this->text
        ];
        if(!is_null($this->markup)){
            $arr['reply_markup']=$this->markup;
        }
        if (!is_null($this->markdown)){
            $arr['parse_mode']=$this->markdown;
        }

        sendMessage($arr);
    }
}
