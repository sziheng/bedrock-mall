<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/6/7
 * Time: 17:07
 */

namespace Bedrock\Http\Controllers\Web\Order;


use Bedrock\Services\OrderService;
use Bedrock\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;

/**订单列表模型
 * Class ListController
 * @package Bedrock\Http\Controllers\Web\Order
 */
class ListController extends BaseController
{
    protected $order;

    public function __construct(OrderService $order)
    {
        $this->order = $order;
        parent::__construct();
    }

    /**
     * 全部订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $typename='全部订单';
        $customurl='/order/list';
        $request->paytype='';
        $request->keyword='';
        $paytypelist=$this->order->getpaytypeList();
        $searchtimelist=$this->order->getsearchtimeList();
        $searchfieldlsit=$this->order->getsearchfieldLsit();
        $page = isset($page)?$request['page']: 1;
        $list=$this->order->getSeniorOrderList($request);
        if (empty($request->starttime) || empty($request->endtime))
        {
            $request->starttime = date("Y-m-d H:i",strtotime('-1 month'));
            $request->endtime = date("Y-m-d H:i",time());
        }

//print_r($list);
      return view('admin.order.list',compact('typename','request','customurl','paytypelist','searchtimelist','searchfieldlsit','list'));
    }

    /**待发货订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staydelivery(Request $request)
    {
        $typename='待发货订单';
        $customurl='/order/staydelivery';
        $request->status=1;
        $request->paytype='';
        $request->keyword='';
        $list=array();
        $paytypelist=$this->order->getpaytypeList();
        $searchtimelist=$this->order->getsearchtimeList();
        $searchfieldlsit=$this->order->getsearchfieldLsit();
        $page = isset($page)?$request['page']: 1;
        return view('admin.order.list',compact('typename','request','customurl','paytypelist','searchtimelist','searchfieldlsit','list'));
    }

    /**待收货订单页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staytakedelivery(Request $request)
    {
        $typename='待收货订单';
        $customurl='/order/staytakedelivery';
        $request->status=2;
        $request->paytype='';
        $request->keyword='';
        $list=array();
        $paytypelist=$this->order->getpaytypeList();
        $searchtimelist=$this->order->getsearchtimeList();
        $searchfieldlsit=$this->order->getsearchfieldLsit();
        $page = isset($page)?$request['page']: 1;
        return view('admin.order.list',compact('typename','request','customurl','paytypelist','searchtimelist','searchfieldlsit','list'));
    }

    /**待付款订单页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staypayment(Request $request)
    {
        $typename='待付款订单';
        $customurl='/order/staypayment';
        $request->status=0;
        $request->paytype='';
        $request->keyword='';
        $list=array();
        $paytypelist=$this->order->getpaytypeList();
        $searchtimelist=$this->order->getsearchtimeList();
        $searchfieldlsit=$this->order->getsearchfieldLsit();
        $page = isset($page)?$request['page']: 1;
        return view('admin.order.list',compact('typename','request','customurl','paytypelist','searchtimelist','searchfieldlsit','list'));
    }

    /**已完成订单页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderfinish(Request $request)
    {
        $typename='已完成订单';
        $customurl='/order/orderfinish';
        $request->status=0;
        $request->paytype='';
        $request->keyword='';
        $list=array();
        $paytypelist=$this->order->getpaytypeList();
        $searchtimelist=$this->order->getsearchtimeList();
        $searchfieldlsit=$this->order->getsearchfieldLsit();
        $page = isset($page)?$request['page']: 1;
        return view('admin.order.list',compact('typename','request','customurl','paytypelist','searchtimelist','searchfieldlsit','list'));
    }

    /**已关闭订单页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderclose(Request $request)
    {
        $typename='已关闭订单';
        $customurl='/order/orderclose';
        $request->status=0;
        $request->paytype='';
        $request->keyword='';
        $list=array();
        $paytypelist=$this->order->getpaytypeList();
        $searchtimelist=$this->order->getsearchtimeList();
        $searchfieldlsit=$this->order->getsearchfieldLsit();
        $page = isset($page)?$request['page']: 1;
        return view('admin.order.list',compact('typename','request','customurl','paytypelist','searchtimelist','searchfieldlsit','list'));
    }

}