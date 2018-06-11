<?php

namespace Bedrock\Services;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Bedrock\Models\Good;
use Bedrock\Models\Spec;
use Bedrock\Models\Option;
use Bedrock\Models\Param;
use Bedrock\Models\SpecItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 *
 * @package \Bedrock\Services
 */
class GoodService
{

    /**
     * @var
     */
    protected $good;

    protected $spec;

    protected $specitem;

    protected $option;

    protected $keepSpecitemId = [];
    /**
     * 创建商品数据
     * GoodService constructor.
     * @param Good $good
     */
    public function __construct(Good $good, Spec $spec, SpecItem $specitem, Option $option,Param $param)
    {
        $this->good = $good;
        $this->spec = $spec;
        $this->specitem = $specitem;
        $this->option = $option;
        $this->param = $param;
    }
    /**
     * Create by szh
     * @param Good $good
     * @param Request $request
     */
    public function createData($request)
    {
        try{
            $goodinfo = $this->good->find($request->id);
            if (!$goodinfo) {
                $goodinfo = $this->good;
            }
            $goodinfo->commission = '';
            $goodinfo->isdiscount_discounts = '';
            $goodinfo->displayorder= $request->displayorder;
            $goodinfo->title = $request->title;
            $goodinfo->unit = $request->unit;
            $goodinfo->subtitle = $request->subtitle;
            /**
             * 商品类型 1.实体 2.虚拟商品 3.虚拟物品 10 话费充值
             */
            $goodinfo->type = $request->goodstype;
            /**
             * 是否自动发货  1 是 0 否
             */
            $goodinfo->virtualsend = $request->virtualsend;
            //自动发货内容
            $goodinfo->virtualsendcontent = $request->virtualsendcontent;
            //多规格虚拟物品
            $goodinfo->virtual = $request->virtual;
            //商品属性begin
            $goodinfo->isnew = $request->isnew;
            $goodinfo->isrecommand = $request->isrecommand;
            $goodinfo->ishot = $request->ishot;
            $goodinfo->isnodiscount = $request->isnodiscount;
            $goodinfo->issendfree = $request->issendfree;
            //商品属性end
            $goodinfo->marketprice = $request->marketprice;
            $goodinfo->productprice = $request->productprice;
            $goodinfo->costprice = $request->costprice;

            //商品图片
            $thumbs = $request->thumbs;
            $goodinfo->thumb = $thumbs[0];
            unset($thumbs[0]);
            $goodinfo->thumb_url = serialize($thumbs);
            $goodinfo->thumb_first =$request->thumb_first;
            //已出售数
            $goodinfo->sales =$request->sales;
            //运费模板类型
            $goodinfo->dispatchtype =$request->dispatchtype;
            $goodinfo->dispatchid =$request->dispatchid;
            $goodinfo->dispatchprice =$request->dispatchprice;
            $goodinfo->sheng = $request->sheng;
            $goodinfo->shi = $request->shi;
            $goodinfo->qu = $request->qu;
            $goodinfo->other_value = $request->other_value;
            $goodinfo->recommend = $request->recommend;
            //推荐描述
            $goodinfo->referrer = $request->referrer;
            $goodinfo->cash = $request->cash;
            $goodinfo->quality = $request->quality;
            $goodinfo->seven = $request->seven;
            $goodinfo->invoice = $request->invoice;
            $goodinfo->repair = $request->repair;
            $goodinfo->status = $request->status;
            $goodinfo->isshow = $request->isshow;
            $goodinfo->goodssn = $request->goodssn;
            $goodinfo->productsn = $request->productsn;
            $goodinfo->weight = $request->weight;
            $goodinfo->total = $request->total;
            $goodinfo->totalcnf = $request->totalcnf;
            $goodinfo->hasoption = $request->hasoption;

            $goodinfo->maxbuy = $request->maxbuy;
            $goodinfo->minbuy = $request->minbuy;
            $goodinfo->usermaxbuy = $request->usermaxbuy;
            //是否促销
            $goodinfo->isdiscount = $request->isdiscount;
            //促销标题
            $goodinfo->isdiscount_title = trim(mb_substr($request->isdiscount_title, 0, 5, 'UTF-8'));
            //促销结束时间
            $goodinfo->isdiscount_time = strtotime($request->isdiscount_time);
            //是否包邮
            $goodinfo->issendfree = $request->issendfree;
            $goodinfo->isnodiscount = $request->isnodiscount;
            $goodinfo->istime = $request->istime;
            $goodinfo->timestart = $request->timestart;
            $goodinfo->timeend = $request->timeend;
            $goodinfo->description = $request->description;
            $goodinfo->discounts = json_encode($request->discounts);
            $goodinfo->edareas = $request->edareas;
            $goodinfo->edmoney = $request->edmoney;

            $goodinfo->needfollow = $request->needfollow;
            $goodinfo->followtip = $request->followtip;
            $goodinfo->followurl = $request->followurl;
            $goodinfo->share_title = $request->share_title;
            $goodinfo->share_icon = $request->share_icon;
            $goodinfo->description = $request->description;
            $goodinfo->save();
            $request->id = $goodinfo->id;
            $this->createSpec($request);
            $this->createOption($request);
            $this->createParam($request);
        }catch (Exception $e){
            var_dump($e);
        }

        return true;
    }

    /**
     * 处理spec与specitem
     * Create by szh
     * @param $request
     */
    public function createSpec($request)
    {
        $requestinfo = $request->all();
        $specids = $request->spec_id ? $request->spec_id : [];
        foreach($specids as $key => $val){
            $specinfo = $this->spec->find($val);
            if(!$specinfo){
                $specinfo =  new Spec;
            }
            $specinfo->uniacid = UNIACID;
            $specinfo->goodsid = $request->id;
            $specinfo->displayorder = $key;
            $specinfo->title = ($request->spec_title)[$val];
            $specinfo->save();
            $keepSpecId[] = $specinfo->id;
            //进行specitem操作
            $itemsid = $requestinfo['spec_item_id_'.$val];
            foreach($itemsid as $k => $v){
                $itemType = '';
                $specItemInfo = $this->specitem->find($v);
                if(!$specItemInfo){
                    $specItemInfo =new SpecItem;
                    $itemType = 'add';
                }
                $specItemInfo->uniacid = UNIACID;
                $specItemInfo->specid = $specinfo->id;
                $specItemInfo->title = $requestinfo['spec_item_title_'.$val][$k];
                $specItemInfo->displayorder = $k;
                $specItemInfo->show = $requestinfo['spec_item_show_'.$val][$k];
                $specItemInfo->virtual =($request->type == 3 ?  $requestinfo['spec_item_virtual_'.$val][$k] : 0);
                $specItemInfo->save();
                if ($itemType) {
                    $this->keepSpecitemId['id'][] = $v;
                } else {
                    $this->keepSpecitemId['id'][] = $specItemInfo->id;
                }
                $this->keepSpecitemId['trueId'][] = $specItemInfo->id;
            }
            $this->specitem->where('uniacid',UNIACID)->where('specid',$specinfo->id)->whereNotIn('id', $this->keepSpecitemId['trueId'])->delete();
        }
        $keepSpecitemId =  $this->keepSpecitemId;
        //删除不存在的spec
        $request->id = $request->id ? $request->id : '0';
        if (isset($keepSpecId)) {
            $this->spec->whereNotIn('id', $keepSpecId)->where('goodsid',$request->id)->delete();
        } else {
            $this->spec->where('goodsid',$request->id)->delete();
        }
    }

    /**
     * 处理规格数据
     * Create by szh
     * @param $request
     */
    public function createOption($request)
    {
        //规格
        $optionArray = json_decode($request->optionArray, true);
        if(is_array($optionArray)){
            foreach($optionArray['option_id'] as $key =>$val ){
                $idsarr = explode('_', $optionArray['option_ids'][$key]);
                foreach($idsarr as $k1 =>$v1){
                    foreach($this->keepSpecitemId['id'] as $k2 => $v2){
                        if($v2 == $v1){
                            $optionSpecIds[] = $this->keepSpecitemId['trueId'][$k2];
                        }
                    }
                }
                $optioninfo = $this->option->find($val);
                if(!$optioninfo){
                    $optioninfo = new Option;
                }
                if (is_array($optionSpecIds)) {
                    $optionSpecIdsString = implode('_',$optionSpecIds);
                }
                $optioninfo->uniacid = UNIACID;
                $optioninfo->title = $optionArray['option_title'][$key];
                $optioninfo->productprice = $optionArray['option_productprice'][$key];
                $optioninfo->costprice = $optionArray['option_costprice'][$key];
                $optioninfo->marketprice = $optionArray['option_marketprice'][$key];
                $optioninfo->stock = $optionArray['option_stock'][$key];
                $optioninfo->weight = $optionArray['option_weight'][$key];
                $optioninfo->goodssn = $optionArray['option_goodssn'][$key];
                $optioninfo->productsn = $optionArray['option_productsn'][$key];
                $optioninfo->goodsid = $request->id;
                $optioninfo->specs = $optionSpecIdsString;
                $optioninfo->virtual = ($request->type == 3 ? $optionArray['option_virtual'][$key] : 0);
                $optioninfo->save();
                unset($optionSpecIds);
                if (object_get($optioninfo,'id', '')) {
                    $optionids[] = $optioninfo->id;
                    //回写good表数据
                }
            }
            //删除多余数据
            $request->id = $request->id ? $request->id : '0';
            if (isset($optionids)) {
                $this->option->whereNotIn('id',$optionids)->where('goodsid',$request->id)->delete();
            }else{
                $this->option->where('goodsid',$request->id)->delete();
            }
        }
    }



    public function createLevel()
    {

    }

    /**
     * 商品参数
     * Create by szh
     * @param $request
     */
    public function createParam($request)
    {
        //参数
        $paramids = $request->param_id ? $request->param_id : [];
        foreach($paramids as $key => $val){
            $paraminfo = $this->param->find($val);
            if(!$paraminfo){
                $paraminfo = $this->param;
            }
            $paraminfo->uniacid = UNIACID;
            $paraminfo->goodsid = $request->id;
            $paraminfo->displayorder = $key;
            $paraminfo->title = ($request->param_title)[$key];
            $paraminfo->value = ($request->param_value)[$key];
            $paraminfo->save();
            $paramIds[] = $paraminfo->id;
            unset($paraminfo->id);
        }
        //删除多余数据
        $request->id = $request->id ? $request->id : '0';
        if (isset($paramIds)) {
            $this->param->whereNotIn('id',$paramIds)->where('goodsid',$request->id)->delete();
        }else{
            $this->param->where('goodsid',$request->id)->delete();
        }
    }


    /**
     * Create by szh
     * 处理规格模板
     * @param $options
     * @param $levels
     * @param $commission_level
     * @param $good
     * @param $allspecs
     * @return mixed
     */
    public function combinationHtml($options, $levels, $commission_level, $good,$allspecs)
    {
        $commissions_val = ['id' => '', 'title' => '', 'virtual' => ''];
        $shopset_level = 0;
        $commission = json_decode($good['commission'], true);
        $isdiscount_discounts = json_decode($good['isdiscount_discounts'], true);
        if (isset($commission['type']))
        {
            $commission_type = $commission['type'];
            unset($commission['type']);
        }
        $discounts = $good['discounts'];
        $html = '';
        $discounts_html = '';
        $commission_html = '';
        $isdiscount_discounts_html = '';
        $specs = array();
        if (0 < count($options))
        {
            $specitemids = explode('_', $options[0]['specs']);
            foreach ($specitemids as $itemid )
            {
                foreach ($allspecs as $ss )
                {
                    $items = $ss['items'];
                    foreach ($items as $it )
                    {
                        if (!($it['id'] == $itemid))
                        {
                            continue;
                        }
                        $specs[] = $ss;
                        break;
                    }
                }
            }
            $html = '';
            $html .= '<table class="table table-bordered table-condensed">';
            $html .= '<thead>';
            $html .= '<tr class="active">';
            $discounts_html .= '<table class="table table-bordered table-condensed">';
            $discounts_html .= '<thead>';
            $discounts_html .= '<tr class="active">';
            $commission_html .= '<table class="table table-bordered table-condensed">';
            $commission_html .= '<thead>';
            $commission_html .= '<tr class="active">';
            $isdiscount_discounts_html .= '<table class="table table-bordered table-condensed">';
            $isdiscount_discounts_html .= '<thead>';
            $isdiscount_discounts_html .= '<tr class="active">';
            $len = count($specs);
            $newlen = 1;
            $h = array();
            $rowspans = array();
            $i = 0;
            while ($i < $len)
            {
                $html .= '<th>' . $specs[$i]['title'] . '</th>';
                $discounts_html .= '<th>' . $specs[$i]['title'] . '</th>';
                $commission_html .= '<th>' . $specs[$i]['title'] . '</th>';
                $isdiscount_discounts_html .= '<th>' . $specs[$i]['title'] . '</th>';
                $itemlen = count($specs[$i]['items']);
                if ($itemlen <= 0)
                {
                    $itemlen = 1;
                }
                $newlen *= $itemlen;
                $h = array();
                $j = 0;
                while ($j < $newlen)
                {
                    $h[$i][$j] = array();
                    ++$j;
                }
                $l = count($specs[$i]['items']);
                $rowspans[$i] = 1;
                $j = $i + 1;
                while ($j < $len)
                {
                    $rowspans[$i] *= count($specs[$j]['items']);
                    ++$j;
                }
                ++$i;
            }
            $canedit = true;
            if ($canedit)
            {
                foreach ($levels as $level )
                {
                    $discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div><div class="input-group"><input type="text" class="form-control  input-sm discount_' . $level['key'] . '_all" VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'discount_' . $level['key'] . '\');"></a></span></div></div></th>';
                    $isdiscount_discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div><div class="input-group"><input type="text" class="form-control  input-sm isdiscount_discounts_' . $level['key'] . '_all" VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'isdiscount_discounts_' . $level['key'] . '\');"></a></span></div></div></th>';
                }
                foreach ($commission_level as $level )
                {
                    $commission_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
                }
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div><div class="input-group"><input type="text" class="form-control input-sm option_stock_all"  VALUE=""/><span class="input-group-addon" ><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">现价</div><div class="input-group"><input type="text" class="form-control  input-sm option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">原价</div><div class="input-group"><input type="text" class="form-control input-sm option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价</div><div class="input-group"><input type="text" class="form-control input-sm option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">编码</div><div class="input-group"><input type="text" class="form-control input-sm option_goodssn_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_goodssn\');"></a></span></div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">条码</div><div class="input-group"><input type="text" class="form-control input-sm option_productsn_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productsn\');"></a></span></div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div><div class="input-group"><input type="text" class="form-control input-sm option_weight_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
            }
            else
            {
                foreach ($levels as $level )
                {
                    $discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
                    $isdiscount_discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
                }
                foreach ($commission_level as $level )
                {
                    $commission_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
                }
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div></div></th>';
                $html .= '<th"><div class=""><div style="padding-bottom:10px;text-align:center;">销售价格</div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">市场价格</div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价格</div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">商品编码</div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">商品条码</div></div></th>';
                $html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div></th>';
            }
            $html .= '</tr></thead>';
            $discounts_html .= '</tr></thead>';
            $isdiscount_discounts_html .= '</tr></thead>';
            $commission_html .= '</tr></thead>';
            $m = 0;
            while ($m < $len)
            {
                $k = 0;
                $kid = 0;
                $n = 0;
                $j = 0;
                while ($j < $newlen)
                {
                    $rowspan = $rowspans[$m];
                    if (($j % $rowspan) == 0)
                    {
                        $h[$m][$j] = array('html' => '<td class=\'full\' rowspan=\'' . $rowspan . '\'>' . $specs[$m]['items'][$kid]['title'] . '</td>', 'id' => $specs[$m]['items'][$kid]['id']);
                    }
                    else
                    {
                        $h[$m][$j] = array('html' => '', 'id' => $specs[$m]['items'][$kid]['id']);
                    }
                    ++$n;
                    if ($n == $rowspan)
                    {
                        ++$kid;
                        if ((count($specs[$m]['items']) - 1) < $kid)
                        {
                            $kid = 0;
                        }
                        $n = 0;
                    }
                    ++$j;
                }
                ++$m;
            }
            $hh = '';
            $dd = '';
            $isdd = '';
            $cc = '';
            $i = 0;
            while ($i < $newlen)
            {
                $hh .= '<tr>';
                $dd .= '<tr>';
                $isdd .= '<tr>';
                $cc .= '<tr>';
                $ids = array();
                $j = 0;
                while ($j < $len)
                {
                    $hh .= $h[$j][$i]['html'];
                    $dd .= $h[$j][$i]['html'];
                    $isdd .= $h[$j][$i]['html'];
                    $cc .= $h[$j][$i]['html'];
                    $ids[] = $h[$j][$i]['id'];
                    ++$j;
                }
                $ids = implode('_', $ids);
                $val = array('id' => '', 'title' => '', 'stock' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
                $discounts_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
                $isdiscounts_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
                $commission_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
                foreach ($levels as $level )
                {
                    $discounts_val[$level['key']] = '';
                    $isdiscounts_val[$level['key']] = '';
                }
                foreach ($commission_level as $level )
                {
                    $commission_val[$level['key']] = '';
                }
                foreach ($options as $o )
                {
                    if (!($ids === $o['specs']))
                    {
                        continue;
                    }
                    $val = array('id' => $o['id'], 'title' => $o['title'], 'stock' => $o['stock'], 'costprice' => $o['costprice'], 'productprice' => $o['productprice'], 'marketprice' => $o['marketprice'], 'goodssn' => $o['goodssn'], 'productsn' => $o['productsn'], 'weight' => $o['weight'], 'virtual' => $o['virtual']);
                    $discount_val = array('id' => $o['id']);
                    foreach ($levels as $level )
                    {
                        $discounts_val[$level['key']] = (is_string($discounts[$level['key']]) ? '' : $discounts[$level['key']]['option' . $o['id']]);
                        $isdiscounts_val[$level['key']] = (is_string($isdiscount_discounts[$level['key']]) ? '' : $isdiscount_discounts[$level['key']]['option' . $o['id']]);
                    }
                    $commission_val = array();
                    foreach ($commission_level as $level )
                    {
                        $temp = ((is_string($commission[$level['key']]) ? '' : $commission[$level['key']]['option' . $o['id']]));
                        if (is_array($temp))
                        {
                            foreach ($temp as $t_val )
                            {
                                $commission_val[$level['key']][] = $t_val;
                            }
                        }
                    }
                    unset($temp);
                    break;
                }
                if ($canedit)
                {
                    foreach ($levels as $level )
                    {
                        $dd .= '<td>';
                        $isdd .= '<td>';
                        if ($level['key'] == 'default')
                        {
                            $dd .= '<input data-name="discount_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control discount_' . $level['key'] . ' discount_' . $level['key'] . '_' . $ids . '" value="' . $discounts_val[$level['key']] . '"/> ';
                            $isdd .= '<input data-name="isdiscount_discounts_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control isdiscount_discounts_' . $level['key'] . ' isdiscount_discounts_' . $level['key'] . '_' . $ids . '" value="' . $isdiscounts_val[$level['key']] . '"/> ';
                        }
                        else
                        {
                            $dd .= '<input data-name="discount_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control discount_level' . $level['id'] . ' discount_level' . $level['id'] . '_' . $ids . '" value="' . $discounts_val['level' . $level['id']] . '"/> ';
                            $isdd .= '<input data-name="isdiscount_discounts_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control isdiscount_discounts_level' . $level['id'] . ' isdiscount_discounts_level' . $level['id'] . '_' . $ids . '" value="' . $isdiscounts_val['level' . $level['id']] . '"/> ';
                        }
                        $dd .= '</td>';
                        $isdd .= '</td>';
                    }
                    $dd .= '<input data-name="discount_id_' . $ids . '"  type="hidden" class="form-control discount_id discount_id_' . $ids . '" value="' . $discounts_val['id'] . '"/>';
                    $dd .= '<input data-name="discount_ids"  type="hidden" class="form-control discount_ids discount_ids_' . $ids . '" value="' . $ids . '"/>';
                    $dd .= '<input data-name="discount_title_' . $ids . '"  type="hidden" class="form-control discount_title discount_title_' . $ids . '" value="' . $discounts_val['title'] . '"/>';
                    $dd .= '<input data-name="discount_virtual_' . $ids . '"  type="hidden" class="form-control discount_title discount_virtual_' . $ids . '" value="' . $discounts_val['virtual'] . '"/>';
                    $dd .= '</tr>';
                    $isdd .= '<input data-name="isdiscount_discounts_id_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_id isdiscount_discounts_id_' . $ids . '" value="' . $isdiscounts_val['id'] . '"/>';
                    $isdd .= '<input data-name="isdiscount_discounts_ids"  type="hidden" class="form-control isdiscount_discounts_ids isdiscount_discounts_ids_' . $ids . '" value="' . $ids . '"/>';
                    $isdd .= '<input data-name="isdiscount_discounts_title_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_title_' . $ids . '" value="' . $isdiscounts_val['title'] . '"/>';
                    $isdd .= '<input data-name="isdiscount_discounts_virtual_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_virtual_' . $ids . '" value="' . $isdiscounts_val['virtual'] . '"/>';
                    $isdd .= '</tr>';
                    foreach ($commission_level as $level )
                    {
                        $cc .= '<td>';
                        if (!empty($commission_val) && isset($commission_val[$level['key']]))
                        {
                            foreach ($commission_val as $c_key => $c_val )
                            {
                                if ($c_key == $level['key'])
                                {
                                    if ($level['key'] == 'default')
                                    {
                                        $c_i = 0;
                                        while ($c_i < $shopset_level)
                                        {
                                            $cc .= '<input data-name="commission_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control commission_' . $level['key'] . ' commission_' . $level['key'] . '_' . $ids . '" value="' . $c_val[$c_i] . '" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
                                            ++$c_i;
                                        }
                                    }
                                    else
                                    {
                                        $c_i = 0;
                                        while ($c_i < $shopset_level)
                                        {
                                            $cc .= '<input data-name="commission_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control commission_level' . $level['id'] . ' commission_level' . $level['id'] . '_' . $ids . '" value="' . $c_val[$c_i] . '" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
                                            ++$c_i;
                                        }
                                    }
                                }
                            }
                        }
                        else if ($level['key'] == 'default')
                        {
                            $c_i = 0;
                            while ($c_i < $shopset_level)
                            {
                                $cc .= '<input data-name="commission_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control commission_' . $level['key'] . ' commission_' . $level['key'] . '_' . $ids . '" value="" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
                                ++$c_i;
                            }
                        }
                        else
                        {
                            $c_i = 0;
                            while ($c_i < $shopset_level)
                            {
                                $cc .= '<input data-name="commission_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control commission_level' . $level['id'] . ' commission_level' . $level['id'] . '_' . $ids . '" value="" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
                                ++$c_i;
                            }
                        }
                        $cc .= '</td>';
                    }
                    $cc .= '<input data-name="commission_id_' . $ids . '"  type="hidden" class="form-control commission_id commission_id_' . $ids . '" value="' . $commissions_val['id'] . '"/>';
                    $cc .= '<input data-name="commission_ids"  type="hidden" class="form-control commission_ids commission_ids_' . $ids . '" value="' . $ids . '"/>';
                    $cc .= '<input data-name="commission_title_' . $ids . '"  type="hidden" class="form-control commission_title commission_title_' . $ids . '" value="' . $commissions_val['title'] . '"/>';
                    $cc .= '<input data-name="commission_virtual_' . $ids . '"  type="hidden" class="form-control commission_title commission_virtual_' . $ids . '" value="' . $commissions_val['virtual'] . '"/>';
                    $cc .= '</tr>';
                    $hh .= '<td>';
                    $hh .= '<input data-name="option_stock_' . $ids . '"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/>';
                    $hh .= '</td>';
                    $hh .= '<input data-name="option_id_' . $ids . '"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
                    $hh .= '<input data-name="option_ids"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
                    $hh .= '<input data-name="option_title_' . $ids . '"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
                    $hh .= '<input data-name="option_virtual_' . $ids . '"  type="hidden" class="form-control option_virtual option_virtual_' . $ids . '" value="' . $val['virtual'] . '"/>';
                    $hh .= '<td><input data-name="option_marketprice_' . $ids . '" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
                    $hh .= '<td><input data-name="option_productprice_' . $ids . '" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
                    $hh .= '<td><input data-name="option_costprice_' . $ids . '" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $val['costprice'] . '"/></td>';
                    $hh .= '<td><input data-name="option_goodssn_' . $ids . '" type="text" class="form-control option_goodssn option_goodssn_' . $ids . '" " value="' . array_get($val,'goodssn','') . '"/></td>';
                    $hh .= '<td><input data-name="option_productsn_' . $ids . '" type="text" class="form-control option_productsn option_productsn_' . $ids . '" " value="' . array_get($val,'productsn','')  . '"/></td>';
                    $hh .= '<td><input data-name="option_weight_' . $ids . '" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . array_get($val,'weight','').'"/></td>';
                    $hh .= '</tr>';
                }
                else
                {
                    $hh .= '<td>' . $val['stock'] . '</td>';
                    $hh .= '<td>' . $val['marketprice'] . '</td>';
                    $hh .= '<td>' . $val['productprice'] . '</td>';
                    $hh .= '<td>' . $val['costprice'] . '</td>';
                    $hh .= '<td>' . $val['goodssn'] . '</td>';
                    $hh .= '<td>' . $val['productsn'] . '</td>';
                    $hh .= '<td>' . $val['weight'] . '</td>';
                    $hh .= '</tr>';
                }
                ++$i;
            }
            $discounts_html .= $dd;
            $discounts_html .= '</table>';
            $isdiscount_discounts_html .= $isdd;
            $isdiscount_discounts_html .= '</table>';
            $html .= $hh;
            $html .= '</table>';
            $commission_html .= $cc;
            $commission_html .= '</table>';
        }
        $blade['html'] = $html;
        $blade['commission_html'] = $commission_html;
        return $blade;
    }





}
