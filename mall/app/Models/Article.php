<?php

namespace Bedrock\Models;

/**
 * Class Article
 *
 * @package \Bedrock\Models
 */
class Article extends BaseModel
{
    protected $table = 'ims_weshop_acticle';


    /**
     * 获取所有文章的内容和标题
     * @author Xu Jian <xujian.xyz@gmail.com>
     * @return mixed
     */
    public function getAllArticles()
    {
        return self::select('article_title', 'article_content')->get();
    }

}
