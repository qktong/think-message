<?php

namespace qktong\message\model;

use think\Model;

class SmsLog extends Model
{
    public function __construct(array $data = [])
    {
        $this->connection = config('message.database');
        parent::__construct($data);
    }

    public function addLog($mobile, $content, $status)
    {
        $data              = [];
        $data['mobile']    = $mobile;
        $data['content']   = $content;
        $data['status']    = $status;
        $data['send_time'] = time();
        return $this->insert($data);
    }

    public function getCount()
    {
        return $this->count();
    }

    public function getSmsLog($page, $page_size)
    {
        $result = $this
        ->field('id,mobile,content,status,send_time')
        ->order('id desc')
        ->limit($page, $page_size)
        ->select()
        ->toArray();
        return $result;
    }
}
