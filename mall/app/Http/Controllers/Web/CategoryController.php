<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Category;
use Illuminate\Http\Request;

/**
 * Class GoodController
 * @package App\Admin\Controllers
 */

class CategoryController extends BaseController
{
    /**
     * todo 方法注释信息不全
     * TODO 建议所有控制器里对外暴露的方法统一加上 get 或者 post 作为前缀
     * Create by szh
     * 分类列表
     */
    public function index()
    {
        //todo 一些查询条件没有加入，uniacid，enabled
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
        //todo 该方法实现很不优雅
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
            $params['advimg'] = '/storage/'. $path;
        }
        $post = Category::create($params);
        return redirect('/category');
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Category $category)
    {
        $category->delete();

        return redirect('/category');
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
     * todo
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
            $category->advimg = '/storage/'. $path;
        }
        $category->save();
        //渲染 todo 无意义的注释，建议去掉
        return redirect("/category");
    }

    /**
     * Create by szh
     * @param Category $category
     * @param Request  $request
     * @return array
     * todo 该方法名不够达意，建议更换，不要延续之前表的命名规范，那是个坑
     */
    public function ishome(Category $category, Request $request)
    {
        $category->ishome = request('ishome');
        $category->enabled = request('ishome');
        $result           = $category->save();

        return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
    }
}
