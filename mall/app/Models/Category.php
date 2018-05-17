<?php

namespace Bedrock\Models;

class Category extends Model
{
    protected $table = "category";

    //禁止 create_at 与 update_at;
    public $timestamps = false;
}
