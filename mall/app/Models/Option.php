<?php

namespace Bedrock\Models;

class Option extends BaseModel
{
    protected $table = "ims_weshop_goods_option";

    //禁止 create_at 与 update_at;
    public $timestamps = false;

}
