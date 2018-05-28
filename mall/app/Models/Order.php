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
     * 获取平台总订单数
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function getOrderNum()
    {
        return self::where('uniacid', 65)->whereIn('status', [1, 2, 3])->where('price', '>', 0)->count();
    }

}
