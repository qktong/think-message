<?php
/*
 * 发送信息
 */

namespace qktong\message;

use qktong\message\model\Message;
use qktong\message\model\MsgTemplate;
use qktong\message\model\SmsLog;
use qktong\message\model\SmsTemplateMap;
use Overtrue\EasySms\EasySms;

class Sender
{
    /**
     * 发送信息
     * @access public
     * @param int sender_id 发送者id
     * @param mixed $receiver 1:整形,代表用户id，发送站内信;2:字条串并是手机号，发送短信;3:数组，会根据值自动判断，自动选择发磅站内信还是短信
     * @param string $code 信息模板代码
     * @param array $params 信息模板里的参数，顺序需要和模板里的一致
     * @param int $type   1：普通消息 2系统消息
     * @return mixed null没有发送 true发送成功 false 发送失败
     */
    protected function send($sender_id, $receiver = [], $code, $params, $type = 1)
    {
        $message = $this->getMessageContent($code, $params);
        if ($message == false) {
            throw new \think\Exception('没有找到要发送的信息模板 code:' . $code, 10006);
        }
        // 防止重复调用
        $cacheKey = 'SendLimit:' . $code . ':' . md5(json_encode($receiver));
        $lastTime = cache($cacheKey);
        if (empty($lastTime)) {
            $lastTime = 0;
        }
        $time = time();
        if (($time - $lastTime) < 1) {
            return true;
        }

        $sendChannel = [];
        if (! is_array($receiver)) {
            $sendChannel[] = $receiver;
        } else {
            $sendChannel = $receiver;
        }
        $result = null;
        foreach ($sendChannel as $val) {
            // 手机号
            if (is_string($val) && preg_match('/^1[3-9]\d{9}$/', $val)) {
                // 发送短信
                $result = $this->sendSms($val, $code, $message, $params);
            }
            // id
            if (is_int($val)) {
                // 发送站内信
                $result = $this->sendMassage($sender_id, $val, $code, $message, $type);
            }
        }

        cache($cacheKey, $time);
        return $result;
    }

    // 获取信息内容
    private function getMessageContent($code, $params)
    {
        $msgTemplate = new MsgTemplate();
        $content     = $msgTemplate->getContent($code);
        if (empty($content)) {
            return false;
        }
        $find    = [];
        $replace = [];
        foreach ($params as $key => $val) {
            $find[]    = "{{$key}}";
            $replace[] = $val;
        }
        return str_replace($find, $replace, $content);
    }

    // 发送短信
    private function sendSms($mobile, $code, $message, $params)
    {
        $config   = config('easy_sms');
        $gateways = $config['default']['gateways'][0] ?? '';
        if (empty($gateways)) {
            throw new \think\Exception('请先配置短信的网关，配置文件:config/easy_sms.php');
        }

        $smsTemplateMap = new SmsTemplateMap();
        $template       = $smsTemplateMap->getSmsTemplate($code, $gateways);
        if (empty($template)) {
            throw new \think\Exception("没有找到要发送信息平台对应的模板 code:{$code},gateways:{$gateways}");
        }
        $data = [];
        foreach ($params as $k => $v) {
            $data[] = $v;
        }
        $error  = [];
        $result = false;
        try {
            $easySms = new EasySms($config);
            $result  = $easySms->send($mobile, [
                'content'  => $message,
                'template' => $template,
                'data'     => $data,
            ]);
        } catch (\Exception $exception) {
            $error = $exception->getExceptions();
            $debug = config('easy_sms.debug');
            if ($debug) {
                print_r($error);
            }
        }
        $status = 1;
        if ($error) {
            $status = 2;
        }
        $smsLog = new SmsLog();
        $smsLog->addLog($mobile, $message, $status);

        return $error ? false : true;
    }

    // 发送站内信
    private function sendMassage($sender_id, $receiver_id, $code, $content, $type)
    {
        $message = new Message();
        $result  = $message->sendMassage($sender_id, $receiver_id, $code, $content, $type);
        return $result;
    }
}
