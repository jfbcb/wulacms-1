<?php
defined('KISSGO') or exit ('No direct script access allowed');
$tables ['1.0.0'] [] = "CREATE TABLE `{prefix}member_coins_account` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `create_time` int(10) unsigned NOT NULL COMMENT '账户创建时间',
  `mid` int(10) unsigned NOT NULL COMMENT '会员编号',
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '积分类型',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总金币',
  `balance` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '可用金币',
  `outlay` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已经使用金币',
  `mname` varchar(255) DEFAULT NULL COMMENT '会员名',
  `can_withdraw` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1可提现',
  `use_priority` smallint(5) NOT NULL DEFAULT '0' COMMENT '值越大越优先使用',
  PRIMARY KEY (`id`),
  KEY `IDX_TYPE_MID` (`type`,`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$tables ['1.0.0'] [] = "CREATE TABLE `{prefix}member_coins_record` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `create_time` int(10) unsigned NOT NULL COMMENT '金币产生时间',
  `mid` int(10) unsigned NOT NULL COMMENT '会员编号',
  `wid` int(10) DEFAULT '0' COMMENT '提现申请ID',
  `type` varchar(16) NOT NULL COMMENT '金币类型',
  `is_outlay` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是支出, 1是',
  `amount` int(11) NOT NULL COMMENT '数量',
  `balance` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '可用数量,只有is_outlay=0时才有意义',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间，只有is_outlay等于0的金币才有过期时间',
  `expired` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经过期',
  `subject` varchar(128) DEFAULT NULL COMMENT '金币项目,记录金币具体用途',
  `note` varchar(512) DEFAULT NULL COMMENT '备注说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员金币记录表'";

$tables ['1.0.0'] [] = "CREATE TABLE `{prefix}member_coins_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '金币种类名称',
  `type` varchar(16) NOT NULL COMMENT '金币种类',
  `reserved` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是系统预留的',
  `note` varchar(512) DEFAULT NULL COMMENT '说明',
  `deleted` tinyint(2) DEFAULT '0' COMMENT '0=>正常,1=>删除',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `update_uid` int(11) DEFAULT '0',
  `create_uid` int(11) DEFAULT '0',
  `can_withdraw` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1可以提现',
  `use_priority` smallint(5) NOT NULL DEFAULT '0' COMMENT '值越大越优先使用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UDX_TYPE` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8";
