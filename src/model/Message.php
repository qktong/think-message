<?php

namespace qktong\message\model;

use think\Model;

class Message extends Model
{
    public function __construct(array $data = [])
    {
        $this->connection = config('message.database');
        parent::__construct($data);
    }

    public function sendMassage($sender_id, $receiver_id, $code, $content, $type = 1)
    {
        $msg                = [];
        $msg['sender_id']   = $sender_id;
        $msg['receiver_id'] = $receiver_id;
        $msg['content']     = $content;
        $msg['type']        = $type;
        $msg['code']        = $code;
        $msg['status']      = 0;
        $msg['send_time']   = time();
        $result             = $this->insert($msg);
        return $result;
    }

    public function getList($receiver_id, $type, $page, $page_size)
    {
        $list = $this->field('id,sender_id,receiver_id,content,status,send_time,type')
            ->where('status', '<>', 9)
            ->where('type', 'in', $type)
            ->where('receiver_id', $receiver_id)
            ->order('id desc')
            ->limit($page_size)
            ->page($page)
            ->select()
            ->toArray();
        return $list;
    }

    public function getCount($receiver_id, $type)
    {
        return $this
        ->where('receiver_id', $receiver_id)
        ->where('status', '<>', 9)
        ->where('type', 'in', $type)
        ->count();
    }

    public function readMessage($id, $receiver_id)
    {
        $result = $this
        ->where('id', $id)
        ->where('receiver_id', $receiver_id)
        ->update(['status' => 1]);
        return $result;
    }

    public function readAllMessage($receiver_id)
    {
        $result = $this
        ->where('receiver_id', $receiver_id)
        ->update(['status' => 1]);
        return $result;
    }

    public function deleteMessage($id, $receiver_id)
    {
        $result = $this
        ->where('id', $id)
        ->where('receiver_id', $receiver_id)
        ->update(['status' => 9]);
        return $result;
    }
}
