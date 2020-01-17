CREATE TABLE `prefix_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sender_id` bigint(20) unsigned NOT NULL COMMENT '发送者id',
  `receiver_id` bigint(20) unsigned NOT NULL COMMENT '接收者id',
  `content` varchar(5000) NOT NULL DEFAULT '' COMMENT '信息内容',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '站内信查看状态 0：未读 1：已读 9：删除',
  `send_time` int(10) unsigned NOT NULL COMMENT '发送时间',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '模板代码',
  `type` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '消息类型，1：普通消息 2系统消息',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='站内信';

CREATE TABLE `prefix_msg_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(20) NOT NULL COMMENT '模板代号',
  `content` varchar(1000) NOT NULL COMMENT '模板内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用 1是0否',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息模板';

CREATE TABLE `prefix_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mobile` text NOT NULL COMMENT '手机号',
  `content` varchar(512) NOT NULL DEFAULT '' COMMENT '短信内容',
  `send_time` int(10) unsigned NOT NULL COMMENT '发送时间',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '发送状态 0：未发送 1：已发送 2：发送失败',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='短信记录';

CREATE TABLE `prefix_sms_template_map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '模板代号',
  `sms_platform` varchar(32) NOT NULL DEFAULT '' COMMENT '短信平台',
  `template` varchar(32) NOT NULL DEFAULT '' COMMENT '短信平台模板代码',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_code_sms_platform` (`code`,`sms_platform`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='短信模板映射';