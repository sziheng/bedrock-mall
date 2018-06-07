<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Order;
use Bedrock\Models\OrderGoods;
use Bedrock\Models\Good;
use Bedrock\Models\Saler;
use Illuminate\Http\Request;


class OrderController extends BaseController
{
    protected $order;
    protected $ordergoods;
    protected $goods;
    protected $saler;

    public function __construct(Order $order, OrderGoods $ordergoods, Good $goods,Saler $saler)
    {
        $this->order = $order;
        $this->ordergoods = $ordergoods;
        $this->goods = $goods;
        $this->saler = $saler;
        parent::__construct();
    }

    public function index()
    {
        return view('admin.order.index');
    }

    public function status0(Request $request)
    {
        $typename= $this->orderlist($request);
      //  return view('admin.order.list', compact('typename'));
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function orderlist(Request $request,$st)
    {
        $status = $request->status;
        $keyword = trim($request->keyword);
        $agentid = $request->agentid;
        $refund = $request->refund;
        $paytype = $request->paytype;
        $searchtime = $request->searchtime;
        $searchfield = $request->searchfield;
        $page=$request->page;
        $sendtype = (isset($request->sendtype)? 0 : $request->sendtype);
        $pindex = max(1, intval($page));
        $psize = 20;
        if (true) //是否开放多供应商
            $is_openmerch = 1;
        else
            $is_openmerch = 0;

        if ($st == 'orderlist')//是否是全部订单
            $st = '';
        else
            $st = '.' . $st;
        if (empty($starttime) || empty($endtime))
        {
            $starttime = strtotime('-1 month');
            $endtime = time();
        }
        if (!empty($searchtime) && is_array( $request->time) && in_array($searchtime, array('create', 'pay', 'send', 'finish')))
        {
            $starttime = strtotime($request->time['start']);
            $endtime = strtotime($request->time['end']);
           // $condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
           // $paras[':starttime'] = $starttime;
           // $paras[':endtime'] = $endtime;
        }
        if ($request->paytype != '')
        {
            if ($request->paytype == '2')
            {
                //$condition .= ' AND ( o.paytype =21 or o.paytype=22 or o.paytype=23 )';
            }
            else
            {
                //$condition .= ' AND o.paytype =' . intval($_GPC['paytype']);
            }
        }
        if (!empty($request->searchfield) && !empty($keyword))
        {
            $searchfield = trim(strtolower($request->searchfield));
            $keyword = trim($keyword);
            //$paras[':keyword'] = $_GPC['keyword'];

            switch ($searchfield)
            {
                case  'ordersn':
                    break;
                case  'member':
                    break;
                case  'address':
                    break;
                case  'expresssn':
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
            if ($status !== '')
            {
                switch ($searchfield)
                {
                    case '-1':

                        break;
                    case '4':

                        break;
                    case '5':

                        break;
                    case '1':

                        break;
                    case '0':

                        break;
                    default:
                        break;
                }

            }
        }
        $level = 0;

        $olevel=$request->olevel;
        if (!empty($agentid) && (0 < $level))
        {
           // $agent = $p->getInfo($agentid, array());
            $agent=array();
            if (!empty($agent))
            {
              // $agentLevel = $p->getLevel($agentid);
                $agentLevel=1;
            }
            if (empty($olevel))
            {
                if (1 <= $level)
                {
                    //$condition .= ' and  ( o.agentid=' . intval($agentid);
                }
                if ((2 <= $level) && (0 < $agent['level2']))
                {
                   // $condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
                }
                if ((3 <= $level) && (0 < $agent['level3']))
                {
                  //  $condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
                }
                if (1 <= $level)
                {
                  //  $condition .= ')';
                }
            }
            else if ($olevel == 1)
            {
               // $condition .= ' and  o.agentid=' . intval($_GPC['agentid']);
            }
            else if ($olevel == 2)
            {
                if (0 < $agent['level2'])
                {
                   // $condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
                }
                else
                {
                 //   $condition .= ' and o.agentid in( 0 )';
                }
            }
            else if ($olevel == 3)
            {
                if (0 < $agent['level3'])
                {
                  //  $condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
                }
                else
                {
                  //  $condition .= ' and o.agentid in( 0 )';
                }
            }
        }



        $paytype = array( 0 => array('css' => 'default', 'name' => '未支付'), 1 => array('css' => 'danger', 'name' => '余额支付'), 11 => array('css' => 'default', 'name' => '后台付款'), 2 => array('css' => 'danger', 'name' => '在线支付'), 21 => array('css' => 'success', 'name' => '微信支付'), 22 => array('css' => 'warning', 'name' => '支付宝支付'), 23 => array('css' => 'warning', 'name' => '银联支付'), 3 => array('css' => 'primary', 'name' => '货到付款') );
        $orderstatus = array( -1 => array('css' => 'default', 'name' => '已关闭'), 0 => array('css' => 'danger', 'name' => '待付款'), 1 => array('css' => 'info', 'name' => '待发货'), 2 => array('css' => 'warning', 'name' => '待收货'), 3 => array('css' => 'success', 'name' => '已完成') );
        $is_merch = array();
        $is_merchname = 0;
        $cars=array(1,2,3);
        $query=$this->order->getAllorderData();

        print_r($query);
      // var_dump($query);
        return $query;
    }


    /**
     * 获取订单数据源
     * @param Request $request
     */
    protected function  orderlistcore(Request $request)
    {

    }

    /**
     * 获取
     */
    public function ajaxgettotals()
    {
        $totals['all'] = $this->order->getTotalsCount(array('typename' => 'all'));
        $totals['status_1'] = $this->order->getTotalsCount(array('typename' => 'status_1'));
        $totals['status0'] = $this->order->getTotalsCount(array('typename' => 'status0'));
        $totals['status1'] = $this->order->getTotalsCount(array('typename' => 'status1'));
        $totals['status2'] = $this->order->getTotalsCount(array('typename' => 'status2'));
        $totals['status3'] = $this->order->getTotalsCount(array('typename' => 'status3'));
        $totals['status4'] = $this->order->getTotalsCount(array('typename' => 'status4'));
        $totals['status5'] = $this->order->getTotalsCount(array('typename' => 'status5'));
        dd($totals);
    }

    public function ajaxorder()
    {
        $order0 = $this->orderdata(0);
        $order1 = $this->orderdata(1);
        $order7 = $this->orderdata(7);
        $order30 = $this->orderdata(30);
        $order7['price'] = $order7['price'] + $order0['price'];
        $order7['count'] = $order7['count'] + $order0['count'];
        $order7['avg'] = (empty($order7['count']) ? 0 : round($order7['price'] / $order7['count'], 1));
        $order30['price'] = $order30['price'] + $order0['price'];
        $order30['count'] = $order30['count'] + $order0['count'];
        $order30['avg'] = (empty($order30['count']) ? 0 : round($order30['price'] / $order30['count'], 1));
        return array('order0' => $order0, 'order1' => $order1, 'order7' => $order7, 'order30' => $order30);
    }

    protected function orderdata($day)
    {
        $day = (int)$day;
        $orderPrice = $this->order->getOrderPrice($day);
        $orderPrice['avg'] = (empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 1));
        unset($orderPrice['fetchall']);
        return $orderPrice;
    }

    protected function selectTransaction($pdo_fetchall, $days = 7)
    {
        $transaction = array();
        $days = (int)$days;
        if (!empty($pdo_fetchall)) {
            $i = $days;
            while (1 <= $i) {
                $transaction['price'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                $transaction['count'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                --$i;
            }
            foreach ($pdo_fetchall as $key => $value) {
                if (array_key_exists(date('Y-m-d', $value['createtime']), $transaction['price'])) {
                    $transaction['price'][date('Y-m-d', $value['createtime'])] += $value['price'];
                    $transaction['count'][date('Y-m-d', $value['createtime'])] += 1;
                }
            }
            return $transaction;
        }
        return array();
    }

    public function ajaxtransaction()
    {
        $orderPrice = $this->order->getOrderPrice(7);;
        $transaction = $this->selectTransaction($orderPrice['fetchall'], 7);
        if (empty($transaction)) {
            $i = 7;
            while (1 <= $i) {
                $transaction['price'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                $transaction['count'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                --$i;
            }
        }
        return json_encode(array('price_key' => array_keys($transaction['price']), 'price_value' => array_values($transaction['price']), 'count_value' => array_values($transaction['count'])));
    }
}
