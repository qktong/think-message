<?php

namespace qktong\message\model;

use think\Model;

class MsgTemplate extends Model
{
    public function __construct(array $data = [])
    {
        $this->connection = config('message.database');
        parent::__construct($data);
    }

    public function getContent($code)
    {
        return $this->where('code', $code)->where('status',1)->value('content');
    }
}
