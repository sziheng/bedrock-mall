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
     * @author by 王振
     * @param $parameter
     * @return mixed
     */
    public function getorderData($paras)
    {
        $orders = self::where(['uniacid' => 65, 'ismr' => 0, 'deleted' => 0, 'isparent' => 0])->where(function ($query) use ($paras) {
            if (isset($paras['school_name']) && $paras['school_name']) {
                $query->where('sid', '=', $paras['school_name']);
            }
        })->get();
        return $orders;
    }

    /**
     * 获取全部订单数据
     * @author by 王振
     *
     */
    public function getAllorderData()
    {
        return self::where(['uniacid' => 65, 'ismr' => 0, 'deleted' => 0, 'isparent' => 0])->paginate(15);
    }

    /**
     * 获取订单详细数据
     */
    public function getOrder($requests)
    {
        $orders = Order::select()->with('has_orderitems')->where('status', '>=', config('payment.ORDER_STATE_PAY'))->where(function ($query) use ($requests) {
            if (isset($requests['school_name']) && $requests['school_name']) {
                $query->where('sid', '=', $requests['school_name']);
            }
        })->where(function ($query) use ($requests) {
            if (isset($requests['dorm_name']) && $requests['dorm_name']) {
                $query->whereIn('did', $requests['dorm_name']);
            }
        })->where(function ($query) use ($requests) {
            if (!empty($requests['date_time_start']) && !empty($requests['date_time_end'])) {
                $query->where('created_at', '>=', $requests['date_time_start'])
                    ->where('created_at', '<=', $requests['date_time_start']);
            } else if (!empty($data['date_time_start'])) {
                $query->where('created_at', '>=', $requests['date_time_start']);
            } else if (!empty($data['date_time_end'])) {
                $query->where('created_at', '<=', $requests['date_time_start']);
            }
        })->get();
    }



    /**获取订单价格
     * by 王振
     * @param $key
     * @return mixed
     */
    public function getOrderPrice($day)
    {
        $day = (int) $day;
        if ($day != 0)
        {
            $createtime1 = strtotime(date('Y-m-d', time() - ($day * 3600 * 24)));
            $createtime2 = strtotime(date('Y-m-d', time()));
        }
        else
        {
            $createtime1 = strtotime(date('Y-m-d', time()));
            $createtime2 = strtotime(date('Y-m-d', time() + (3600 * 24)));
        }
        $pdo_res= self::where(['uniacid' => 65, 'ismr' => 0, 'deleted' => 0, 'isparent' => 0])->where(function ($query){
            $query->where('status', '>',0)
                ->orWhere(function ($query) {
                    $query->where(['status' => 0, 'paytype' => 3]);
                });
        })->where('createtime','>=',$createtime1)->where('createtime','<=',$createtime2)->get(['id','price','createtime']);
        $price = 0;
        foreach ($pdo_res as $arr )
        {
            $price += $arr['price'];
        }
        $result = array('price' => round($price, 1), 'count' => count($pdo_res), 'fetchall' => $pdo_res);
        return $result;
    }

    /**获取各种状态订单数量
     * by 王振
     * @param $paras
     * @return mixed
     */
    public function getTotalsCount($paras)
    {
        if (isset($paras['merchid']) && $paras['merchid']) {
            if (intval($paras['merchid']) < 0) {
                $paras['merchid'] = 0;
            }
        }
        return self::where(['uniacid' => 65, 'isparent' => 0, 'ismr' => 0, 'deleted' => 0])->where(function ($query) use ($paras) {
            if (isset($paras['merchid']) && $paras['merchid']) {
                $query->where('merchid', $paras['merchid']);
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status0') {
                $query->where('status', 0)->where('paytype', '<>', 3);
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status1') {
                $query->where('status', 1)
                    ->orWhere(function ($query) {
                        $query->where(['status' => 0, 'paytype' => 3]);
                    });
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status2') {
                $query->where('status', 2);
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status3') {
                $query->where('status', 3);
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status4') {
                $query->where('refundstate', '>', 0)->where('refundid', '<>', 0);
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status5') {
                $query->where('refundtime', '<>', 0);
            }
        })->where(function ($query) use ($paras) {
            if (isset($paras['typename']) && $paras['typename'] == 'status_1') {
                $query->where(['status' => -1, 'refundtime' => 0]);
            }
        })->count();
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
