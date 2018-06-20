<?php

namespace Bedrock\Models;

/**
 * Class Address
 *
 * @package \Bedrock\Models
 */
class Address extends BaseModel
{
    protected $table = 'ims_weshop_address';

    protected $primaryKey = 'Add_Code';

    /**
     * Create by szh
     * 快递范围
     */
    public function expressAddress()
    {
        $address= self::where('Add_Level', '<=', '2' )->get()->toArray();
        foreach($address as $key => $val){
            $addresses[$val['Add_Code']][]=$val;
        }
    }


    public static function getName($id)
    {
        return self::find($id, ['Add_Name'])->toArray();
    }
}
