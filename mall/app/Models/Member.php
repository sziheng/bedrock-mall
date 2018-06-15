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


    /**
     * Create by szh
     * @param int $day
     * @return bool
     */
    public function getappendMemberByTime($day = 0)
    {
        $range =strtotime(\Carbon\Carbon::now()->subDays($day));
        $range = strtotime(date('Y/m/d',$range));
        $result = self::where('createtime', '>=', $range)
            ->get([
                \DB::raw('COUNT(*) as count')
            ]);
        if (isset($result)) {
            $result = $result->toArray();
        }
        return $result;
    }

}
