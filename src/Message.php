<?php
/*
 * 站内信
 */

namespace qktong\message;

use qktong\message\model\Message as MsgModel;
use qktong\message\model\MsgTemplate;
use qktong\message\model\SmsLog;

class Message
{
    public function getList($receiver_id, $type, $page, $page_size = 10)
    {
        $model = new MsgModel();
        $list  = $model->getList($receiver_id, $type, $page, $page_size);
        foreach ($list as &$v) {
            $v['send_time'] = date('Y-m-d H:i:s', $v['send_time']);
        }
        $result          = [];
        $result['list']  = $list;
        $result['total'] = $model->getCount($receiver_id, $type);
        return $result;
    }

    public function readMessage($id, $receiver_id)
    {
        $model  = new MsgModel();
        $result = $model->readMessage($id, $receiver_id);
        return $result;
    }

    public function readAllMessage($receiver_id)
    {
        $model  = new MsgModel();
        $result = $model->readAllMessage($receiver_id);
        return $result;
    }

    public function deleteMessage($id, $receiver_id)
    {
        $model  = new MsgModel();
        $result = $model->deleteMessage($id, $receiver_id);
        return $result;
    }

    public function getSmsLog($page, $page_size, $mobile = '', $status = '', $start_time = 0, $end_time = 0)
    {
        $model = new SmsLog();
        $list  = $model->getSmsLog($page, $page_size, $mobile, $status, $start_time, $end_time);
        $status=[0=>'未发送',1=>'已发送',2=>'发送失败'];
        foreach ($list as &$v) {
            $v['status_text'] =$status[$v['status']];
            $v['send_time']=date('Y-m-d H:i:s',$v['send_time']);
        }
        $total = $model->getCount($mobile, $status, $start_time, $end_time);
        return ['list' => $list, 'total' => $total];
    }
}
