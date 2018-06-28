<?php

namespace Bedrock\Services;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Bedrock\Models\Member;
use Bedrock\Models\Spec;
use Bedrock\Models\Option;
use Bedrock\Models\Param;
use Bedrock\Models\Order;
use Bedrock\Models\SpecItem;
use Bedrock\Models\McMember;
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

    protected $mcmember;

    protected $order;
    /**
     * 创建商品数据
     * GoodService constructor.
     * @param Good $good
     */
    public function __construct(Member $member, Spec $spec, SpecItem $specitem, Option $option,Param $param, McMember $mcmember, Order $order)
    {
        $this->member = $member;
        $this->spec = $spec;
        $this->specitem = $specitem;
        $this->option = $option;
        $this->param = $param;
        $this->mcmember = $mcmember;
        $this->order  = $order;
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
            ->select(['ims_weshop_member.*', 'mg.groupname', 'fan.follow as followed']);

            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->where('ims_weshop_member.uniacid', UNIACID);
                });

        if ($request->starttime && $request->endtime) {
            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->whereBetween('ims_weshop_member.createtime', [strtotime($request->starttime), strtotime($request->endtime)]);
                });
        }

        if (isset($request->followed))
        {
            if ($request->followed == 2)
            {
                $sql = $sql
                    ->where(function($query) use($request)
                    {
                        $query->where('fan.follow',0)->where('ims_weshop_member.uid','<>' , 0);
                    });
            }
            else
            {
                $sql = $sql
                    ->where(function($query) use($request)
                    {
                        $query->where('fan.follow',$request->followed);
                    });
            }
        }

        if ($request->keyword) {
            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->where('ims_weshop_member.realname','like', '%'.$request->keyword.'%')
                        ->orWhere('ims_weshop_member.mobile','like','%'.$request->keyword.'%')
                        ->orWhere('ims_weshop_member.id','like','%'.$request->keyword.'%')
                        ->orWhere('ims_weshop_member.nickname','like','%'.$request->keyword.'%');
                });
        }
        $members = $sql->orderBy('ims_weshop_member.id','desc')
            ->paginate(10);
        $page = isset($page)?$request['page']: 1;
        $appendData = $members->appends(array(
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'keyword' => $request->keyword,
            'followed' => $request->followed
        ));
        if ($members) {
            foreach($members as &$val){
                $val->levelname = isset($val->levelname) ? $val->levelname : '普通会员';
                $val->ordercount = $this->order->where('openid',$val->openid)->where('uniacid', UNIACID)->where('status', 3)->count();
                $val->moneycount = $this->order->where('openid',$val->openid)->where('uniacid', UNIACID)->where('status', 3)->sum('goodsprice');
                $val->credit1 = $val->getCredit($val->openid,'credit1');
                $val->credit2 = $val->getCredit($val->openid,'credit2');
            }
            unset($val);
            return $members;
        } else {
            return false;
        }
    }












}
