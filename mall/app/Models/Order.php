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
    protected $timestraps = false;

    /**
     * @param int $day
     * @return array
     */
    public function selectOrderPrice($day = 0)
    {
        $day = (int) $day;
        $uniacid=65;
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
        $pdo_res = DB::table('order')->where('uniacid',65)->get();

        $sql = 'select id,price,createtime from ' . tablename('weshop_order') . ' where uniacid = :uniacid and ismr=0 and isparent=0 and (status > 0 or ( status=0 and paytype=3)) and deleted=0 and createtime between :createtime1 and :createtime2';
        $param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);

        $price = 0;
        foreach ($pdo_res as $arr )
        {
            $price += $arr['price'];
        }
        $result = array('price' => round($price, 1), 'count' => count($pdo_res), 'fetchall' => $pdo_res);
        return $result;
    }
}
