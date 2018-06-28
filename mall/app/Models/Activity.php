<?php

namespace Bedrock\Models;

use Bedrock\Models\McMember;

class Activity extends BaseModel
{
    protected $table = 'ims_weshop_activity';

    protected $guarded=[];

    public $timestamps = false;

    public function list()
    {
        return $this->where('uniacid', '=', UNIACID)->orderBy('level', 'desc')->get();
    }


    public function Activitysn()
    {
        return self::hasMany('Bedrock\Models\Activitysn', 'activityid','id');
    }







}
