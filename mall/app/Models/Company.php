<?php

namespace Bedrock\Models;

/**
 * Class Company
 *
 * @package \Bedrock\Models
 */
class Company extends BaseModel
{
    protected $table = 'ims_weshop_company';

    /**
     * 获取公司充值总额
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function sumCompanyAmount()
    {
        return self::sum('amount');
    }

    /**
     * 获取公司充值列表
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function getCompanies()
    {
        return self::where('amount', '>', 0)->orderBy('amount', 'desc')->get();
    }

}
