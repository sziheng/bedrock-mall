<?php

namespace Bedrock\Services;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Bedrock\Models\Activity;
use Bedrock\Models\Activitysn;
use Bedrock\Models\Order;
use Bedrock\Models\Cryptographiclibrary;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use \Exception;


/**
 * Class UserService
 *
 * @package \Bedrock\Services
 */
class ActivityService
{

    protected $storerole = [
        'activityname'   => 'required|min:1|max:50',  //必填 字符串
        'total'          => 'required|integer|between:0,9999', //必填 数字 最大9999
        'facevalue'      => 'required|integer|between:0,9999', //必填 数字 最大9999
        'starttime'        => 'required', //必填
        'endtime'        => 'required', //必填
    ];
    protected $updaterole = [
        'activityname'   => 'required|min:1|max:50',  //必填 字符串
        'total'          => 'required|integer|between:0,9999', //必填 数字 最大9999
        'facevalue'      => 'required|integer|between:0,9999', //必填 数字 最大9999
        'starttime'        => 'required', //必填
        'endtime'        => 'required', //必填
    ];


    protected $activity;

    protected $order;

    protected $activitysn;
    /**
     * 创建商品数据
     * GoodService constructor.
     * @param Good $good
     */
    public function __construct(Activity $activity, Order $order, Activitysn $activitysn)
    {
        $this->activity = $activity;
        $this->order  = $order;
        $this->activitysn = $activitysn;
    }


    public function getCardlist($request)
    {
        $sql = $this->activitysn::leftJoin('ims_weshop_activity as a', function ($join) {
            $join->on('a.id', '=','ims_weshop_activity_sn.activityid');
        })->select(['ims_weshop_activity_sn.*', 'a.activityname', 'a.isdisable']);

        $sql = $sql
            ->where(function($query) use($request)
            {
                $query->where('ims_weshop_activity_sn.isdelete', 0);
            });

        $sql = $sql->when($request->cardId, function($query) use ($request){
            $query->where('ims_weshop_activity_sn.activityid',$request->cardId);
        });

        if ($request->status != -1 && $request->status) {
            if ($request->status == 2) {
                $sql = $sql
                    ->where(function($query) use($request)
                    {
                        $query->where('ims_weshop_activity_sn.status', 2)->orWhere('a.isdisable',1);
                    });
            } else {
                $sql = $sql
                    ->where(function($query) use($request)
                    {
                        $query->where('ims_weshop_activity_sn.status', $request->status);
                    });
            }
        }
        $sql = $sql->when($request->keyword, function($query) use ($request){
            $query->where('ims_weshop_activity_sn.ticketsn', 'like', '%' . $request->keyword . '%');
        });

        $cardList = $sql->paginate(10);
        $page = isset($page)?$request['page']: 1;
        $appendData = $cardList->appends(array(
            'starttime' => $request->cardId,
            'endtime' => $request->keyword,
            'keyword' => $request->status
        ));
        $order = 1+ (($page)-1) * 10;
        foreach($cardList as $k => &$v){
            $v->order = $order++;
            if($v->isdisable == 1 && $v->status == 0){
                //活动禁用 则卡号也禁用
                $v->status=2;
            }
            if ($v->realname || $v->nickname) {
                $v->changer = $v->changer;
            }
            $v->orderlist = isset($v->orderlist) ? json_decode($v->orderlist, true): [];
        }
        unset($v);
        return $cardList;
    }

    /**
     * 新增和编辑活动
     * Create by szh
     * @param $request
     * @return array|bool
     */
    public function createData($request)
    {
        try{

            $activityInfo = $this->activity->find($request->id);
            $error = [];
            if (!$activityInfo) {
                $oldTotal = 0;
                $activityInfo = $this->activity;
                $request->validate($this->storerole);
            } else {
                $oldTotal = $activityInfo->total;
                $request->validate($this->updaterole);
            }
           if (count($request->goodsid) != count(array_unique($request->goodsid))) {
               $error['msg']   = '请不要选择重复商品';
               return $error;
           }
           $goodsData = [];
            foreach ($request->goodsid as $key=>$value){
                if ($value==0) {
                    $error['msg']   = '请选择商品';
                    return $error;
                } else {
                    $goods['id']=$value;
                    $goods['count']=($request->goodscount)[$key];
                }
                if(empty(($request->goodscount)[$key]) ||  ($request->goodscount)[$key]<0 )
                {
                    $error['msg']   = '添加的商品，商品数量不准确';
                    return $error;
                }
                $goodsData['goods'][]=$goods;
            }
            $content['data'] = $goodsData;
            $activityInfo->activityname = $request->activityname;
            $activityInfo->total = $request->total;
            $activityInfo->facevalue = $request->facevalue;
            $activityInfo->starttime = strtotime($request->starttime);
            $activityInfo->endtime = strtotime($request->endtime);
            $activityInfo->content = json_encode($content);
            $activityInfo->alreadyusecount =0;
            $activityInfo->isdisable = 0;
            $activityInfo->isdelete = 0;
            $activityInfo->createtime=time();
            $activityInfo->save();
            if ($activityInfo->id) {
                $result = $this->createActivitySn($activityInfo,$oldTotal);
                if (!$result['msg']){
                    return true;
                } else {
                    $error['msg'] = $result['msg'];
                }
            } else{
                $error['msg']  ='活动创建失败';
            }
            return $error;
        }catch (Exception $e){
            $error['msg'] = $e->getMessage();
            return $error;
        }
    }



    public function  createActivitySn($activityInfo, $oldTotal = 0)
    {
        $activitysnData = [];
        $error = [];
        if ($oldTotal < $activityInfo->total) {
            $libraryInfos = Cryptographiclibrary::paginate($activityInfo->total-$oldTotal);
            $libraryInfos = $libraryInfos ? $libraryInfos->toArray() : [];
            if($libraryInfos['total']<$activityInfo->total){
                $activityInfo->where('id',$activityInfo->id)->delete();
                $error['msg'] = '备用卡号不足，请重新输入发卡数量';
            }
            foreach ($libraryInfos['data'] as $key => $val) {
                $activitysnData[] = [
                    'activityid' => $activityInfo->id,
                    'ticketsn' => $activityInfo->facevalue.substr($val['Code'],0,8),
                    'password' => substr($val['Code'],-4),
                    'status' => 0,
                    'isdelete' => 0,
                    'createtime' => time(),
                ];
                $libraryIds[] = $val['id'];
            }
            $result = $this->activitysn->insert($activitysnData);
            if($libraryIds){
                Cryptographiclibrary::whereIn('id',$libraryIds)->delete();
            }
        } else {
            $count = $oldTotal - $activityInfo->total;
            if ($count >0){
                $result = $this->activitysn->where('activityid',$activityInfo->id)->where('isdelete',0)->limit($count)->orderBy('id', 'Desc')->update(['isdelete' => 1]);
            }
        }
        if(isset($result) || !$error){
            return true;
        } else {
            $error['msg']='新增活动失败';
            return $error;
        }
    }
}
