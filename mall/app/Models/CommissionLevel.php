<?php

namespace Bedrock\Models;


class CommissionLevel extends Model
{
    protected $table = 'ims_weshop_commission_level';

    public $timestamps = false;

    public function list()
    {
        return $this->where('uniacid', '=', UNIACID)->orderBy('commission1', 'asc')->get();
    }

}
