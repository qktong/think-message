<?php
/*
 * 
 */

namespace qktong\model;

use think\Model;

class MsgTemplate extends Model
{
    // protected $connection='base';
    // protected $connection;

    public function __construct()
    {
        $this->connection = config('message.database');
        var_dump($this->connection);exit;
        parent::__construct();
    }


    public function getContent($code)
    {
        return $this->where('code', $code)->where('status',1)->value('content');
    }
}
