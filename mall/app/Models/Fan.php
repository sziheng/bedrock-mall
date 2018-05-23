<?php

namespace Bedrock\Models;

/**
 * Class Fan
 *
 * @package \Bedrock\Models
 */
class Fan extends BaseModel
{
    protected $table = 'ims_mc_mapping_fans';

    protected $primaryKey = 'fanid';

    protected $timestraps = false;

    /**
     * 统计关注人数
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function countAllFans()
    {
        return self::count();
    }

}
