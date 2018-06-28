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

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
        parent::__construct();
    }

    /**
     * Create by szh
     * 分类列表
     */
    public function index()
    {
        $categorys=Category::where('uniacid', UNIACID)->where('level',1)->orderBy('displayorder','desc')->paginate(10);

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
            'name' => 'required|max:255|min:1',
        ]);
        $result =$this->createData($request);
        if ($result) {
            return redirect("/web/category")->with('succescc','操作成功');
        } else {
            return back()->with('error', $result['失败']);
        }
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Category $category)
    {
        try{
            $result = $category->delete();
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } catch (Exception $e){
            return  ['error' => 1, 'msg' => '失败',];
        }
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        if (!isset($category)) {
            $category = $this->category;
        }
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Create by szh
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * todo
     */
    public function update(Request $request)
    {
        //验证
        $this->validate(request(), [
            'name' => 'required|max:255|min:1',
        ]);
        $result =$this->createData($request);
        if ($result) {
            return redirect("/web/category")->with('succescc','操作成功');
        } else {
            return back()->with('error', $result['失败']);
        }
    }

    public function createData($request)
    {
        try{
            $categoryInfo = $this->category->find($request->id);
            if (!$categoryInfo) {
                $categoryInfo = $this->category;
            }
            $categoryInfo->displayorder = $request->displayorder;
            $categoryInfo->name = $request->name;
            $categoryInfo->description = $request->description;
            $categoryInfo->ishome = ($request->ishome == 'on') ? 1 : 0;
            $categoryInfo->advurl = $request->advurl;
            $categoryInfo->uniacid = UNIACID;
            $categoryInfo->level = 1;
            //图片上传
            if ($request->file('thumb')){
                $path = $request->file("thumb")->storePublicly(date('Y-m-d',time()));
                $categoryInfo->thumb = '/storage/'. $path;
                $categoryInfo->advimg = '/storage/'. $path;
            }
            $categoryInfo->save();
            return $categoryInfo->id ? true: false;
        } catch (Exception $e){
            return false;
        }

    }

    /**
     * Create by szh
     * @param Category $category
     * @param Request  $request
     * @return array
     */
    public function ishome(Category $category, Request $request)
    {
        $category->ishome = request('ishome');
        $category->enabled = request('ishome');
        $result           = $category->save();

        return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
    }
}
