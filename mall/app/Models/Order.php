<?php

namespace Bedrock\Models;

/**
 * Class Order
 *
 * @package \Bedrock\Models
 */
class Order extends BaseModel
{
    protected $table = 'ims_weshop_order';

    protected $primaryKey = 'ordersn';

    /**
     * 获取平台总销售额
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function sumAllAmount()
    {
        return self::where('uniacid', 65)->whereIn('status', [1, 2, 3])->sum('price');
    }

    /**
     * 获取订单数据
     * @param $parameter
     * @return mixed
     */
    public function  getorderData($parameter)
    {
        return self::where('uniacid', 65)->where($parameter)->all();
    }

    public function getAllorderData()
    {

    }

    /**
     * 获取订单详细数据
     */
    public function  getOrder()
    {

    }

    /**
     * 根据订单Id修改订单
     */
    public function setOrderById()
    {

    }

    public function  selectOrderPrice()
    {

    }

    public function  ajaxtransaction()
    {

    }

    public function ajaxorder()
    {

    }

    /**
     * 获取平台总订单数
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function getOrderNum()
    {
        return self::where('uniacid', 65)->whereIn('status', [1, 2, 3])->where('price', '>', 0)->count();
    }

}
