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
        $condition = $request->status;
        $cate = intval($request->cate);
        $keyword = trim($request->keyword);
        DB::enableQueryLog();
        $sql = Good::leftJoin('merch_user', function ($join) {
                $join->on('merch_user.id', '=','goods.merchid')->orOn('merch_user.uniacid','=','goods.uniacid');
            })
            ->leftJoin('goods_option as op', function ($join) {
                $join->on('goods.id', '=','op.goodsid');
            })
            ->select('goods.*');

        if ($request->province) {
            $address=array(0=>$request->province, 1=>$request->city, 2=>$request->area);
            $provinces =  $data = DB::table('address')->select('Add_Code','Add_Name')->whereIn('Add_Code', $address)->get();
            $provinces = $provinces->toArray();
            $citys =  $data = DB::table('address')->select('Add_Code','Add_Name')->where('Add_Parent', '=', $request->province)->get();
            $areas =  $data = DB::table('address')->select('Add_Code','Add_Name')->where('Add_Parent', '=', $request->city)->get();
            $sql = $sql
                ->where(function($query) use($request)
                {
                    $query->where('goods.sheng','=',$request->province)
                          ->where('goods.shi','=',$request->city)
                          ->where('goods.qu','=',$request->area);
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
                    $query->where('goods.id','=',$keyword)
                        ->orWhere('goods.title','like','%'.$keyword.'%')
                        ->orWhere('goods.goodssn','like','%'.$keyword.'%')
                        ->orWhere('goods.productsn','like','%'.$keyword.'%')
                        ->orWhere('op.title','like','%'.$keyword.'%')
                        ->orWhere('op.goodssn','like','%'.$keyword.'%')
                        ->orWhere('op.productsn','like','%'.$keyword.'%')
                        ->orWhere('merch_user.merchname','like','%'.$keyword.'%');
                });
        }
        switch ($request->status) {
            case 'sale':
                //出售中
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('goods.status','=','1')
                            ->where('goods.checked','=',"0")
                            ->where('goods.total','>',"0")
                            ->where('goods.deleted','=',"0");
                    });
                break;

            case 'out':
                //已售罄
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('goods.total','<=',"0")
                            ->where('goods.deleted','=',"0");
                    });
                break;
            case 'stock':
                //仓库中
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('goods.status','=',"0")
                            ->orWhere('goods.checked','=',"1")
                            ->where('goods.deleted','=','0');
                    });
                break;
            case 'cycle':
                //回收站
                $sql = $sql
                    ->where(function($query) use($condition)
                    {
                        $query->where('goods.deleted','=',"1");
                    });
                break;
            default:
                break;
        }

        $goods = $sql->groupBy('goods.id')
                     ->orderBy('goods.displayorder','desc')
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
        $queries = DB::getQueryLog();

        $categorys=$category->list();
        return view('admin.good.index', compact('goods', 'categorys', 'request', 'provinces', 'citys', 'areas'));
    }


    /**
     * Create by szh
     * 选择地址
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



