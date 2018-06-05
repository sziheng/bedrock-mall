<?php
namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Order;
use Bedrock\Models\OrderGoods;
use Bedrock\Models\Good;

class OrderController extends BaseController
{
    protected $order;
    protected $ordergoods;
    protected $goods;

    public function __construct(Order $order,OrderGoods $ordergoods,Good $goods) {
        $this->order     = $order;
        $this->ordergoods     = $ordergoods;
        $this->goods     = $goods;
        parent::__construct();
    }
    public function index()
    {
        return view('admin.order.index');
    }
    public function  status0()
    {
        $typename="全部订单";
        $this->order->hasManyOrderGoods(array('typename'=>'all'));
        return view('admin.order.list',compact('typename'));
    }
    /**
     * 获取
     */
    public function ajaxgettotals()
    {
        $totals['all']=$this->order->getTotalsCount(array('typename'=>'all'));
        $totals['status_1']=$this->order->getTotalsCount(array('typename'=>'status_1'));
        $totals['status0']=$this->order->getTotalsCount(array('typename'=>'status0'));
        $totals['status1']=$this->order->getTotalsCount(array('typename'=>'status1'));
        $totals['status2']=$this->order->getTotalsCount(array('typename'=>'status2'));
        $totals['status3']=$this->order->getTotalsCount(array('typename'=>'status3'));
        $totals['status4']=$this->order->getTotalsCount(array('typename'=>'status4'));
        $totals['status5']=$this->order->getTotalsCount(array('typename'=>'status5'));
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
        return  array('order0' => $order0, 'order1' => $order1, 'order7' => $order7, 'order30' => $order30);
    }

    protected function orderdata($day)
    {
        $day = (int) $day;
        $orderPrice = $this->order->getOrderPrice($day);
        $orderPrice['avg'] = (empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 1));
        unset($orderPrice['fetchall']);
        return $orderPrice;
    }

    protected function selectTransaction($pdo_fetchall, $days = 7)
    {
        $transaction = array();
        $days = (int) $days;
        if (!empty($pdo_fetchall))
        {
            $i = $days;
            while (1 <= $i)
            {
                $transaction['price'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                $transaction['count'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                --$i;
            }
            foreach ($pdo_fetchall as $key => $value )
            {
                if (array_key_exists(date('Y-m-d', $value['createtime']), $transaction['price']))
                {
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
        if (empty($transaction))
        {
            $i = 7;
            while (1 <= $i)
            {
                $transaction['price'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                $transaction['count'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                --$i;
            }
        }
        return json_encode(array('price_key' => array_keys($transaction['price']), 'price_value' => array_values($transaction['price']), 'count_value' => array_values($transaction['count'])));
    }
}
