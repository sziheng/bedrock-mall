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

    public function getGoods($search)
    {
        $model = $this->whereHas('hanOneGoods', function ($query) use ($search) {
            $query->where('username', 'like', '%' . $search['username'] . '%');
        })->with(['hanOneGoods:id,username'])->get();
    }
}