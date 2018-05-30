<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/5/30
 * Time: 13:55
 */

namespace Bedrock\Models;


class RefundAddress extends BaseModel
{
    protected $table = 'ims_weshop_refund_address';
    public $timestamps = false;

    public function  getRefundAddressData()
    {

    }
}