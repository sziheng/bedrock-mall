<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/5/30
 * Time: 11:13
 */

namespace Bedrock\Models;


class OrderGoods extends BaseModel
{
    protected $table = 'ims_weshop_order_goods';
    public $timestamps = false;

    /**获取单条订单商品
     * @param $ogid
     * @return mixed
     */
    public function getOrderGoods($ogid)
    {
        return  self::where(['uniacid' => 65,'id'=>$ogid])->first();
    }

    /**
     * 订单商品关联商品模型
     */
    public function hanOneGoods()
    {
        return $this->hasOne('Bedrock\Models\Good', 'id', 'goodsid');
    }
}