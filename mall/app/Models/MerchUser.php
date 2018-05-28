<?php

namespace Bedrock\Models;


class MerchUser extends Model
{
    protected $table = "ims_weshop_merch_user";

    public $timestamps = false;


    /**
     * 统计所有的供应商数量
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function countMerchUsers()
    {
        return self::where('uniacid', 65)->where('status', 1)->count();
    }


}
