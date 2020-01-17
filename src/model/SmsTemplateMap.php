<?php

namespace qktong\message\model;

use think\Model;

class SmsTemplateMap extends Model
{
    public function __construct(array $data = [])
    {
        $this->connection = config('message.database');
        parent::__construct($data);
    }

    public function getSmsTemplate($code, $sms_platform)
    {
        return $this->where(['code' => $code, 'sms_platform' => $sms_platform])->value('template');
    }
}
