<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/6/7
 * Time: 17:05
 */

namespace Bedrock\Http\Controllers\Web\Order;


use Bedrock\Services\OrderService;
use Bedrock\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;


/**订单概述页
 * Class SummaryController
 * @package Bedrock\Http\Controllers\Web\Order
 */
class SummaryController extends BaseController
{
    protected $order;

    public function __construct(OrderService $order)
    {

        $this->order = $order;
        parent::__construct();
    }

    public function index()
    {
        return view('admin.order.index');
    }
    public function ajaxgettotals()
    {
        return $this->order->ajaxgettotals();
    }
    public function ajaxorder()
    {
        return $this->order->ajaxorder();
    }
    public function ajaxtransaction()
    {
        return $this->order->ajaxtransaction();
    }
}