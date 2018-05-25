<?php

namespace Bedrock\Models;


class MerchUser extends Model
{
    protected $table = "merch_user";

    //禁止 create_at 与 update_at;
    public $timestamps = false;

}
