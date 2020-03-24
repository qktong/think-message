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

    public function getCount($mobile = '', $status = '', $start_time = 0, $end_time = 0)
    {
        $where                          = [];
        $mobile             && $where[] = ['mobile', '=',  $mobile];
        is_numeric($status) && $where[] = ['status', '=',  $status];
        $start_time > 0     && $where[] = ['send_time', '>=', $start_time];
        $end_time   > 0     && $where[] = ['send_time', '<=', $end_time];
        return $this->where($where)->count();
    }

    public function getSmsLog($page, $page_size, $mobile = '', $status = '', $start_time = 0, $end_time = 0)
    {
        $where                          = [];
        $mobile             && $where[] = ['mobile', '=',  $mobile];
        is_numeric($status) && $where[] = ['status', '=',  $status];
        $start_time > 0     && $where[] = ['send_time', '>=', $start_time];
        $end_time   > 0     && $where[] = ['send_time', '<=', $end_time];

        $result = $this
        ->field('id,mobile,content,status,send_time')
        ->where($where)
        ->order('id desc')
        ->limit($page_size)
        ->page($page)
        ->select()
        ->toArray();
        return $result;
    }
}
