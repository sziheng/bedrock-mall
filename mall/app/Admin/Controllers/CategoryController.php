<?php

namespace App\Admin\Controllers;

use Bedrock\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * Class GoodController
 * @package App\Admin\Controllers
 */

class CategoryController extends Controller
{
    /**
     * Create by szh
     * 分类列表
     */
    public function index()
    {
        $categorys=Category::paginate(10);

        return view('admin.category.index', compact('categorys'));
    }

    /**
     * Create by szh
     * 分类添加页面
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Create by szh
     * 分类添加操作
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|unique:category|max:255|min:1',
        ]);
        $params = array_merge(request(['title', 'content']));

        $params = request(['displayorder', 'name', 'description', 'advurl', 'ishome']);
        if ($params['ishome'] == 'on') {
            $params['ishome'] = '1';
        } else {
            $params['ishome'] = '0';
        }

        //图片上传
        if ($request->file('thumb')){
            $path = $request->file("thumb")->storePublicly(date('Y-m-d',time()));
            $params['thumb'] = '/storage/'. $path;
        }
        $post = Category::create($params);
        return redirect('/admin/category');
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Category $category)
    {
        $category->delete();
        return redirect('/admin/category');
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Category $category, Request $request)
    {
        //验证
        $this->validate(request(), [
            'name' => 'required|max:255|min:1',
        ]);
        $category->displayorder = request('displayorder');
        $category->name = request('name');
        $category->advurl = request('advurl');

        if (request('ishome') == 'on') {
            $category->ishome = 1;
        } else {
            $category->ishome = 0;
        }
        //图片上传
        if ($request->file('thumb')){
            $path = $request->file("thumb")->storePublicly(date('Y-m-d',time()));
            $category->thumb = '/storage/'. $path;
        }
        $category->save();
        //渲染
        return redirect("/admin/category");
    }

    /**
     * Create by szh
     * @param Category $category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function ishome(Category $category, Request $request)
    {
        $category->ishome = request('ishome');
        $result = $category->save();
        if ($result){
            return [
                'error' => 0
            ];
        } else{
            return [
                'error' => 1,
                'msg'   => '失败',
            ];
        }
    }
}
