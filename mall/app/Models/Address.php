<?php

namespace Bedrock\Models;

use Illuminate\Support\Facades\DB;

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
        return $this->getTree($address, 0);
    }


    public static function getName($id)
    {
        return self::find($id, ['Add_Name']);
    }

    private function getTree($address, $pid){
        $tree = [];
        foreach($address as $key => $val){
            if($val['Add_Parent'] == $pid){
                $val['child'] = $this->getTree($address, $val['Add_Code']);
                $tree[] = $val;
            }
        }
        return $tree;
    }
}
