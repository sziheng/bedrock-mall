<?php

namespace Bedrock\Models;


class Good extends Model
{
    protected $table = 'ims_weshop_goods';

    public $timestamps = false;

    /**
     * 获取商品分类
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo('Bedrock\Models\Category', 'pcate');
    }

    /**
     * 获取供应商
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchUser()
    {
        return $this->belongsTo('Bedrock\Models\MerchUser', 'merchid');
    }

    /**
     * 获取省份
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne('Bedrock\Models\Address', 'Add_Code', 'sheng');
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

    /**
     * 获取商品参数
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function param()
    {
        return $this->hasMany('Bedrock\Models\Param', 'goodsid')->orderBy('displayorder', 'asc');
    }


    /**
     * 获取商品规格
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function option()
    {
        return $this->hasMany('Bedrock\Models\Option', 'goodsid')->orderBy('id', 'asc');
    }

    /**
     * 获取商品规格
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spec()
    {
        return self::hasMany('Bedrock\Models\Spec', 'goodsid')->orderBy('displayorder', 'asc');
    }

}
