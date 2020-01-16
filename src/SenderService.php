<?php
/*
 * 发送信息
 */

namespace qktong;

use qktong\model\Message;
use qktong\model\MsgTemplate;

class SenderService
{
    public function send($sender_id, $receiver = [], $code, $params, $type = 1)
    {
        $message = $this->getMessageContent($code, $params);
        echo $message;
        exit;
        // 防止重复调用
        $cacheKey = 'SendLimit:' . $code . ':' . md5(json_encode($receiver));
        $lastTime = cache($cacheKey);
        if (empty($lastTime)) {
            $lastTime = 0;
        }
        $time = time();
        if (($time - $lastTime) < 60) {
            return true;
        }

        if (! is_array($receiver)) {
            $receiver[] = $receiver;
        }

        foreach ($receiver as $val) {
            // 手机号
            if (is_string($val) && preg_match('/^1[3-9]\d{9}$/', $val)) {
                // 发送短信
                $service = new SmsService();
                $result  = $service->sendSms($phone, $code, $text, $data);
            }
            // id
            if (is_int($val)) {
                // 发送站内信
                $result = $this->sendMassage($merchant_no, $text, $type, $code);
            }
        }

        cache($cacheKey, $time);
        return true;
    }

    // 获取信息内容
    public function getMessageContent($code, $params)
    {
        $msgTemplate = new MsgTemplate();
        $content     = $msgTemplate->getContent($code);
        echo $msgTemplate->getLastSql();
        var_dump($content);
    }
}
