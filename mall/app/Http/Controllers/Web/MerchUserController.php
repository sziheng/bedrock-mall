<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\MerchUser;
use Illuminate\Http\Request;


/**
 * Class MerchUserController
 *
 * @package \Bedrock\Http\Controllers\Web
 */
class MerchUserController extends BaseController
{
    /**
     * @var $merchUser
     */
    protected $merchUser;

    /**
     * MerchUserController constructor.
     * @param MerchUser $merchUser
     */
    public function __construct(MerchUser $merchUser)
    {
        $this->merchUser = $merchUser;

        parent::__construct();
    }

    /**
     * 获取供应商列表
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request)
    {
        $allMerchUsers = $this->merchUser->getAllMerchUsers();

        return view('admin.merch_user.index', ['merchUsers' => $allMerchUsers]);
    }

    public function getCreate()
    {
        return view();
    }

    public function postCreate(Request $request)
    {
        $input = $request->only('');
    }

    public function getEdit()
    {
        //todo 获取供应商修改页
    }

    public function postEdit()
    {
        //todo 修改供应商
    }

    public function postDelete()
    {
        //todo 删除供应商
    }

}
