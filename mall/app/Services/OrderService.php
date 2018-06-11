<?php
/**
 * Created by PhpStorm.
 * User: wangzhen
 * Date: 2018/6/7
 * Time: 15:40
 */

namespace Bedrock\Services;

use Bedrock\Models\Order;
use Bedrock\Models\OrderGoods;
use Bedrock\Models\Good;
use Bedrock\Models\Saler;
use Illuminate\Http\Request;

class OrderService
{
    protected $order;
    protected $ordergoods;
    protected $goods;
    protected $saler;


    public function __construct(Order $order, OrderGoods $ordergoods, Good $goods,Saler $saler)
    {
        $this->order = $order;
        $this->ordergoods = $ordergoods;
        $this->goods = $goods;
        $this->saler = $saler;
    }

    /**
     * 高级查询获取订单数据
     * by
     */
    public function getSeniorOrderList(Request $request)
    {

    }

    /**获取支付方式列表
     * @return array
     */
    public function getpaytypeList()
    {
        return array( 0 => array('css' => 'default', 'name' => '未支付'), 1 => array('css' => 'danger', 'name' => '余额支付'), 11 => array('css' => 'default', 'name' => '后台付款'), 2 => array('css' => 'danger', 'name' => '在线支付'), 21 => array('css' => 'success', 'name' => '微信支付'), 22 => array('css' => 'warning', 'name' => '支付宝支付'), 23 => array('css' => 'warning', 'name' => '银联支付'), 3 => array('css' => 'primary', 'name' => '货到付款') );
    }

    /**
     * 获取时间筛选列表
     * @return array
     */
    public function getsearchtimeList()
    {
        return array('default'=>'不按时间','createtime'=>'下单时间','paytime'=>'付款时间','sendtime'=>'发货时间','finishtime'=>'完成时间');
    }

    /**
     * 获取订单状态
     * @return array
     */
    public function getorderstatus()
    {
        return array( -1 => array('css' => 'default', 'name' => '已关闭'), 0 => array('css' => 'danger', 'name' => '待付款'), 1 => array('css' => 'info', 'name' => '待发货'), 2 => array('css' => 'warning', 'name' => '待收货'), 3 => array('css' => 'success', 'name' => '已完成') );
    }

    /**
     * @return array
     */
    public function  getsearchfieldLsit()
    {
        $searchfield=array();
        $searchfield['ordersn']='订单号';
        $searchfield['member']='会员信息';
        $searchfield['address']='收件人信息';
        $searchfield['expresssn']='快递单号';
        $searchfield['goodstitle']='商品名称';
        $searchfield['goodssn']='商品编码';
        $searchfield['saler']='核销员';
        $searchfield['store']='核销门店';
        if(true)//判断是否开启多商家
        {
            $searchfield['merch']='商户名称';
        }
        $searchfield['activity']='活动名称';
        return $searchfield;
    }


    /**
     * 获取
     */
    public function ajaxgettotals()
    {
        $totals['all'] = $this->order->getTotalsCount(array('typename' => 'all'));
        $totals['status_1'] = $this->order->getTotalsCount(array('typename' => 'status_1'));
        $totals['status0'] = $this->order->getTotalsCount(array('typename' => 'status0'));
        $totals['status1'] = $this->order->getTotalsCount(array('typename' => 'status1'));
        $totals['status2'] = $this->order->getTotalsCount(array('typename' => 'status2'));
        $totals['status3'] = $this->order->getTotalsCount(array('typename' => 'status3'));
        $totals['status4'] = $this->order->getTotalsCount(array('typename' => 'status4'));
        $totals['status5'] = $this->order->getTotalsCount(array('typename' => 'status5'));
        dd($totals);
    }

    public function ajaxorder()
    {
        $order0 = $this->orderdata(0);
        $order1 = $this->orderdata(1);
        $order7 = $this->orderdata(7);
        $order30 = $this->orderdata(30);
        $order7['price'] = $order7['price'] + $order0['price'];
        $order7['count'] = $order7['count'] + $order0['count'];
        $order7['avg'] = (empty($order7['count']) ? 0 : round($order7['price'] / $order7['count'], 1));
        $order30['price'] = $order30['price'] + $order0['price'];
        $order30['count'] = $order30['count'] + $order0['count'];
        $order30['avg'] = (empty($order30['count']) ? 0 : round($order30['price'] / $order30['count'], 1));
        return array('order0' => $order0, 'order1' => $order1, 'order7' => $order7, 'order30' => $order30);
    }

    public function ajaxtransaction()
    {
        $orderPrice = $this->order->getOrderPrice(7);;
        $transaction = $this->selectTransaction($orderPrice['fetchall'], 7);
        if (empty($transaction)) {
            $i = 7;
            while (1 <= $i) {
                $transaction['price'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                $transaction['count'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                --$i;
            }
        }
        return json_encode(array('price_key' => array_keys($transaction['price']), 'price_value' => array_values($transaction['price']), 'count_value' => array_values($transaction['count'])));
    }

    protected function orderdata($day)
    {
        $day = (int)$day;
        $orderPrice = $this->order->getOrderPrice($day);
        $orderPrice['avg'] = (empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 1));
        unset($orderPrice['fetchall']);
        return $orderPrice;
    }

    protected function selectTransaction($pdo_fetchall, $days = 7)
    {
        $transaction = array();
        $days = (int)$days;
        if (!empty($pdo_fetchall)) {
            $i = $days;
            while (1 <= $i) {
                $transaction['price'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                $transaction['count'][date('Y-m-d', time() - ($i * 3600 * 24))] = 0;
                --$i;
            }
            foreach ($pdo_fetchall as $key => $value) {
                if (array_key_exists(date('Y-m-d', $value['createtime']), $transaction['price'])) {
                    $transaction['price'][date('Y-m-d', $value['createtime'])] += $value['price'];
                    $transaction['count'][date('Y-m-d', $value['createtime'])] += 1;
                }
            }
            return $transaction;
        }
        return array();
    }



    /**
     * @param Request $request
     * @return string
     */
    public function orderlist(Request $request)
    {
        $status = $request->status;
        $keyword = trim($request->keyword);
        $agentid = $request->agentid;
        $refund = $request->refund;
        $paytype = $request->paytype;
        $searchtime = $request->searchtime;
        $searchfield = $request->searchfield;
        $page=$request->page;
        $sendtype = (isset($request->sendtype)? 0 : $request->sendtype);
        $pindex = max(1, intval($page));
        $psize = 20;
        $paras=array();
        if (true) //是否开放多供应商
            $is_openmerch = 1;
        else
            $is_openmerch = 0;
        if (empty($starttime) || empty($endtime))
        {
            $starttime = strtotime('-1 month');
            $endtime = time();
        }
        if (!empty($searchtime) && is_array( $request->time) && in_array($searchtime, array('create', 'pay', 'send', 'finish')))
        {
            $starttime = strtotime($request->time['start']);
            $endtime = strtotime($request->time['end']);
            $paras['searchtime']=$searchtime;//参数
        }
        if ($request->paytype != '')
        {
            $paras['paytype']=$request->paytype;
        }
        if (!empty($request->searchfield) && !empty($keyword))
        {
            $searchfield = trim(strtolower($request->searchfield));
            $keyword = trim($keyword);
            $paras['searchfield']=$searchfield;
            $paras['keyword']=$keyword;
            if ($status !== '')
                $paras['status']=$status;
        }
        $level = 0;
        $olevel=$request->olevel;
        $is_merch = array();
        $is_merchname = 0;

        $list=$this->order->getOrderList(0,$psize);
        $list=$this->recombinationOrder($list);
        return $list;
    }

    /**根据订单Id获取订单商品
     * 组合数据
     * @param $oid
     * @return array
     */
    public function getordergoods($oid)
    {
        $ordergoods=$this->ordergoods->getOrderGoods($oid);
        $goods=array();
        foreach ($ordergoods as $val)
        {
            $originalgoods=$this->ordergoods->find($val['id'])->hanOneGoods->toArray();
            array_push($goods,$originalgoods);
        }
        return $goods;
    }

    /**
     * 获取订单数据源
     * @param Request $request
     */
    public function  orderlistcore(Request $request)
    {

    }


    /**
     * 导出Excel
     */
    public function  exportExcel($level,$list)
    {
        plog('order.op.export', '导出订单');
        $columns = array( array('title' => '订单编号', 'field' => 'ordersn', 'width' => 24),array('title' => '粉丝昵称', 'field' => 'nickname', 'width' => 12), array('title' => '会员姓名', 'field' => 'mrealname', 'width' => 12), array('title' => 'openid', 'field' => 'openid', 'width' => 24), array('title' => '会员手机手机号', 'field' => 'mmobile', 'width' => 12), array('title' => '收货姓名(或自提人)', 'field' => 'realname', 'width' => 12), array('title' => '联系电话', 'field' => 'mobile', 'width' => 12), array('title' => '收货地址', 'field' => 'address_province', 'width' => 12), array('title' => '', 'field' => 'address_city', 'width' => 12), array('title' => '', 'field' => 'address_area', 'width' => 12), array('title' => '', 'field' => 'address_address', 'width' => 12), array('title' => '商品名称', 'field' => 'goods_title', 'width' => 24), array('title' => '商品编码', 'field' => 'goods_goodssn', 'width' => 12), array('title' => '商品规格', 'field' => 'goods_optiontitle', 'width' => 12), array('title' => '商品数量', 'field' => 'goods_total', 'width' => 12), array('title' => '商品单价(折扣前)', 'field' => 'goods_price1', 'width' => 12), array('title' => '商品单价(折扣后)', 'field' => 'goods_price2', 'width' => 12), array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice1', 'width' => 12), array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice2', 'width' => 12),array('title' => '结算单价', 'field' => 'costprice', 'width' => 12), array('title' => '支付方式', 'field' => 'paytype', 'width' => 12), array('title' => '配送方式', 'field' => 'dispatchname', 'width' => 12), array('title' => '商品小计', 'field' => 'goodsprice', 'width' => 12), array('title' => '运费', 'field' => 'dispatchprice', 'width' => 12), array('title' => '积分抵扣', 'field' => 'deductprice', 'width' => 12), array('title' => '余额抵扣', 'field' => 'deductcredit2', 'width' => 12), array('title' => '满额立减', 'field' => 'deductenough', 'width' => 12), array('title' => '优惠券优惠', 'field' => 'couponprice', 'width' => 12), array('title' => '订单改价', 'field' => 'changeprice', 'width' => 12), array('title' => '运费改价', 'field' => 'changedispatchprice', 'width' => 12), array('title' => '应收款', 'field' => 'price', 'width' => 12), array('title' => '状态', 'field' => 'status', 'width' => 12), array('title' => '下单时间', 'field' => 'createtime', 'width' => 24), array('title' => '付款时间', 'field' => 'paytime', 'width' => 24), array('title' => '发货时间', 'field' => 'sendtime', 'width' => 24), array('title' => '完成时间', 'field' => 'finishtime', 'width' => 24), array('title' => '快递公司', 'field' => 'expresscom', 'width' => 24), array('title' => '快递单号', 'field' => 'expresssn', 'width' => 24), array('title' => '订单备注', 'field' => 'remark', 'width' => 36), array('title' => '核销员', 'field' => 'salerinfo', 'width' => 24), array('title' => '核销门店', 'field' => 'storeinfo', 'width' => 36), array('title' => '订单自定义信息', 'field' => 'order_diyformdata', 'width' => 36), array('title' => '商品自定义信息', 'field' => 'goods_diyformdata', 'width' => 36),array('title' => '供应商名称', 'field' => 'merchname', 'width' => 36) );
        if (!empty($agentid) && (0 < $level))
        {
            $columns[] = array('title' => '分销级别', 'field' => 'level', 'width' => 24);
            $columns[] = array('title' => '分销佣金', 'field' => 'commission', 'width' => 24);
        }
        if(true)
        {
            $columns[] = array('title' => '购买方名称', 'field' => 'buyername', 'width' => 24);
            $columns[] = array('title' => '纳税人识别号', 'field' => 'taxpayerno', 'width' => 24);
        }
        foreach ($list as &$row )
        {
            $row['ordersn'] = $row['ordersn'] . ' ';
            if (0 < $row['deductprice'])
            {
                $row['deductprice'] = '-' . $row['deductprice'];
            }
            if (0 < $row['deductcredit2'])
            {
                $row['deductcredit2'] = '-' . $row['deductcredit2'];
            }
            if (0 < $row['deductenough'])
            {
                $row['deductenough'] = '-' . $row['deductenough'];
            }
            if ($row['changeprice'] < 0)
            {
                $row['changeprice'] = '-' . $row['changeprice'];
            }
            else if (0 < $row['changeprice'])
            {
                $row['changeprice'] = '+' . $row['changeprice'];
            }
            if ($row['changedispatchprice'] < 0)
            {
                $row['changedispatchprice'] = '-' . $row['changedispatchprice'];
            }
            else if (0 < $row['changedispatchprice'])
            {
                $row['changedispatchprice'] = '+' . $row['changedispatchprice'];
            }
            if (0 < $row['couponprice'])
            {
                $row['couponprice'] = '-' . $row['couponprice'];
            }
            $row['expresssn'] = $row['expresssn'] . ' ';
            $row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
            $row['paytime'] = (!empty($row['paytime']) ? date('Y-m-d H:i:s', $row['paytime']) : '');
            $row['sendtime'] = (!empty($row['sendtime']) ? date('Y-m-d H:i:s', $row['sendtime']) : '');
            $row['finishtime'] = (!empty($row['finishtime']) ? date('Y-m-d H:i:s', $row['finishtime']) : '');
            $row['salerinfo'] = '';
            $row['storeinfo'] = '';
            if(!empty($row['buyername'])||!empty($row['taxpayerno']))
            {
                if($row['status']=='待付款'||$row['status']=='已关闭')
                {
                    $row['buyername']='';
                    $row['taxpayerno']='';
                }
            }
            if (!empty($row['verifyopenid']))
            {
                $row['salerinfo'] = '[' . $row['salerid'] . ']' . $row['salername'] . '(' . $row['salernickname'] . ')';
            }
            if (!empty($row['verifystoreid']))
            {
                $row['storeinfo'] = pdo_fetchcolumn('select storename from ' . tablename('weshop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid']));
            }
            if (p('diyform') && !empty($row['diyformfields']) && !empty($row['diyformdata']))
            {
                $diyformdata_array = p('diyform')->getDatas(iunserializer($row['diyformfields']), iunserializer($row['diyformdata']));
                $diyformdata = '';
                foreach ($diyformdata_array as $da )
                {
                    $diyformdata .= $da['name'] . ': ' . $da['value'] . "\r\n";
                }
                $row['order_diyformdata'] = $diyformdata;
            }
        }
        unset($row);
        $exportlist = array();
        foreach ($list as &$r )
        {
            $ogoods = $r['goods'];
            unset($r['goods']);
            foreach ($ogoods as $k => $g )
            {
                if (0 < $k)
                {
                    $r['ordersn'] = '';
                    $r['realname'] = '';
                    $r['mobile'] = '';
                    $r['openid'] = '';
                    $r['nickname'] = '';
                    $r['mrealname'] = '';
                    $r['mmobile'] = '';
                    $r['address'] = '';
                    $r['address_province'] = '';
                    $r['address_city'] = '';
                    $r['address_area'] = '';
                    $r['address_address'] = '';
                    $r['paytype'] = '';
                    $r['dispatchname'] = '';
                    $r['dispatchprice'] = '';
                    $r['goodsprice'] = '';
                    $r['status'] = '';
                    $r['createtime'] = '';
                    $r['sendtime'] = '';
                    $r['finishtime'] = '';
                    $r['expresscom'] = '';
                    $r['expresssn'] = '';
                    $r['deductprice'] = '';
                    $r['deductcredit2'] = '';
                    $r['deductenough'] = '';
                    $r['changeprice'] = '';
                    $r['changedispatchprice'] = '';
                    $r['price'] = '';
                    $r['order_diyformdata'] = '';
                }
                $r['goods_title'] = $g['title'];
                $r['goods_goodssn'] = $g['goodssn'];
                $r['goods_optiontitle'] = $g['optiontitle'];
                $r['goods_total'] = $g['total'];
                $r['goods_price1'] = $g['price'] / $g['total'];
                $r['goods_price2'] = $g['realprice'] / $g['total'];
                $r['goods_rprice1'] = $g['price'];
                $r['goods_rprice2'] = $g['realprice'];
                $r['goods_diyformdata'] = $g['goods_diyformdata'];
                $exportlist[] = $r;
            }
        }
        unset($r);
        m('excel')->export($exportlist, array('title' => '订单数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
    }

    public function set_medias($list = array(), $fields = NULL)
    {
        if (empty($list))
        {
            return '';
        }
        if (empty($fields))
        {
            foreach ($list as &$row )
            {
                $row = tomedia($row);
            }
            return $list;
        }
        if (!is_array($fields))
        {
            $fields = explode(',', $fields);
        }
        if ($this->is_array2($list))
        {
            foreach ($list as $key => &$value )
            {
                foreach ($fields as $field )
                {
                    if (isset($list[$field]))
                    {
                        $list[$field] = tomedia($list[$field]);
                    }
                    if (is_array($value) && isset($value[$field]))
                    {
                        $value[$field] = tomedia($value[$field]);
                    }
                }
            }
            return $list;
        }
        foreach ($fields as $field )
        {
            if (isset($list[$field]))
            {
                $list[$field] = tomedia($list[$field]);
            }
        }
        return $list;
    }

    public function is_array2($array)
    {
        if (is_array($array))
        {
            foreach ($array as $k => $v )
            {
                return is_array($v);
            }
            return false;
        }
        return false;
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

    /**重组订单数据
     * @param $list
     * @return mixed
     */
    protected function  recombinationOrder($list)
    {
        foreach ($list as $key=>$value)
        {
            $goods=$this->getordergoods($value['id']);
            $list[$key]['goods']=$goods;
            $member= $this->order->find($value['id'])->hasOneUser->toArray();
            $list[$key]['nickname']=$member['nickname'];
            $list[$key]['mid']=$member['id'];
            $list[$key]['mrealname']=$member['nickname'];
            $list[$key]['mmobile']=$member['mobile'];
            $address=$this->order->find($value['id'])->hasOneMemberAddress->toArray();
            $list[$key]['arealname']=$address['realname'];
            $list[$key]['amobile']=$address['mobile'];
            $list[$key]['aprovince']=$address['province'];
            $list[$key]['acity']=$address['city'];
            $list[$key]['aarea']=$address['area'];
            $list[$key]['statusvalue']=$value['status'];
            $list[$key]['aaddress']=$address['address'];
            if (($value['dispatchtype'] == 1) || !empty($value['isverify']) || !empty($value['virtual']) || !empty($value['isvirtual']))
            {
                $value['address'] = '';
                $carrier = $this->iunserializer($value['carrier']);
                if (is_array($carrier))
                {
                    $list[$key]['addressdata']['realname'] = $value['realname'] = $carrier['carrier_realname'];
                    $list[$key]['addressdata']['mobile'] = $value['mobile'] = $carrier['carrier_mobile'];
                }
            }
            else
            {
                $address = $this->iunserializer($value['address']);
                $isarray = is_array($address);
                $list[$key]['realname'] = ($isarray ? $address['realname'] :  $list[$key]['arealname']);
                $list[$key]['mobile'] = ($isarray ? $address['mobile'] :  $list[$key]['amobile']);
                $list[$key]['province'] = ($isarray ? $address['province'] :  $list[$key]['aprovince']);
                $list[$key]['city'] = ($isarray ? $address['city'] :  $list[$key]['acity']);
                $list[$key]['area'] = ($isarray ? $address['area'] :  $list[$key]['aarea']);
                $list[$key]['address'] = ($isarray ? $address['address'] :  $list[$key]['aaddress']);
                $list[$key]['address_province'] =  $list[$key]['province'];
                $list[$key]['address_city'] =  $list[$key]['city'];
                $list[$key]['address_area'] =  $list[$key]['area'];
                $list[$key]['address_address'] =  $list[$key]['address'];
                $list[$key]['address'] =  $list[$key]['province'] . ' ' .  $list[$key]['city'] . ' ' .  $list[$key]['area'] . ' ' .  $list[$key]['address'];
                $list[$key]['addressdata'] = array('realname' =>  $list[$key]['realname'], 'mobile' =>  $list[$key]['mobile'], 'address' =>  $list[$key]['address']);
            }

            $dispatch=$this->order->find($value['id'])->hasOneDispatch==null?array():$this->order->find($value['id'])->hasOneDispatch->toArray();
            if(count($dispatch)>0)
            {
                $list[$key]['dispatchname']=$dispatch['dispatchname'];
            }else{
                $list[$key]['dispatchname']='';
            }

        }
        return $list;
    }


}