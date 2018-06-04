<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/5/30
 * Time: 11:12
 */

namespace Bedrock\Models;


class OrderRefund extends BaseModel
{
    protected $table = 'ims_weshop_order_refund';
    public $timestamps = false;

    public function  getOrderRefund($orderid)
    {
        return  self::where(['uniacid' => 65,'orderid'=>$orderid])->first();
    }
}