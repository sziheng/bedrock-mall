<?php

namespace Bedrock\Models;

use Bedrock\Models\McMember;

class Member extends Model
{
    protected $table = 'ims_weshop_member';

    public $timestamps = false;

    public function list()
    {
        return $this->where('uniacid', '=', UNIACID)->orderBy('level', 'desc')->get();
    }


    /**
     * Create by szh
     * @param int $day
     * @return bool
     */
    public function getappendMemberByTime($day = 0)
    {
        $range = strtotime(\Carbon\Carbon::now()->subDays($day));
        $range = strtotime(date('Y/m/d', $range));
        $result = self::where('createtime', '>=', $range)
            ->get([
                \DB::raw('COUNT(*) as count')
            ]);
        if (isset($result)) {
            $result = $result->toArray();
        }
        return $result;
    }


    public function getCredit($openid, $credittype = 'credit1')
    {
        $uid = $this->getUid($openid);
        if (!empty($uid))
        {
            $credit = McMember::select($credittype)->where('uid',$uid['uid'])->first();
            return $credit ? $credit->$credittype : 0;
        }
        $credit = $this->weshopMember->select($credittype)->where('openid',$openid)->where('uniacid', UNIACID)->first();
        return $credit ? $credit->$credittype : 0;
    }

    /**
     * Create by szh
     * @param $openid
     * @return bool
     */
    protected function getUid($openid)
    {
        if (is_numeric($openid)) {
            return $openid;
        }
        if (is_string($openid)) {
            $uid = $this->MappingFans->select('uid')->where('openid', $openid)->where('uniacid', UNIACID)->first();
            if ($uid) {
                $uid = $uid->toArray();
                return $uid;
            } else {
                return false;
            }
        }
        return false;
    }

    public function MappingFans()
    {
       return self::hasOne('Bedrock\Models\MappingFans', 'openid','openid');
    }

/*    public function Mcmember()
    {
        return self::hasOne('Bedrock\Models\MappingFans', 'openid','openid');

    }*/

    public function weshopMember()
    {
        return self::hasOne('Bedrock\Models\WeshopMember', 'openid','openid');

    }


    public function order()
    {
        return self::hasMany('Bedrock\Models\Order', 'openid','openid');

    }



}
