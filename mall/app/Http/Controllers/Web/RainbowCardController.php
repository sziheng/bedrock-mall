<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Activity;
use Bedrock\Models\Activitysn;
use Bedrock\Models\Good;
use Bedrock\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Bedrock\Http\Controllers\Controller;
use PhpParser\Node\Expr\UnaryMinus;


class RainbowCardController extends BaseController
{

    protected $activity;
    protected $request;


    /**
     * MemberController constructor.
     * @param Request $request
     * @param Activity $activity
     */
    public function __construct(
        Request $request,
        Activity $activity,
        Good    $good
    ){
        $this->activity     = $activity;
        $this->request      = $request;
        $this->good         = $good;
        parent::__construct();
    }

    /**
     * 活动列表
     * Create by szh
     */
    public function getActivityList()
    {
        $activities = Activity::where('isdelete',0)->orderBy('id','desc')->paginate(10);
        return view('admin.rainbowCard.activityList', compact('activities'));
    }


    public function create(Activity $activity)
    {
        if ($activity->starttime < time()){
            $activity->overtime = '1';
        }
        $goodsContent = json_decode($activity->content,true);
        if(array_get($goodsContent['data'],'goods', '') !=''){
           $activity->goodsContent = $goodsContent['data']['goods'];
        } else {
            $activity->goodsContent = [];
        }
        $goodslist = Good::where('deleted', 0)->where('status', 1)->where('checked', 0)->where('uniacid', UNIACID)->get(['id', 'title']);
        return view('admin.rainbowCard.activityCreate', compact('activity', 'goodslist'));
    }

    /**
     * 活动的开启与关闭
     * Create by szh
     * @param Request $request
     * @return array
     */
    public function changeIsdisable(Request $request)
    {
        //查询活动状态
        try{
            $activityinfo = Activity::where('isdelete', 0)->find($request->id);
            if ($activityinfo) {
                $activityinfo->isdisable = $request->params;
                $activityinfo->text = $request->text;
                $result = $activityinfo->save();
                return $result ? ['error' => 0] : ['error' => 1, 'msg' => '操作成功',];
            } else {
                return ['error' => 1, 'msg' => '该活动不存在或已被删除，您不能执行当前操作',];
            }
        }catch (Exception $e){
            return ['error' => 1, 'msg' => $e->getMessage(),];
        }
    }

    /**
     * 活动的新增与修改
     * Create by szh
     * @param ActivityService $activityService
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activityStore(ActivityService $activityService, Request $request)
    {
        $result = $activityService->createData($request);
        if (isset($result['msg'])) {
            return back()->with('error', $result['msg']);
        }else{
            return redirect('/web/rainbowCard/getActivityList')->with('success', '操作成功');
        }

    }

    /**
     * 彩虹卡列表
     * Create by szh
     * @param ActivityService $activityService
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCardList(ActivityService $activityService, Request $request)
    {
        $cardList = $activityService->getCardList($request);
        $activities = Activity::where('isdelete',0)->orderBy('id','desc')->get();

        return view('admin.rainbowCard.cardList', compact('cardList', 'activities','request'));

    }

    /**
     * 彩虹卡的关闭与开启
     * Create by szh
     * @param Request $request
     */
    public function changeDidable(Request $request)
    {
        //查询活动状态
        try{
            $activitysninfo = Activitysn::where('isdelete', 0)->find($request->id);
            if ($activitysninfo) {
                $activityinfo = Activity::where('isdelete', 0)->find($activitysninfo->activityid);
                if (!$activityinfo) {
                    return ['error' => 1, 'msg' => '该卡号所属的活动不存在或已被删除，您不能执行当前操作',];
                }
                if ($activityinfo->isdisable==1){
                    return ['error' => 1, 'msg' => '该卡号所属的活动已被关闭，您不能执行当前操作',];
                }
                if($activitysninfo->status == 1){
                    return ['error' => 1, 'msg' => '该卡号已被使用，您不能执行当前操作',];
                }
                $activitysninfo->status = $request->params;
                $result = $activitysninfo->save();
                return $result ? ['error' => 0] : ['error' => 1, 'msg' => '操作成功',];
            } else {
                return ['error' => 1, 'msg' => '该卡号不存在或已被删除，您不能执行当前操作',];
            }
        }catch (Exception $e){
            return ['error' => 1, 'msg' => $e->getMessage(),];
        }
    }





}
