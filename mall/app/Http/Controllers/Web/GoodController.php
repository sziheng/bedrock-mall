<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Good;
use Bedrock\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bedrock\Http\Controllers\Controller;



class GoodController extends Controller
{

    /**
     * Create by szh
     * @param Request $request
     */
    public function index(Request $request, Category $category)
    {
        //todo 建议所有从 $request 对象中获取参数统一化，
        //todo 不要在控制器中书写 SQL ，该方法太长了，所有方法一律不得超过 50 行
        //todo 这么复杂的逻辑难道不应该放入 Services 中吗？

        $condition = $request->status;
        $cate = intval($request->cate);
        $keyword = trim($request->keyword);
        DB::enableQueryLog();
        $sql = Good::leftJoin('ims_weshop_merch_user', function ($join) {
                $join->on('ims_weshop_merch_user.id', '=','ims_weshop_goods.merchid')->orOn('ims_weshop_merch_user.uniacid','=','ims_weshop_goods.uniacid');
            })
            ->leftJoin('ims_weshop_goods_option as op', function ($join) {
                $join->on('ims_weshop_goods.id', '=','op.goodsid');
            })
            ->select('ims_weshop_goods.*');

        if ($request->province) {
            $address=array(0=>$request->province, 1=>$request->city, 2=>$request->area);
            $provinces =  $data = DB::table('address')->select('Add_Code','Add_Name')->whereIn('Add_Code', $address)->get();
            $provinces = $provinces->toArray();
            $citys =  $data = DB::table('address')->select('Add_Code','Add_Name')->where('Add_Parent', '=', $request->province)->get();
            $areas =  $data = DB::table('address')->select('Add_Code','Add_Name')->where('Add_Parent', '=', $request->city)->get();
            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->where('ims_weshop_goods.sheng','=',$request->province)
                          ->where('ims_weshop_goods.shi','=',$request->city)
                          ->where('ims_weshop_goods.qu','=',$request->area);
                });
        }
       if ($cate) {
            $sql = $sql
                ->where(function($query) use($cate)
                {
                    $query->whereRaw("FIND_IN_SET($cate,cates)");
                });
        }
        if ($keyword) {
            $sql = $sql
                ->where(function($query) use($keyword)
                {
                    $query->where('ims_weshop_goods.id','=',$keyword)
                        ->orWhere('ims_weshop_goods.title','like','%'.$keyword.'%')
                        ->orWhere('ims_weshop_goods.ims_weshop_goodssn','like','%'.$keyword.'%')
                        ->orWhere('ims_weshop_goods.productsn','like','%'.$keyword.'%')
                        ->orWhere('op.title','like','%'.$keyword.'%')
                        ->orWhere('op.ims_weshop_goodssn','like','%'.$keyword.'%')
                        ->orWhere('op.productsn','like','%'.$keyword.'%')
                        ->orWhere('ims_weshop_merch_user.merchname','like','%'.$keyword.'%');
                });
        }
        switch ($request->status) {
            case 'sale':
                //出售中
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('ims_weshop_goods.status','=','1')
                            ->where('ims_weshop_goods.checked','=',"0")
                            ->where('ims_weshop_goods.total','>',"0")
                            ->where('ims_weshop_goods.deleted','=',"0");
                    });
                break;

            case 'out':
                //已售罄
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('ims_weshop_goods.total','<=',"0")
                            ->where('ims_weshop_goods.deleted','=',"0");
                    });
                break;
            case 'stock':
                //仓库中
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('ims_weshop_goods.status','=',"0")
                            ->orWhere('ims_weshop_goods.checked','=',"1")
                            ->where('ims_weshop_goods.deleted','=','0');
                    });
                break;
            case 'cycle':
                //回收站
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('ims_weshop_goods.deleted','=',"1");
                    });
                break;
            default:
                break;
        }

        $goods = $sql->groupBy('ims_weshop_goods.id')
                     ->orderBy('ims_weshop_goods.displayorder','desc')
                     ->paginate(10);
        $page = isset($page)?$request['page']: 1;
        $appendData = $goods->appends(array(
            'status' => $request->status,
            'cate' => $request->cate,
            'keyword' => $request->keyword,
            'province' => $request->province,
            'city' => $request->city,
            'area' => $request->area,
            'page' => $page,
        ));
        $queries = DB::getQueryLog();

        $a = end($queries);

        $tmp = str_replace('?', '"'.'%s'.'"', $a["query"]);

        /*echo vsprintf($tmp, $a['bindings']);

        exit;*/
        //获取全部一级分类
        // 获取已执行的查询数组
        //todo 调试信息为啥不去掉？
        $queries = DB::getQueryLog();

        $categorys=$category->list();
        return view('admin.good.index', compact('goods', 'categorys', 'request', 'provinces', 'citys', 'areas'));
    }


    /**
     * Create by szh
     * 选择地址
     * TODO 同下
     */
    public function address(){
       if (Request()->pcode) {
          $pcode = Request()->pcode;
       } else {
           $pcode = 0;
       }
        $data = DB::table('address')->where('Add_Parent', '=', $pcode)->get();

        exit(json_encode($data));
    }

    /**
     * Create by szh
     * 上下架
     * todo 方法名怎么能用名词呢？方法是动作啊！
     *
     */
    public function status(Request $request)
    {
        if ($request->id){
            if (!is_array($request->id)) {
                $id = array($request->id);
            } else {
                $id = $request->id;
            }
            $result = Good::whereIn('id', $id)->update(array('status'=>$request->params));
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }

    /**
     * Create by szh
     * 商品审核
     * TODO 代码结构化？不美观，不易阅读
     * todo 不要再出现 array() 了，统一使用 【】
     */
    public function checked(Request $request)
    {
        if ($request->id){
            if (!is_array($request->id)) {
                $id = array($request->id);
            } else {
                $id = $request->id;
            }
            $result = Good::whereIn('id', $id)->update(array('checked'=>$request->params));
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }

    /**
     * Create by szh
     * 商品删除
     * TODO 删除商品之前难道在逻辑上不去判断下，商品是否存在，如果不存在，应该提示下用户的
     */
    public function delete(Request $request)
    {
        if ($request->id){
            if (!is_array($request->id)) {
                $id = array($request->id);
            } else {
                $id = $request->id;
            }
            $result = Good::whereIn('id', $id)->update(array('deleted'=>$request->params));
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }

    /**
     * Create by szh
     * 商品彻底删除
     */
    public function physicsDelete(Request $request)
    {
        if ($request->id){
            if (!is_array($request->id)) {
                $id = array($request->id);
            } else {
                $id = $request->id;
            }
            $result = Good::whereIn('id', $id)->delete();
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }
}



