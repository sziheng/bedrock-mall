<?php

namespace Bedrock\Models;

/**
 * Class PoorUser
 *
 * @package \Bedrock\Models
 */
class PoorUser extends BaseModel
{
    protected $table = 'ims_weshop_poor_user';

    protected $timestraps = false;

    /**
     * 获取建档立卡户的户数和人数
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return array
     */
    public function countFamilyAndPeople()
    {
        $allFamilyNum = self::count();
        $allPeopleNum = self::sum('family_number');

        return ['allFamilyNum' => $allFamilyNum, 'allPeopleNum' => $allPeopleNum];
    }
}
