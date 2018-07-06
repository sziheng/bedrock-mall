<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Models\Good;
use Bedrock\Models\Category;
use Bedrock\Models\Address;
use Bedrock\Models\MemberLevel;
use Bedrock\Models\VirtualType;
use Bedrock\Models\Dispatch;
use Bedrock\Models\Company;
use Bedrock\Models\SpecItem;
use Bedrock\Models\Option;
use Bedrock\Models\CommissionLevel;
use Bedrock\Services\GoodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Bedrock\Http\Controllers\Controller;



class GoodController extends BaseController
{
    protected $good;
    protected $category;
    protected $address;
    protected $memberLevel;
    protected $virtualType;
    protected $request;
    protected $dispatcch;
    protected $company;
    protected $specitem;
    protected $commissionLevel;
    protected $option;

    /**
     * GoodController constructor.
     * @param ood $good
     * @param Category $category
     * @param Address $address
     * @param MemberLevel $memberLevel
     * @param VirtualType $virtualType
     * @param Request $request
     */
    public function __construct(
        Good $good,
        Category $category,
        Address $address,
        MemberLevel $memberLevel,
        VirtualType $virtualType,
        Request $request,
        Dispatch $dispatch,
        Company $company,
        SpecItem $specitem,
        CommissionLevel $commissionLevel,
        Option $option
    ){
        $this->good            = $good;
        $this->category        = $category;
        $this->address         = $address;
        $this->memberLevel     = $memberLevel;
        $this->virtualType     = $virtualType;
        $this->request         = $request;
        $this->dispatcch       = $dispatch;
        $this->company         = $company;
        $this->specitem        = $specitem;
        $this->commissionLevel = $commissionLevel;
        $this->option          = $option;
        parent::__construct();
    }

    /**
     * Create by szh
     * @param Request $request
     */
    public function index(Request $request, Category $category)
    {
        $condition = $request->status;
        $cate = intval($request->cate);
        $keyword = trim($request->keyword);
        $sql = $this->good::leftJoin('ims_weshop_merch_user', function ($join) {
            $join->on('ims_weshop_merch_user.id', '=','ims_weshop_goods.merchid')->on('ims_weshop_merch_user.uniacid','=','ims_weshop_goods.uniacid');
        })
            ->leftJoin('ims_weshop_goods_option as op', function ($join) {
                $join->on('ims_weshop_goods.id', '=','op.goodsid');
            })
            ->select('ims_weshop_goods.*');

        if ($request->province) {
            $address=array(0=>$request->province, 1=>$request->city, 2=>$request->area);
            $provinces =  $data = $this->address->select('Add_Code','Add_Name')->whereIn('Add_Code', $address)->get();
            $provinces = $provinces->toArray();
            //dd($provinces);
            $citys =  $data = $this->address->select('Add_Code','Add_Name')->where('Add_Parent', '=', $request->province)->get();
            $areas =  $data = $this->address->select('Add_Code','Add_Name')->where('Add_Parent', '=', $request->city)->get();
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
                        ->orWhere('ims_weshop_goods.goodssn','like','%'.$keyword.'%')
                        ->orWhere('ims_weshop_goods.productsn','like','%'.$keyword.'%')
                        ->orWhere('op.title','like','%'.$keyword.'%')
                        ->orWhere('op.goodssn','like','%'.$keyword.'%')
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
        //获取全部一级分类
        // 获取已执行的查询数组
        $categorys=$this->category->list();
        return view('admin.good.index', compact('goods', 'categorys', 'request', 'provinces', 'citys', 'areas'));
    }


    /**
     * Create by szh
     * 选择地址
     *
     */
    public function chooseAddress()
    {
        $pcode = $this->request->pcode ? $this->request->pcode : 0;
        $data = $this->address->where('Add_Parent', '=', $pcode)->get()->toArray();
        exit(json_encode($data));
    }

    /**
     * Create by szh
     * 上下架
     *
     */
    public function changeStatus()
    {
        if ($this->request->id){
            if (!is_array($this->request->id)) {
                $id = array($this->request->id);
            } else {
                $id = $this->request->id;
            }
            $result = Good::whereIn('id', $id)->update(array('status'=>$this->request->params));
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }


    /**
     * Create by szh
     * 商品审核
     *
     */
    public function checked()
    {
        if ($this->request->id){
            $id = is_array($this->request->id) ? $this->request->id : [$this->request->id];
            $result = $this->good->whereIn('id', $id)->update(['checked'=>$this->request->params]);
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }

    /**
     * Create by szh
     * 商品删除
     */
    public function delete()
    {
        if ($this->request->id){
            if (!is_array($this->request->id)) {
                $id = array($this->request->id);
            } else {
                $id = $this->request->id;
            }
            $result = Good::whereIn('id', $id)->update(array('deleted'=>$this->request->params));
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }

    /**
     * Create by szh
     * 商品彻底删除
     */
    public function physicsDelete()
    {
        if ($this->request->id){
            if (!is_array($this->request->id)) {
                $id = array($this->request->id);
            } else {
                $id = $this->request->id;
            }
            $result = Good::whereIn('id', $id)->delete();
            return $result ? ['error' => 0] : ['error' => 1, 'msg' => '失败',];
        } else {
            return ['error' => 1, 'msg' => 'id不存在',];
        }
    }

    /**
     * 商品新增页面
     * Create by szh
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //暂时这么处理 下礼拜找解决方法
        $goods= Good::limit(1)->get()->toArray();
        foreach($goods[0] as $key => &$val){
            $good[$key] = '';
        }
        $discounts = ['type' => ''];
        $good['discounts'] = $discounts;
        $good['piclist'] = [];
        $good['category'] = [];
        $data = $this->rendorData($good);
        $categorys = $data['categorys'];
        $levels = $data['levels'];
        $commissionLevels = $data['commissionLevels'];
        $address = $data['address'];
        $virtualTypes = $data['virtualTypes'];
        $dispatchs = $data['dispatchs'];
        $companyies = $data['companyies'];
        $shopset_level = $data['shopset_level'];
        $specs = [];
        $html['html'] = '';
        $params = [];
        return view('admin.good.create', compact('good','categorys', 'levels', 'areas', 'virtualTypes', 'dispatchs', 'companyies', 'params', 'specs', 'commissionLevels' ,'shopset_level','html', 'address', 'discounts'));
    }
    /**
     * Create by szh
     * @param Good $good
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Good $good, GoodService $goodService)
    {
        //获取商品参数
        $objectgood = $good;
        $params = $good->param()->get()->toArray();
        //商品规格
        $specs = $good->spec()->get();
        foreach($specs as $key => &$val){
            $val['items'] = $this->specitem
                ->leftJoin('ims_weshop_virtual_type as vt', function($join){
                    $join->on('ims_weshop_goods_spec_item.virtual', '=' , 'vt.id');
                })
                ->select('ims_weshop_goods_spec_item.*', 'vt.title as title1')
                ->where('ims_weshop_goods_spec_item.specid',$val->id)
                ->get()
                ->toArray();
        }
        unset($val);
        $specs = $specs->toArray();
        $good = $good->toArray();
        $good['noticetype'] = explode(',', $good['noticetype']);
        if ($good['cates']) {
            $good['category'] = is_array(explode(',', $good['cates'])) ? explode(',', $good['cates']) : [];
        } else {
            $good['category'] = [];
        }
        $good['discounts'] = json_decode($good['discounts'], true);
        if ($good['thumb'])
        {
            $good['piclist'] = array_merge([$good['thumb']],$this->iunserializer($good['thumb_url']));
        }
        $good['province'] = $this->address->getName($good['sheng']) ? $this->address->getName($good['sheng'])->toArray() : '';
        $good['city'] = $this->address->getName($good['shi']) ? $this->address->getName($good['shi'])->toArray() : '';
        $good['area'] = $this->address->getName($good['qu']) ?$this->address->getName($good['qu'])->toArray() :'';

        $data = $this->rendorData($good);
        $categorys = $data['categorys'];
        $levels = $data['levels'];
        $commissionLevels = $data['commissionLevels'];
        $address = $data['address'];
        $virtualTypes = $data['virtualTypes'];
        $dispatchs = $data['dispatchs'];
        $companyies = $data['companyies'];
        $shopset_level = $data['shopset_level'];
        //商品规格
        $options =$objectgood->option()->get()->toArray();
        $html = $goodService->combinationHtml($options, $levels, $commissionLevels, $good, $specs);
        return view('admin.good.create', compact('good','categorys', 'levels', 'areas', 'virtualTypes', 'dispatchs', 'companyies', 'params', 'specs', 'commissionLevels' ,'shopset_level','html', 'address'));
    }



    /**
     * 新增/修改 商品公用数据
     * Create by szh
     */
    public function rendorData($good)
    {
        $data['categorys'] = $this->category->list()->toArray();
        //会员等级
        $levels = $this->memberLevel->list()->toArray();
        foreach ($levels as &$val)
        {
            $val['key'] = 'level' . $val['id'];
        }
        unset($val);
        $data['levels'] = array_merge( [['id' => 0, 'key' => 'default', 'levelname' => '默认会员']], $levels);

        //授权等级
        $commissionLevels = $this->commissionLevel->list()->toArray();
        foreach ($commissionLevels as &$val)
        {
            $val['key'] = 'level' . $val['id'];
        }
        unset($val);
        $data['commissionLevels'] = [['key' => 'default', 'levelname' => '默认等级']];
        //获取地址
        $data['address'] = $this->address->expressAddress();

        $merchid = $good['merchid'] ? $good['merchid'] : 0;
        //获取虚拟商品规格
        $data['virtualTypes'] = $this->virtualType->getList($merchid);
        //运费模板列表
        $data['dispatchs'] =$this->dispatcch->getList($merchid);
        //推荐单位
        $data['companyies'] = $this->company->getList();
        $data['shopset_level'] = 0;
        return $data;
    }

    /**
     * Create by szh
     * 添加参数
     * @param Request $request
     * .
     * @return tpl
     */
    public function addParams(Request $request)
    {
        switch ($this->request->tpl) {
            case 'option':

                return view('admin.good.tpl.spec');
                break;
            case 'spec':
                $spec =['id' => random(32), 'title' => '', 'items' => []];
                return view('admin.good.tpl.spec',compact('spec'));
                break;

            case 'specitem':
                $specitem =[];
                $good = $this->good->find($this->request->goodid);
                $good = $good ? $good->toArray():[];
                $spec = ['id' => $this->request->specid];
                $specitem = ['id' => random(32), 'title' => '', 'show' =>1];
                return view('admin.good.tpl.spec_item',compact('spec', 'specitem', 'good','specitem'));
                break;

            case 'param':
                return view('admin.good.tpl.param');
                break;

            default:
                break;
        }
    }


    public function store(GoodService $goodService,Request $request)
    {
        $result = $goodService->createData($request);
        if( $result ){
            return \redirect('web/good/'.$result.'/edit')->with('success','操作成功');
        }else{
            return back()->with('error', '操作失败');
        }

    }

    public function iunserializer($value) {
        if (empty($value)) {
            return '';
        }
        if (!$this->is_serialized($value)) {
            return $value;
        }
        $result = unserialize($value);
        if ($result === false) {
            $temp = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value);
            return unserialize($temp);
        }
        return $result;
    }

    public function is_serialized($data, $strict = true) {
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        if ($strict) {
            $lastc = substr($data, -1);
            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');
            if (false === $semicolon && false === $brace)
                return false;
            if (false !== $semicolon && $semicolon < 3)
                return false;
            if (false !== $brace && $brace < 4)
                return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's' :
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
            case 'a' :
            case 'O' :
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b' :
            case 'i' :
            case 'd' :
                $end = $strict ? '$' : '';
                return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }
        return false;
    }



}

