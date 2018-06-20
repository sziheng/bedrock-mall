<?php

namespace Bedrock\Models;

/**
 * Class User
 *
 * @package \Bedrock\Models
 */
class User extends BaseModel
{
    protected $table = 'ims_weshop_member';


    public function getmemberlist($openid)
    {
        return self::where('uniacid', UNIACID)->whereIn('openid',$openid)->get(['id','openid','nickname','realname','mobile'])->toArray();
    }

}
