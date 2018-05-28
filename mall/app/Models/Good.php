<?php

namespace Bedrock\Models;


class Good extends Model
{
    protected $table = 'ims_weshop_goods';

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsTo('Bedrock\Models\Category', 'pcate');
    }

    public function merchUser()
    {
        return $this->belongsTo('Bedrock\Models\MerchUser', 'merchid');
    }

    public function address()
    {
        return $this->hasOne('Bedrock\Modes\Address', 'Add_Code', 'sheng');
    }

    /**
     * 获取平台商品数量
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function countGoods()
    {
        return self::where('uniacid', 65)->where('status', 1)->where('isshow', 1)->where('deleted', 0)->count();
    }

}
