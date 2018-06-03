<?php

namespace Bedrock\Models;


class MemberLevel extends Model
{
    protected $table = 'ims_weshop_member_level';

    public $timestamps = false;

    public function list()
    {
        return $this->where('uniacid', '=', UNIACID)->orderBy('level', 'desc')->get();
    }

}
