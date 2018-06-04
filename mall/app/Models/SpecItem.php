<?php

namespace Bedrock\Models;

/**
 * Class SpecItem
 *
 * @package \Bedrock\Models
 */
class SpecItem extends BaseModel
{
    protected $table = 'ims_weshop_goods_spec_item';

    public function virtualType($specid)
    {
        //return self::hasMany('Bedrock\Models\Spec', 'goodsid')->orderBy('displayorder', 'asc');
    }

}
