<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Company;
use Bedrock\Models\Fan;
use Bedrock\Models\Good;
use Bedrock\Models\MerchUser;
use Bedrock\Models\Order;
use Bedrock\Models\PoorUser;


/**
 * Class IndexController
 *
 * @package \Bedrock\Http\Controllers\Web
 */
class IndexController extends BaseController
{
    protected $order;
    protected $good;
    protected $company;
    protected $fan;
    protected $merchUser;
    protected $poorUser;

    /**
     * IndexController constructor.
     * @param Order     $order
     * @param Company   $company
     * @param Fan       $fan
     * @param Good      $good
     * @param MerchUser $merchUser
     * @param PoorUser  $poorUser
     */
    public function __construct(Order $order, Company $company, Fan $fan, Good $good, MerchUser $merchUser, PoorUser $poorUser)
    {
        $this->order     = $order;
        $this->company   = $company;
        $this->fan       = $fan;
        $this->good      = $good;
        $this->merchUser = $merchUser;
        $this->poorUser  = $poorUser;

        parent::__construct();
    }

    /**
     * 首页页面展示数据
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {

        $allOrdersAmount = $this->order->sumAllAmount();

        $allCompaiesAmount = $this->company->sumCompanyAmount();

        $allFansNum = $this->fan->countAllFans();

        $allOrdersNum = $this->order->getOrderNum();

        $allGoodsNum = $this->good->countGoods();

        $allMerchUsers = $this->merchUser->countMerchUsers();

        $allPoorFamilierAndPeople = $this->poorUser->countFamilyAndPeople();


        return view('admin.home.index', [
            'allAmount'                => $allOrdersAmount + $allCompaiesAmount,
            'allOrdersAmount'          => $allOrdersAmount,
            'allPoorFamilierAndPeople' => $allPoorFamilierAndPeople,
            'allCompaiesAmount'        => $allCompaiesAmount,
            'allMerchUsers'            => $allMerchUsers,
            'allFansNum'               => $allFansNum,
            'allOrdersNum'             => $allOrdersNum,
            'allGoodsNum'              => $allGoodsNum
        ]);













        //- 扶贫商品比例按照地区划分
        //- 扶贫商品比例，按照地区划分
        //- 建档立卡户显示


    }

}
