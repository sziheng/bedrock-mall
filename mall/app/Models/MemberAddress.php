<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/5/30
 * Time: 11:11
 */

namespace Bedrock\Models;


class MemberAddress extends BaseModel
{
    protected $table = 'ims_weshop_member_address';
    public $timestamps = false;

    public function  getMemberAddress($addressid)
    {
        return  self::where(['uniacid' => UNIACID,'id'=>$addressid])->first();
    }

    public function getmemberaddresslist($addressid)
    {
        return self::where('uniacid', UNIACID)->whereIn('id',$addressid)->get(['id','realname','mobile','province','city','area','address'])->toArray();
    }
}