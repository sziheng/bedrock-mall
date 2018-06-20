<?php

namespace Bedrock\Services;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Bedrock\Models\Member;
use Bedrock\Models\Spec;
use Bedrock\Models\Option;
use Bedrock\Models\Param;
use Bedrock\Models\SpecItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 *
 * @package \Bedrock\Services
 */
class MemberService
{

    /**
     * @var
     */
    protected $member;

    protected $spec;

    protected $specitem;

    protected $option;

    protected $keepSpecitemId = [];
    /**
     * 创建商品数据
     * GoodService constructor.
     * @param Good $good
     */
    public function __construct(Member $member, Spec $spec, SpecItem $specitem, Option $option,Param $param)
    {
        $this->member = $member;
        $this->spec = $spec;
        $this->specitem = $specitem;
        $this->option = $option;
        $this->param = $param;
    }


    public function getList($request)
    {
        $sql = $this->member::leftJoin('ims_weshop_member_group as mg', function ($join) {
                $join->on('ims_weshop_member.groupid', '=','mg.id');
             })
            ->leftJoin('ims_weshop_member_level as lv', function ($join) {
                $join->on('ims_weshop_member.level', '=','lv.id');
            })
            ->leftJoin('ims_mc_mapping_fans as fan', function ($join) {
                $join->on('ims_weshop_member.openid', '=','fan.openid');
            })
            ->select(['ims_weshop_member.*', 'mg.groupname']);

        if ($request->mid) {
            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->where('ims_weshop_member.id','=',$request->mid);
                });
        }
        if ($request->keyword) {
            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->where('ims_weshop_member.realname','like', '%'.$request->keyword.'%')
                        ->orWhere('ims_weshop_member.mobile','like','%'.$request->keyword.'%')
                        ->orWhere('ims_weshop_member.id','like','%'.$request->keyword.'%');
                });
        }
        $members = $sql->orderBy('ims_weshop_member.id','desc')
            ->paginate(10);
        $page = isset($page)?$request['page']: 1;
        $appendData = $members->appends(array(
            'status' => $request->status,
            'cate' => $request->cate,
            'keyword' => $request->keyword,
            'province' => $request->province,
            'city' => $request->city,
            'area' => $request->area,
            'page' => $page,
        ));
        foreach($members as &$val){
            $val['levelname'] = isset($val['levelname']) ? $val['levelname'] : '普通会员';
        }
        unset($val);
        return $members;

    }





}
