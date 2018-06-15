<?php

namespace Bedrock\Models;

/**
 * Class User
 *
 * @package \Bedrock\Models
 */
class Dispatch extends BaseModel
{
    protected $table = 'ims_weshop_dispatch';

    public function getList($merchid)
    {
        return  self::where('uniacid', UNIACID)->where('merchid', $merchid)->where('enabled', 1)->orderBy('displayorder', 'desc')->get()->toArray();
    }

    public function getdispatchlist($dispatchid)
    {
        return self::where('uniacid', UNIACID)->whereIn('id',$dispatchid)->get(['id','dispatchname'])->toArray();
    }
}

