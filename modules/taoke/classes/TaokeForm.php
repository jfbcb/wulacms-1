<?php
namespace taoke\classes;
class TaokeForm extends \AbstractForm {
	private $goods_id   = ['label' => '商品ID', 'widget' => 'hidden', 'type' => 'int', 'default' => 0];
	private $goods_url  = ['label' => '商品详情页链接地址', 'widget' => '', 'rules' => ['required' => 'r', 'url' => 'url']];
	private $tbk_url    = ['label' => '淘宝客链接', 'widget' => '', 'rules' => ['required' => 'r', 'url' => 'url']];
	private $coupon_url = ['label' => '商品优惠券推广链接', 'widget' => '', 'rules' => ['required' => 'r', 'url' => 'url']];

	private $price      = ['label' => '商品价格(单位：元)', 'widget' => '', 'group' => '9', 'col' => 3,];
	private $sale_count = ['label' => '商品月销量', 'widget' => '', 'group' => '9', 'col' => 3,];
	private $rate       = ['label' => '收入比率(%)', 'widget' => '', 'group' => '9', 'col' => 3,];
	private $comission  = ['label' => '佣金', 'widget' => '', 'group' => '9', 'col' => 3,];

	private $platform   = ['label' => '平台类型', 'widget' => 'select', 'group' => '10', 'col' => 3, 'defaults' => "天猫=天猫\n淘宝=淘宝"];
	private $shopname   = ['label' => '店铺名称', 'widget' => '', 'group' => '10', 'col' => 3];
	private $wangwang   = ['label' => '卖家旺旺', 'widget' => '', 'group' => '10', 'col' => 3];
	private $wangwangid = ['label' => '旺旺ID', 'widget' => '', 'group' => '10', 'col' => 3];

	private $coupon_count  = ['label' => '优惠券总量', 'type' => 'int', 'group' => '11', 'col' => 3,];
	private $coupon_remain = ['label' => '优惠券剩余量', 'type' => 'int', 'group' => '11', 'col' => 3,];
	private $coupon_start  = ['label' => '优惠券开始时间', 'widget' => 'date', 'group' => '11', 'col' => 3,];
	private $coupon_stop   = ['label' => '优惠券结束时间', 'widget' => 'date', 'group' => '11', 'col' => 3,];
}