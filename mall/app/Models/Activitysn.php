<?php

namespace Bedrock\Models;

use Bedrock\Models\McMember;

class Activitysn extends BaseModel
{
    protected $table = 'ims_weshop_activity_sn';

    protected $guarded=[];

    public $timestamps = false;


    /**
     * 获取卡号所关联的活动
     * Create by szh
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo('Bedrock\Models\Activity', 'activityid');
    }

}
