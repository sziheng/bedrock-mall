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
    protected $primaryKey = 'id';

    /**获取单条订单商品
     * @param $ogid
     * @return mixed
     */
    public function getOrderGoods($oid)
    {
        return  self::where(['uniacid' => 65,'orderid'=>$oid])->get()->toArray();
    }

    /**
     * 订单商品关联商品模型
     */
    public function hanOneGoods()
    {
        return $this->hasOne('Bedrock\Models\Good', 'id', 'goodsid');
    }

    /**根据订单Id获取商品信息
     * @param $oid
     */
    public function getGoodsByOid($oid)
    {

    }


    /**
     * 根据Id获取订单商品
     */
    public function getOrderGoodsId($id)
    {

    }
}