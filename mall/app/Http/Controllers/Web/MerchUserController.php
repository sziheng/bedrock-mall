<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Address;
use Bedrock\Models\MerchUser;
use Bedrock\Models\MerchUserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $allMerchUsers = $this->merchUser->getAllMerchUsers();


        return view('admin.merch_user.index', ['merchUsers' => $allMerchUsers]);
    }

    /**
     * 创建供应商页面
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        return view('admin.merch_user.create');
    }

    /**
     * 添加供应商数据
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param Request $request
     * @return string
     */
    public function postCreate(Request $request)
    {
        $input = $request->only('merchname', 'salecate', 'province', 'city', 'area', 'realname', 'mobile', 'desc', 'status');

        $message   = [
            'merchname.required' => '供应商名称必填',
            'salecate.required'  => '供应商经营范围必填',
            'province.required'  => '供应商所属省份必填',
            'city.required'      => '供应商名所属市必填',
            'area.required'      => '供应商名所属县必填',
            'realname.required'  => '联系人姓名必填',
            'mobile.required'    => '联系人电话必填',
            'status.required'    => '供应商状态必填',
            'mobile.numeric'     => '联系电话必须为数字',
        ];
        $validator = Validator::make($input, [
            'merchname' => 'required',
            'salecate'  => 'required',
            'province'  => 'required',
            'city'      => 'required',
            'area'      => 'required',
            'realname'  => 'required',
            'mobile'    => 'required|numeric',
            'status'    => 'required|boolean',
        ], $message);
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }

        try {
            $address = Address::getName($input['area']);

            $category = MerchUserCategory::getCategoryByCateName($address['Add_Name']);
            if (!$category) {
                $category = new MerchUserCategory();
                $category->uniacid = 65;
                $category->catename = $address['Add_Name'];
                $category->createtime = time();
                $category->status = 1;
                $category->save();
            }

            $merchUser = new MerchUser();
            $merchUser->uniacid = 65;
            $merchUser->merchname = $input['merchname'];
            $merchUser->regid = 0;
            $merchUser->groupid = 10;
            $merchUser->salecate = $input['salecate'];
            $merchUser->desc = isset($input['desc']) && $input['desc'] ? $input['desc'] : '';
            $merchUser->realname = $input['realname'];
            $merchUser->mobile = $input['mobile'];
            $merchUser->status = $input['status'];
            $merchUser->jointime = time();
            $merchUser->cateid = $category->id;
            $merchUser->province = $input['province'];
            $merchUser->city = $input['city'];
            $merchUser->area = $input['area'];
            $merchUser->save();

        } catch (\Exception $e) {
            Log::error('供应商创建失败');
            return self::parametersIllegal($e->getMessage());
        }

        return redirect(route('webMerchUserIndex'))->with('供应商添加成功!');

    }

    /**
     * 获取供应商编辑页
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param $merchUserId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($merchUserId)
    {
        $merchUserId = (int) $merchUserId;

        $merchUser = $this->merchUser->getMerchUser($merchUserId);
        if (!$merchUser) {
            return redirect()->back()->with('error', '供应商不存在');
        }

        return view('admin.merch_user.edit', ['merchUser' => $merchUser]);
    }

    /**
     * 修改供应商
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param         $merchUserId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function postEdit($merchUserId, Request $request)
    {
        $merchUserId = (int) $merchUserId;

        $merchUser = $this->merchUser->getMerchUser($merchUserId);
        if (!$merchUser) {
            return redirect()->back()->with('error', '供应商不存在');
        }

        $input = $request->only('merchname', 'salecate', 'province', 'city', 'area', 'realname', 'mobile', 'desc', 'status');
        $message   = [
            'merchname.required' => '供应商名称必填',
            'salecate.required'  => '供应商经营范围必填',
            'province.required'  => '供应商所属省份必填',
            'city.required'      => '供应商名所属市必填',
            'area.required'      => '供应商名所属县必填',
            'realname.required'  => '联系人姓名必填',
            'mobile.required'    => '联系人电话必填',
            'status.required'    => '供应商状态必填',
            'mobile.numeric'     => '联系电话必须为数字',
        ];
        $validator = Validator::make($input, [
            'merchname' => 'required',
            'salecate'  => 'required',
            'province'  => 'required',
            'city'      => 'required',
            'area'      => 'required',
            'realname'  => 'required',
            'mobile'    => 'required|numeric',
            'status'    => 'required|boolean',
        ], $message);
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }

        try {
            $address = Address::getName($input['area']);

            $category = MerchUserCategory::getCategoryByCateName($address['Add_Name']);
            if (!$category) {
                $category = new MerchUserCategory();
                $category->uniacid = 65;
                $category->catename = $address['Add_Name'];
                $category->createtime = time();
                $category->status = 1;
                $category->save();
            }

            $merchUser->uniacid = 65;
            $merchUser->merchname = $input['merchname'];
            $merchUser->regid = 0;
            $merchUser->groupid = 10;
            $merchUser->salecate = $input['salecate'];
            $merchUser->desc = isset($input['desc']) && $input['desc'] ? $input['desc'] : '';
            $merchUser->realname = $input['realname'];
            $merchUser->mobile = $input['mobile'];
            $merchUser->status = $input['status'];
            $merchUser->jointime = time();
            $merchUser->cateid = $category->id;
            $merchUser->province = $input['province'];
            $merchUser->city = $input['city'];
            $merchUser->area = $input['area'];
            $merchUser->save();

        } catch (\Exception $e) {
            Log::error('供应商编辑失败,请稍候重试!');
            return self::parametersIllegal($e->getMessage());
        }

        return redirect(route('webMerchUserIndex'))->with('供应商编辑成功!');
    }

    /**
     * 供应商删除操作
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param $merchUserId
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function postDelete($merchUserId)
    {
        $merchUserId = (int)$merchUserId;

        $merchUser = $this->merchUser->getMerchUser($merchUserId);
        if (!$merchUser) {
            return self::resourceNotFound('该供应商不存在');
        }

        $merchUser->delete();

        return redirect()->back()->with('success', '已删除供应商');
    }

}
