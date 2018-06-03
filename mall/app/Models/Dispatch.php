<?php
<<<<<<< HEAD

namespace Bedrock\Models;

/**
 * Class User
 *
 * @package \Bedrock\Models
 */
class Dispatch extends BaseModel
{
    protected $table = 'ims_weshop_dispatch';

    public function getList($merchid)
    {
        return  self::where('uniacid', UNIACID)->where('merchid', $merchid)->where('enabled', 1)->orderBy('displayorder', 'desc')->get()->toArray();
    }
}
=======
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/5/30
 * Time: 11:14
 */

namespace Bedrock\Models;


class Dispatch extends BaseModel
{
    protected $table = 'ims_weshop_dispatch';
    public $timestamps = false;
}
>>>>>>> dd0654e5d292875ae94dc90739d95e6d7fee7859
