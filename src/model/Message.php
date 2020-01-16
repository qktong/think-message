<?php
/*
 * @Descripttion: 站信息 数据层
 * @version: 0.0.0
 * @Author: YYHaier
 * @Date: 2019-10-29 15:46:05
 * @LastEditors: YYHaier
 * @LastEditTime: 2019-12-02 10:25:57
 */

namespace qktong\model;

use think\Model;

class Message extends Model
{
    protected $connection = 'base';

    public function sendMassage($merchant_no, $content, $type = 0, $code)
    {
        $msg['send_id']     = 1; //默认系统发送
        $msg['merchant_no'] = $merchant_no;
        $msg['content']     = $content;
        $msg['type']        = $type;
        $msg['code']        = $code;
        $msg['send_time']   = time();
        $result             = $this->insert($msg);

        return $result;
    }

    public function sendMassages($merchant_no, $content)
    {
        $list = explode(',', $merchant_no);
        foreach ($list as $key => $value) {
            $msg['send_id']     = 1; //默认系统发送
            $msg['merchant_no'] = $value;
            $msg['content']     = $content;
            $msg['send_time']   = time();
            $msg['send_time']   = time();
            $result             = $this->create($msg);
            if ($result) {
                $params[$key]['code']        = 1;
                $params[$key]['msg']         = '发送成功';
                $params[$key]['merchant_no'] = $value;
            } else {
                $params[$key]['code']        = 2;
                $params[$key]['msg']         = '发送失败';
                $params[$key]['merchant_no'] = $value;
            }
        }
        return $params;
    }

    public function getMessage($merchant_no, $page)
    {
        $list = $this->field('id,merchant_no,content,status,send_time')
            ->where('status', 'neq', 9)
            ->where('merchant_no', $merchant_no)
            ->order('id desc')
            ->limit(20)
            ->page($page)
            ->select();
        return $list;
    }

    public function getMessageCount($merchant_no)
    {
        return $this->where('merchant_no', $merchant_no)->count();
    }

    public function readMessage($id)
    {
        $result = $this->where('id', $id)->update(['status' => 1]);
        return $result;
    }

    public function readAllMessage($merchant_no)
    {
        $result = $this->where('merchant_no', $merchant_no)->update(['status' => 1]);
        return $result;
    }

    public function deleteMessage($id)
    {
        $result = $this->where('id', $id)->update(['status' => 9]);
        return $result;
    }

    public function getInfo($type, $page)
    {
        $where['type'] = $type;
        return $this->field('create_time,update_time', true)
            ->where($where)
            ->limit(20)
            ->page($page)
            ->order('id desc')
            ->select();
    }

    public function getInfoCount($type)
    {
        $where['type'] = $type;
        return $this->where($where)->count();
    }

    public function getALLMessageInfoCount($type,$merchant_no)
    {
        $type && $where['type']   = $type;
        $merchant_no && $where['merchant_no']   = $merchant_no;
        $where['status'] = 0;
        return $this->where($where)->count();
    }
}
