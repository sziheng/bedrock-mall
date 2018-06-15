<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/5/30
 * Time: 15:30
 */

namespace Bedrock\Models;


class Saler extends BaseModel
{
    protected $table = 'ims_weshop_saler';

    protected $primaryKey = 'id';

    public function hasOneUser()
    {
        return $this->hasOne('Bedrock\Models\User', 'openid', 'openid');
    }

    public function getsalerlist($verifyopenid)
    {
        $salerlsit=self::with('hasOneUser')->where('uniacid', UNIACID)->whereIn('id',$verifyopenid)->get()->toArray();
        return $salerlsit;
    }

    public function getsalerleftjoinuser($verifyopenid)
    {
        return self::leftjoin('ims_weshop_member','ims_weshop_saler.openid','=','ims_weshop_member.openid')->whereIn('ims_weshop_saler.id',$verifyopenid)->get(['ims_weshop_member.id', 'ims_weshop_member.nickname','ims_weshop_member.openid','ims_weshop_saler.salername'])->toArray();
    }
}