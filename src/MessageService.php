<?php
/*
 * 站内信
 */

namespace qktong;

use qktong\model\Message;
use qktong\model\MsgTemplate;

class MessageService extends BaseService
{

    public function getMessage($merchant_no, $page)
    {
        $model          = new Message();
        $message        = $model->getMessage($merchant_no, $page);
        foreach ($message as $k => $v) {
            $message[$k]['send_time'] = date('Y-m-d H:i:s', $v['send_time']);
        }
        $result['list'] = $message;
        $result['totle'] = $model->getMessageCount($merchant_no);
        return $this->success($result);
    }

    public function readMessage($id)
    {
        $model  = new Message();
        $result = $model->readMessage($id);
        return $this->success($result);
    }

    public function readAllMessage($merchant_no)
    {
        $model  = new Message();
        $result = $model->readAllMessage($merchant_no);
        return $this->success($result);
    }

    public function getContent($code)
    {
        $model = new MsgTemplate();
        return $model->getContent($code);
    }

    public function getInfo($type, $page)
    {
        $model = new Message();
        $list = $model->getInfo($type, $page);
        foreach ($list as $k => $v) {
            $list[$k]['send_time'] = date('Y-m-d H:i:s', $v['send_time']);
        }
        $result['list'] = $list;
        $result['total'] = $model->getInfoCount($type);
        return $this->success($result);
    }
    public function getALLMessageInfo($type, $merchant_no)
    {
        $model = new Message();
        $result['total'] = $model->getALLMessageInfoCount($type, $merchant_no);
        return $this->success($result);
    }
}
