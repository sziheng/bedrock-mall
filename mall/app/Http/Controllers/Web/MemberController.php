<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Good;
use Bedrock\Models\Category;
use Bedrock\Models\Address;
use Bedrock\Models\MemberLevel;
use Bedrock\Models\VirtualType;
use Bedrock\Models\Dispatch;
use Bedrock\Models\Company;
use Bedrock\Models\SpecItem;
use Bedrock\Models\Option;
use Bedrock\Models\CommissionLevel;
use Bedrock\Services\GoodService;
use Bedrock\Services\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Bedrock\Http\Controllers\Controller;



class MemberController extends BaseController
{
    protected $good;
    protected $category;
    protected $address;
    protected $memberLevel;
    protected $virtualType;
    protected $request;
    protected $dispatcch;
    protected $company;
    protected $specitem;
    protected $commissionLevel;
    protected $option;

    /**
     * GoodController constructor.
     * @param ood $good
     * @param Category $category
     * @param Address $address
     * @param MemberLevel $memberLevel
     * @param VirtualType $virtualType
     * @param Request $request
     */
    public function __construct(
        Good $good,
        Category $category,
        Address $address,
        MemberLevel $memberLevel,
        VirtualType $virtualType,
        Request $request,
        Dispatch $dispatch,
        Company $company,
        SpecItem $specitem,
        CommissionLevel $commissionLevel,
        Option $option
    ){
        $this->good            = $good;
        $this->category        = $category;
        $this->address         = $address;
        $this->memberLevel     = $memberLevel;
        $this->virtualType     = $virtualType;
        $this->request         = $request;
        $this->dispatcch       = $dispatch;
        $this->company         = $company;
        $this->specitem        = $specitem;
        $this->commissionLevel = $commissionLevel;
        $this->option          = $option;
        parent::__construct();
    }

    /**
     * Create by szh
     */
    public function index(Request $request, Member $member)
    {
        return view('admin.merch_user.index', compact('member'));
    }


}
