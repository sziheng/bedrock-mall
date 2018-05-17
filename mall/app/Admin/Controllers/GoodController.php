<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * Class GoodController
 * @package App\Admin\Controllers
 */

class GoodController extends Controller
{
    /**
     * Create by szh
     * 商品列表
     */
    public function index()
    {

    }

    public function category()
    {
        $categorys=Category::paginate(10);

        return view('admin.good.category', compact('categorys'));
    }
}
