<?php

namespace Bedrock\Models;

class Param extends BaseModel
{
    protected $table = "ims_weshop_goods_param";

    //禁止 create_at 与 update_at;
    public $timestamps = false;

}
