<?php

namespace Bedrock\Models;

/**
 * Class MerchUserCategory
 *
 * @package \Bedrock\Models
 */
class MerchUserCategory extends BaseModel
{
    protected $table = 'ims_weshop_merch_category';

    public $timestamps = false;

    /**
     * 通过分类名字获取指定的分类
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @param $name
     * @return mixed
     */
    public static function getCategoryByCateName($name)
    {
        return self::where('catename', $name)->first();
    }

}
