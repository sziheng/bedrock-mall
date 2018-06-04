<?php

namespace Bedrock\Models;

/**
 * Class VirtualType
 *
 * @package \Bedrock\Models
 */
class VirtualType extends BaseModel
{
    protected $table = 'ims_weshop_virtual_type';

    public function getList($merchid)
    {
       return  self::where('uniacid', '=', UNIACID)->where('merchid', '=', $merchid)->orderBy('id', 'asc')->get()->toArray();
    }
}
