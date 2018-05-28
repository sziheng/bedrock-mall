<?php
namespace Bedrock\Http\Controllers\Web;

use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.order.index');
    }

    /**
     * 全部订单
     */
    public function list()
    {
        return view('admin.order.list');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function status0()
    {
        return view('admin.order.list');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function status1()
    {
        return view('admin.order.list');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function status2()
    {
        return view('admin.order.list');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View\
     */
    public  function status3()
    {
        return view('admin.order.list');
    }

    /**
     * 已关闭订单
     */
    public function closed()
    {

    }
    public function status4()
    {

    }
    /**
     * 自定义导出功能
     */
    public  function  export()
    {

    }

    /**
     * 批量发货
     */
    public function batchsend()
    {

    }

    /**
     * Ajax获取订单概述数据
     */
    public  function  orderSummary()
    {

    }

    /**根据天数获取订单数据
     * @param $day
     * @return mixed
     */
    protected function order($day)
    {
        $day = (int) $day;
        $orderPrice = $this->selectOrderPrice($day);
        $orderPrice['avg'] = (empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 1));
        unset($orderPrice['fetchall']);
        return $orderPrice;
    }


}