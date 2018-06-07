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
        return  self::where(['uniacid' => UNIACID,'orderid'=>$orderid])->first();
    }

    public function getorderrefundlist($refundid)
    {
        return self::where('uniacid', UNIACID)->whereIn('id',$refundid)->get(['id','rtype','status'])->toArray();
    }


}