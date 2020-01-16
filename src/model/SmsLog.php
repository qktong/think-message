<?php

namespace app\base\model;

use think\Model;

class SmsLog extends Model
{
    protected $connection = 'db.base';

    public function addSmsLog($data)
    {
        return $this->insert($data);
    }

    public function getCount($where)
    {
        return $this->where($where)->count();
    }

    public function getSmsLog($where, $start, $page_size)
    {
        $result = $this->where($where)->field('id,merchant_id,sms_name,mobile,content,status,return_info,send_time,send_ip')->order('send_time desc')->limit($start, $page_size)->select();
        foreach ($result as $key => $value) {
            $result[$key] = $value->toArray();
        }

        return $result;
    }
    
}
