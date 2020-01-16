<?php
/*
 * @Descripttion: 信息模板 数据层
 * @version: 0.0.0
 * @Author: YYHaier
 * @Date: 2019-10-29 15:46:05
 * @LastEditors: YYHaier
 * @LastEditTime: 2019-10-30 16:10:57
 */

namespace app\base\model;

use think\Model;

class SmsTemplateMap extends Model
{
    protected $connection = 'db.base';

    public function getSmsTemplate($code, $sms_platform)
    {
        return $this->where(['code' => $code, 'sms_platform' => $sms_platform])->value('template');
    }
}
