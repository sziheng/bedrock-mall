<?php

namespace Bedrock\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Order
 *
 * @package \Bedrock\Models
 */
class Order extends BaseModel
{
    protected $table = 'ims_weshop_order';

    protected $primaryKey = 'id';


    /**
     * 关联订单商品模型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasManyOrderGoods()
    {
        return $this->hasMany('Bedrock\Models\OrderGoods', 'orderid', 'id');
    }

    /**
     * 获取订单地址
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOneMemberAddress()
    {
        return $this->hasOne('Bedrock\Models\MemberAddress', 'id', 'addressid');
    }

    /**
     * 获取订单的用户信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOneUser()
    {
        return $this->hasOne('Bedrock\Models\User', 'openid', 'openid');
    }

    public function hasOneOrderRefund()
    {
        return $this->hasOne('Bedrock\Models\OrderRefund', 'id', 'refundid');
    }

    public function hasOneDispatch()
    {
        return $this->hasOne('Bedrock\Models\Dispatch', 'id', 'dispatchid');
    }

    public function hasOneSaler()
    {
        return $this->hasOne('Bedrock\Models\Saler', 'openid', 'verifyopenid');
    }

    public  function hasManyThroughGoods()
    {
        $this->hasManyThrough('Bedrock\Models\OrderGoods','Bedrock\Models\Good','orderid','');
    }
    /**
     * 获取平台总销售额
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function sumAllAmount()
    {
        return self::where('uniacid', UNIACID)->whereIn('status', [1, 2, 3])->sum('price');
    }

    /**
     * 获取订单数据
     * @author by 王振
     * @param $parameter
     * @return mixed
     */
    public function getorderData()
    {
        $orders = self::where(['uniacid' => UNIACID, 'ismr' => 0, 'deleted' => 0, 'isparent' => 0])->with(array('hasManyOrderGoods'=>
            function ($query) {
                $query->select('id','orderid');
            }))->where('id',853)->get()->toArray();
        return $orders;
    }

    /**
     * 获取全部订单数据
     * @author by 王振
     *
     */
    public function getAllorderData($paras,$request)
    {
        return self::where(['uniacid' => UNIACID, 'ismr' => 0, 'deleted' => 0, 'isparent' => 0])
            ->with('hasManyOrderGoods')
            ->with('hasOneUser')
            ->with('hasOneMemberAddress')
            ->with('hasOneOrderRefund')
            ->with('hasOneDispatch')
            ->with('hasOneSaler')
            ->where(function ($query) use ($paras,$request){
                if (isset($paras['searchtime'])) {
                    $query->where($paras['searchtime'],'>=',$request['starttime'])->where($paras['searchtime'],'<=',$request['endtime']);
                }
            })
            ->where(function ($query) use ($paras){
                if (isset($paras['paytype']) && $paras['paytype'] == '2') {
                    $query->where('paytype',2)
                        ->orWhere(function($query){
                            $query->where('paytype', 22);
                        })
                        ->orWhere(function($query){
                            $query->where('paytype', 23);
                        });
                }else{
                    $query->where('paytype',intval($paras['paytype']));
                }
            })
            ->where(function ($query) use ($paras){
                if (isset($paras['status'])) {
                    switch ($paras['status'])
                    {
                        case '-1':
                            $query->where('status',-1)->where('refundtime',0);
                            break;
                        case '4':
                            $query->where('refundstate','>',0)->where('refundid','<>',0);
                            break;
                        case '5':
                            $query->where('refundtime','<>',0);
                            break;
                        case '1':
                            $query->where('status',1)
                                ->orWhere(function($query){
                                    $query->where('status', 0)->where('paytype',3);
                                });
                            break;
                        case '0':
                            $query->where('status',0)->where('paytype','<>',3);
                            break;
                        default:
                            $query->where('refundtime',intval($paras['status']));
                            break;
                    }
                }
            })
            ->where(function ($query) use ($paras){
                if (isset($paras['searchfield'])) {
                    switch ($paras['searchfield'])
                    {
                        case  'ordersn':
                            $query->where('ordersn', 'like', '%' . $paras['keyword'] . '%');
                            break;
                        case  'member':
                            break;
                        case  'address':
                            $query->where('address', 'like', '%' . $paras['keyword'] . '%')
                                ->orWhere('carrier', 'like', '%' . $paras['keyword'] . '%');
                            break;
                        case  'expresssn':
                            $query->where('expresssn', 'like', '%' . $paras['keyword'] . '%');
                            break;
                        case  'saler':
                            break;
                        case  'store':
                            break;
                        case  'goodstitle':
                            break;
                        case  'goodssn':
                            break;
                        case  'merch':
                            break;
                        case  'activity':
                            break;
                    }
                }
            })
            ->groupBy('id')
            ->orderBy('createtime', 'desc')
            ->skip($request['offset'])
            ->take($request['psize'])
            ->get()->toArray();
           // ->paginate($request['psize'])->toArray();
    }

    public function getOrderList($paras,$request)
    {
        return self::where(['uniacid' => UNIACID, 'ismr' => 0, 'deleted' => 0, 'isparent' => 0])
            ->where(function ($query) use ($paras,$request){
                if (isset($paras['searchtime'])) {
                    $query->where($paras['searchtime'],'>=',$request['starttime'])->where($paras['searchtime'],'<=',$request['endtime']);
                }
            })
            ->where(function ($query) use ($paras){
                if (isset($paras['paytype']) && $paras['paytype'] == '2') {
                    $query->where('paytype',2)
                        ->orWhere(function($query){
                            $query->where('paytype', 22);
                        })
                        ->orWhere(function($query){
                            $query->where('paytype', 23);
                        });
                }else{
                    $query->where('paytype',intval($paras['paytype']));
                }
            })
            ->where(function ($query) use ($paras){
                if (isset($paras['status'])) {
                    switch ($paras['status'])
                    {
                        case '-1':
                            $query->where('status',-1)->where('refundtime',0);
                            break;
                        case '4':
                            $query->where('refundstate','>',0)->where('refundid','<>',0);
                            break;
                        case '5':
                            $query->where('refundtime','<>',0);
                            break;
                        case '1':
                            $query->where('status',1)
                                ->orWhere(function($query){
                                    $query->where('status', 0)->where('paytype',3);
                                });
                            break;
                        case '0':
                            $query->where('status',0)->where('paytype','<>',3);
                            break;
                        default:
                            $query->where('refundtime',intval($paras['status']));
                            break;
                    }
                }
            })
            ->groupBy('id')
            ->orderBy('createtime', 'desc')
            ->skip(1)
            ->take(20)
            ->get()->toArray();
            //->paginate($request['psize'])  ->toArray();
    }
    /**
     * 获取订单详情数据
     */
    public function getOrderDetail($requests)
    {

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
        return self::where('uniacid', UNIACID)->whereIn('status', [1, 2, 3])->where('price', '>', 0)->count();
    }

    /**
     * 删除订单（软删除）
     * by王振
     */
    public function deleteOrder($orderid)
    {
      return  self::where(['uniacid' => UNIACID,'id'=>$orderid])->update(['deleted'=>1]);
    }

    /**
     * 获取单条订单数据
     * @param $orderid
     * @return mixed
     */
    public function  getopData($orderid)
    {
        return  self::where(['uniacid' => UNIACID,'id'=>$orderid])->first();
    }


}
