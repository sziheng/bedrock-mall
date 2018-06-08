<?php

namespace Bedrock\Models;

/**
 * Class Spec
 *
 * @package \Bedrock\Models
 */
class Spec extends BaseModel
{
    protected $table = 'ims_weshop_goods_spec';

    public $timestamps = false;

    /**
     * Create by szh
     */
    public function virtualType()
    {
        //return self::hasMany('Bedrock\Models\VirtualType', 'goodsid')->orderBy('displayorder', 'asc');
    }

}
