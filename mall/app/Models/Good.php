<?php

namespace Bedrock\Models;


class Good extends Model
{
    protected $table = 'ims_shop_goods';

    protected $timestamps = false;

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

}
