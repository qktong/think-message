## 环境需求

- PHP >= 7.1
- thinkphp >= 6.0

## 介绍

发送通知，包括站内信，短信，钉钉等

## 安装

```shell
composer require "qktong/notice"
```

## 使用

```php
//发送信息
use qktong\message\Sender;
$sender = new Sender();
$sender->send(1, '18581037340', 'yzm', ['code' => '4326'], 1);
```

```php
//获取消息列表
use qktong\message\Message;
$msg  = new Message();
$list = $msg->getList(1, [1], 1, 10);
print_r($list);
```

```php
//阅读消息
use qktong\message\Message;
$msg    = new Message();
$result = $msg->readMessage(1, 1);
var_dump($result);
```

```php
//阅读全部消息
use qktong\message\Message;
$msg    = new Message();
$result = $msg->readAllMessage(1);
var_dump($result);
```

```php
//删除消息
use qktong\message\Message;
$msg    = new Message();
$result = $msg->deleteMessage(1,1);
var_dump($result);
```