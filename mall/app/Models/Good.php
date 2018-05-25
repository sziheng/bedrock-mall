<?php

namespace Bedrock\Models;


class Good extends Model
{
    //禁止 create_at 与 update_at;
    public $timestamps = false;

    public function categories()
    {
        return $this->belongsTo('Bedrock\Models\Category', 'pcate');
    }

    public function merchUser()
    {
        return $this->belongsTo('Bedrock\Models\MerchUser', 'merchid');

    }
}
