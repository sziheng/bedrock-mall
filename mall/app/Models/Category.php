<?php

namespace Bedrock\Models;

use Bedrock\Models\Model;

class Category extends Model
{
    protected $table         = "category";

    //禁止 create_at 与 update_at;
    public $timestamps = false;
}
