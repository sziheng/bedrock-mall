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

    /**
     * 获取所有的供应商
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function getAllMerchUsers()
    {
        return self::where('uniacid', 65)->get();
    }

    /**
     * 通过 id 获取指定供应商
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param $id
     * @return mixed
     */
    public function getMerchUser($id)
    {
        return self::where('uniacid', 65)->where('id', $id)->first();
    }


}
