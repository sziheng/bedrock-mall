<?php

namespace Bedrock\Models;


class Member extends Model
{
    protected $table = 'ims_weshop_member';

    public $timestamps = false;

    public function list()
    {
        return $this->where('uniacid', '=', UNIACID)->orderBy('level', 'desc')->get();
    }

}
