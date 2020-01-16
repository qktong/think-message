<?php

namespace qktong;
use qktong\SenderService;

class Message
{
    // receiver 可以是接收者id receiver_id,手机号
    public function send($sender_id, $receiver, $code, $parmas, $type = 1)
    {
        $senderService= new SenderService();
        $senderService->send($sender_id, $receiver, $code, $parmas,$type);
        echo 'sending...';
    }

    public function getMessageList($receiver_id, $page = 1, $page_size = 10)
    {

    }

    public function readMessage($receiver_id, $message_id)
    {

    }
}
