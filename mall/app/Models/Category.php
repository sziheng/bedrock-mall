<?php

namespace Bedrock\Models;

class Category extends BaseModel
{
    protected $table = "ims_weshop_category";

    //禁止 create_at 与 update_at;
    public $timestamps = false;

    public function list()
    {
        return $this->where('level', '=', '1')->get();
    }
}
