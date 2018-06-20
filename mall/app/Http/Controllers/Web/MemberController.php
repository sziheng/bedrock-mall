<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\MemberLevel;
use Bedrock\Models\Member;

use Bedrock\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Bedrock\Http\Controllers\Controller;
use PhpParser\Node\Expr\UnaryMinus;


class MemberController extends BaseController
{

    protected $memberLevel;
    protected $request;


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
        MemberLevel $memberLevel,
        Member  $member,
        Request $request,
        MemberService $memberService
    ){
        $this->memberLevel     = $memberLevel;
        $this->member          = $member;
        $this->request         = $request;
        $this->memberService   = $memberService;
        parent::__construct();
    }

    /**
     * Create by szh
     */
    public function index(Request $request,Member $member)
    {
        return view('admin.member.index', compact('member'));
    }


    public function getList(Request $request)
    {
        $members = $this->memberService->getList($request);
        return view('admin.member.list', compact('members'));
    }

    /**
     * Create by szh
     */
    public function getMemberInfos()
    {
        return json_encode(['ajaxmembergender' => $this->getMemberByGender(), 'ajaxmemberlevel' => $this->getMemberByLevel(), 'ajaxprovince' => $this->getMemberByProvince(), 'ajaxnewmember0' => $this->getNewMemberByTime(0), 'ajaxnewmember1' => $this->getNewMemberByTime(1), 'ajaxnewmember7' => $this->getNewMemberByTime(7)]);
    }

    /**
     * 按照性别统计数据
     * Create by szh
     */
    public function getMemberByGender()
    {
        $memberGender = $this->member->where('uniacid', UNIACID)->groupBy('gender')->get([  \DB::raw('count(gender) as genderNum'),'gender']);
        if ($memberGender) {
            $memberGender = $memberGender->toArray();
            $genderArray = [0,0,0];
            foreach($memberGender as $key => $val) {
                if ($val['gender'] == -1)
                {
                    $genderArray[0] += (int) $val['genderNum'];
                }
                else
                {
                    $genderArray[$val['gender']] += (int) $val['genderNum'];
                }
            }
        }
        return $genderArray;
    }

    public function getMemberByLevel()
    {
        $levels = $this->memberLevel->list();
        if (isset($levels)) {
            $levelname = [];
            foreach($levels as $key => $val){
                $levelname[] = $val['levelname'];
            }
            array_unshift($levelname, '普通等级');

            $memberLevel = $this->member->where('uniacid', UNIACID)->groupBy('level')->get([  \DB::raw('count(level) as levelNum'),'level']);
            if (isset($memberLevel)){
                $memberLevel = $memberLevel->toArray();
                $levels_array = [];
                foreach ($levelname as $lkey => $lvalue )
                {
                    $levels_array[$lkey] = 0;
                }
                foreach ($memberLevel as $key => $val )
                {
                    if (array_key_exists($val['level'], $levelname))
                    {
                        $levels_array[$val['level']] = $val['levelNum'];
                    }
                    else
                    {
                        $levels_array[0] += $val['levelNum'];
                    }
                }
                if (!array_key_exists(0, $levels_array))
                {
                    $levels_array[0] = 0;
                }
                $count = array_values($levels_array);
                $name = array_values($levelname);
                $res = [];
                foreach ($count as $key => $value )
                {
                    $res[$key]['value'] = $value;
                    $res[$key]['name'] = $name[$key];
                }
                return ['count' => $count, 'name' => $name, 'data' => $res];
            }
           return false;
        }
    }

    public function getMemberByProvince()
    {
        $memberProvince = $this->member->where('uniacid', UNIACID)->groupBy('province')->get([  \DB::raw('count(province) as provinceMum'),'province']);
        $result = [];
        foreach($memberProvince as $key => $val) {
            $val['province'] = preg_replace('/(市|省)(.*)/', '', $val['province']);
            $res = array('name' => $val['province'], 'value' => (int) $val['provinceMum']);
            $result[] = $res;
        }
        return $result;
    }

    public function getNewMemberByTime($day = 0)
    {
        $day = $day;
        $memberCount = $this->member->where('uniacid', UNIACID)->get([\DB::raw('count(*) as count')]);
        if (isset($memberCount)) {
            $memberCount = ($memberCount->toArray())[0]['count'];
        }
        $appendMember = $this->member->getappendMemberByTime($day);
        $appendMember = $appendMember[0]['count'];
        $proportion = isset($memberCount) ? intval(number_format(round($appendMember / $memberCount, 3) * 100)) : 0;
        return ['count' => intval($appendMember), 'rate' => isset($memberCount) ? $proportion : 0];
    }



}
