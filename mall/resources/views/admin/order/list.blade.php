@extends('admin.layout.main')
@section('content')
    <link href="/resource/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
    <script src="/resource/datetimepicker/jquery.datetimepicker.js"></script>
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
    <script src="/js/orderlsit.js"></script>
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>订单管理
                                <small>{{$typename}}</small>
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <form action="{{$customurl}}" method="get" class="form-horizontal form-search" role="form">
                            <input type="hidden" name="status" value="{{$request->status}}"/>
                            <input type="hidden" name="agentid" value="{{$request->agentid}}"/>
                            <input type="hidden" name="refund" value="{{$request->refund}}"/>
                            <div class="page-toolbar row m-b-sm m-t-sm">
                                <div class="col-sm-7">
                                    <div class="btn-group btn-group-sm" style='float:left'>
                                        <button class="btn btn-default btn-sm" type="button" data-toggle='refresh'><i
                                                    class='fa fa-refresh'></i></button>
                                    </div>
                                    <div class='input-group input-group-sm'>
                                        <select name="paytype" class="form-control input-sm select-md" style="width:85px;padding:0 5px;">
                                            @foreach($paytypelist as  $key => $type)
                                                <option value="{{$key}}" @if($request->paytype== "{{$key}}") selected @endif >{{$type['name']}}</option>
                                            @endforeach
                                        </select>
                                        <select name='searchtime' class='form-control  input-sm select-md'  style="width:85px;padding:0 5px;">
                                            @foreach($searchtimelist as  $key => $value)
                                                <option value="{{$key}}" @if($request->searchtime== "{{$key}}") selected @endif >{{$value}}</option>
                                            @endforeach
                                        </select>
                                    <script>
                                            $(function(){
                                                var beginTimeStore =$("#beginTimeStore").val();
                                                var endTimeStore = $("#endTimeStore").val();
                                                $('#datatimepicker').daterangepicker({
                                                    "startDate":beginTimeStore,
                                                     "endDate":endTimeStore,
                                                    "locale": {
                                                        format: 'YYYY-MM-DD HH:mm',
                                                        applyLabel: "确定",
                                                        cancelLabel: "取消"
                                                    }
                                                }, function(start, end, label) {
                                                    beginTimeStore = start;
                                                    endTimeStore = end;
                                                    if(!this.startDate){
                                                        this.element.val('');
                                                    }else{
                                                        $(".date-title").html(this.startDate.format(this.locale.format) + " 至 " + this.endDate.format(this.locale.format));
                                                        $('#beginTimeStore').val(this.startDate.format(this.locale.format));
                                                        $('#endTimeStore').val(this.endDate.format(this.locale.format))
                                                    }
                                                });
                                            });
                                    </script>
                                        <input name="starttime" id="beginTimeStore" type="hidden" value="{{$request->starttime}}">
                                        <input name="endtime" id="endTimeStore" type="hidden" value="{{$request->endtime}}">
                                        <button  id="datatimepicker" class="btn btn-default daterange daterange-time btn-sm" type="button"> <span class="date-title">{{$request->starttime}} 至 {{$request->endtime}}</span>
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-5 pull-right">
                                    <select name='searchfield' class='form-control  input-sm select-md' style="width:95px;padding:0 5px;display:inline-block;">
                                        @foreach($searchfieldlsit as  $key => $value)
                                            <option value="{{$key}}" @if($request->searchfield== "{{$key}}") selected @endif >{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group" style="width:300px;display:inline-block;">
                                        <input type="text" style="width:200px;display:inline-block;margin-top:-3px" class="form-control input-sm" name="keyword" value="{{$request->keyword}}" placeholder="请输入关键词"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm btn-primary" type="submit"> 搜索</button>
                                            <button type="submit" name="export" value="1" class="btn btn-sm btn-success">导出</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if(count($list)>=0)
                            <table class='table table-responsive' style='table-layout: fixed;'>
                                <tr style='background:#f8f8f8'>
                                    <td style='width:60px;border-left:1px solid #f2f2f2;'>商品</td>
                                    <td style='width:150px;'></td>
                                    <td style='width:70px;text-align: right;;'>单价/数量</td>
                                    <td  style='width:100px;text-align: center;'>买家</td>
                                    <td style='width:90px;text-align: center;'>支付/配送</td>
                                    <td style='width:100px;text-align: center;'>价格</td>
                                    <td style='width:100px;text-align: center;'>下单时间</td>
                                    <td style='width:90px;text-align: center'>状态</td>
                                </tr>
                                @foreach($list as $item)
                                <tr ><td colspan='8' style='height:20px;padding:0;border-top:none;'>&nbsp;</td></tr>
                                <tr class='trorder'>
                                    <td colspan='4' >
                                        订单编号:  {{$item['ordersn']}}
                                        &nbsp;订单成本:  {{$item['costprice']}}
                                        @if (!empty($item['refundstate']))<label class='label label-danger'>{{$r_type[$item['rtype']]}}申请</label>@endif
                                        @if (!empty($item['refundstate'])&& $item['rstatus'] == 4)<label class='label label-default'>客户退回物品</label>@endif
                                    </td>
                                    <td colspan='4' style='text-align:right;font-size:12px;' class='aops'>
                                        @if($item['merchid'] == 0)
                                            @if(empty($item['statusvalue']))
                                                @if( $item['ismerch'] == 0)
                                                    @if(true)
                                                        {{--权限--}}
                                                        <a class='op'  data-toggle='ajaxModal' href="{php echo webUrl('order/op/close',array('id'=>$item['id']))}" >关闭订单</a>
                                                    @endif
                                              @endif
                                              @if(true)
                                                        {{--权限--}}
                                        <a class='op'  data-toggle='ajaxModal' href="{php echo webUrl('order/op/changeprice',array('id'=>$item['id']))}">订单改价</a>
                                              @endif
                                            @endif
                                        @endif
                                            @if( !empty($item['refundid']))
                                        <a class='op'  href="{php echo webUrl('order/op/refund', array('id' => $item['id']))}" >维权@if($item['refundstate']>0)处理  @else 详情 @endif</a>
                                            @endif

                                        @if($item['merchid'] == 0)
                                            @if($item['statusvalue'] == 2 && !empty($item['addressid']))
                                                @if(true)
                                                  <a class="op" data-toggle="ajaxModal"  href="{php echo webUrl('order/op/changeexpress', array('id' => $item['id']))}">修改物流</a>
                                                @endif
                                            @endif
                                        @endif
                                        <a class='op'  href="{php echo webUrl('order/detail', array('id' => $item['id']))}" >查看详情</a>
                                        @if($item['addressid']!=0&& $item['status']>=2)
                                        <a class='op'  data-toggle="ajaxModal" href="{php echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn']))}"   >物流信息</a>
                                       @endif
                                        @if($item['merchid'] == 0)
                                        @if(true)
                                        <a class='op'  data-toggle="ajaxModal" href="{php echo webUrl('order/op/remarksaler', array('id' => $item['id']))}" @if(!empty($item['remarksaler']))style='color:red'@endif >备注</a>
                                        @endif
                                            @endif
                                    </td>
                                </tr>
                                @foreach($item['goods'] as $k=>$g)
                                <tr class='trbody'>
                                    <td style='overflow:hidden;'><img src="$g['thumb']" style='width:50px;height:50px;border:1px solid #ccc; padding:1px;'></td>
                                    <td style='text-align: left;overflow:hidden;border-left:none;'  >{{$g['title']}}@if(!empty($g['optiontitle']))<br/>{{$g['optiontitle']}}@endif<br/>{{$g['goodssn']}}</td>
                                    <td style='text-align:right;border-left:none;'> {{number_format($g['realprice']/$g['total'],2)}}<br/>x{{$g['total']}}</td>

                                    @if($k==0)
                                    <td rowspan="{{count($item['goods'])}}"  style='text-align: center;' >
                                        {{--{ifp 'member.member.edit'}--}}
                                        @if(true)
                                        <a href="{php echo webUrl('member/list/detail',array('id'=>$item['mid']))}"> {{$item['nickname']}}</a>
                                        @else
                                        {{$item['nickname']}}
                                        @endif

                                        <br/>
                                        {{$item['addressdata']['realname']}}<br/>{{$item['addressdata']['mobile']}}</td>
                                    <td rowspan="{{count($item['goods'])}}" style='text-align:center;' >

                                        @if($item['statusvalue'] > 0)
                                        <label class='label label-{$item['css']}'>{{$item['paytype']}}</label>
                                        @elseif($item['statusvalue'] == 0)
                                        @if($item['paytypevalue']!=3)
                                        <label class='label label-default'>未支付</label>
                                        @else
                                        <label class='label label-primary'>货到付款</label>
                                        @endif
                                        @elseif($item['statusvalue'] == -1)
                                        <label class='label label-default'>{{$item['paytype']}}</label>
                                        @endif
                                        <br/>


                                        <span style='margin-top:5px;display:block;'>{{$item['dispatchname']}}</span>

                                    </td>
                                    <td  rowspan="{{count($item['goods'])}}" style='text-align:center' >
                                        ￥{{number_format($item['price'],2)}} <a data-toggle='popover' data-html='true' data-placement='top'
                                                                                       data-content="<table style='width:100%;'>
                <tr>
                    <td  style='border:none;text-align:right;'>商品小计：</td>
                    <td  style='border:none;text-align:right;;'>￥{{ number_format( $item['goodsprice'] ,2)}}</td>
                </tr>
                <tr>
                    <td  style='border:none;text-align:right;'>运费：</td>
                    <td  style='border:none;text-align:right;;'>￥{{ number_format( $item['olddispatchprice'],2)}}</td>
                </tr>
                {if $item['discountprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>会员折扣：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['discountprice'],2)}}</td>
                </tr>
                {/if}
                {if $item['deductprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>积分抵扣：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['deductprice'],2)}}</td>
                </tr>
                {/if}
                {if $item['deductcredit2']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>余额抵扣：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['deductcredit2'],2)}}</td>
                </tr>
                {/if}
                {if $item['deductenough']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>商城满额立减：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['deductenough'],2)}}</td>
                </tr>
                {/if}
                {if $item['merchdeductenough']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>商户满额立减：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['merchdeductenough'],2)}}</td>
                </tr>
                {/if}
                {if $item['couponprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>优惠券优惠：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['couponprice'],2)}}</td>
                </tr>
                {/if}
                {if $item['isdiscountprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>促销优惠：</td>
                    <td  style='border:none;text-align:right;;'>-￥{{number_format( $item['isdiscountprice'],2)}}</td>
                </tr>
                {/if}
                {if intval($item['changeprice'])!=0}
                <tr>
                    <td  style='border:none;text-align:right;'>卖家改价：</td>
                    <td  style='border:none;text-align:right;;'><span style='{if 0<$item['changeprice']}color:green{else}color:red{/if}'>{if 0<$item['changeprice']}+{else}-{/if}￥{{ number_format(abs($item['changeprice']),2)}}</span></td>
                </tr>
                {/if}
                {if intval($item['changedispatchprice'])!=0}
                <tr>
                    <td  style='border:none;text-align:right;'>卖家改运费：</td>
                    <td  style='border:none;text-align:right;;'><span style='{if 0<$item['changedispatchprice']}color:green{else}color:red{/if}'>{if 0<$item['changedispatchprice']}+{else}-{/if}￥{{abs($item['changedispatchprice'])}}</span></td>
                </tr>
                {/if}
                <tr>
                    <td style='border:none;text-align:right;'>应收款：</td>
                    <td  style=`'border:none;text-align:right;color:green;'>￥{{number_format($item['price'],2)}}</td>
                </tr>

            </table>
"
                                        ><i class='fa fa-question-circle'></i></a>
                                        @if($item['dispatchprice']>0)
                                        <br/>(含运费:￥{{number_format( $item['dispatchprice'],2)}})
                                       @endif


                                    </td>
                                    <td  rowspan="{{count($item['goods'])}}" style='text-align:center' >
                                        {{date('Y-m-d',$item['createtime'])}}<br/>{{date('H:i:s',$item['createtime'])}}

                                    </td>

                                    <td   rowspan="{{count($item['goods'])}}" class='ops' style='line-height:20px;text-align:center' ><span class='text-{$item['statuscss']}'>{{$item['status']}}</span><br />
                                    </td>

                                    @endif
                                </tr>
                                @endforeach
                                @if(!empty($item['remark']))
                                <tr ><td colspan='8' style='background:#fdeeee;color:red;'>买家备注: {{$item['remark']}}</td></tr>
                                @endif
                                @if(!empty($level) || (!empty($item['merchname']) && $item['merchid'] > 0))
                                <tr style=";border-bottom:none;background:#f9f9f9;">
                                    <td colspan='4' style='text-align:left'>
                                        @if(!empty($item['merchname']) && $item['merchid'] > 0)
                                        商户名称:<span class="text-info">{{$item['merchname']}}</span>
                                        @endif
                                        @if(!empty($agentid) &&1==2)
                                        <b>分销订单级别:</b> {{$item['level']}}级 <b>分销佣金:</b> {{$item['commission']}} 元
                                        @endif
                                    </td>
                                    <td colspan='4' style='text-align:right'>
                                        @if(empty($agentid) &&1==2)
                                        @if($item['commission1']!=-1)<b>1级佣金:</b> {{$item['commission1']}} 元 @endif
                                        @if($item['commission2']!=-1)<b>2级佣金:</b> {{$item['commission2']}} 元 @endif
                                        @if($item['commission3']!=-1)<b>3级佣金:</b> {{$item['commission3']}} 元 @endif
                                        @endif

                                        @if(!empty($item['agentid']) && !$is_merch[$item['id']] &&1==2)
                                        @if(true)
                                         <a data-toggle="ajaxModal"  href="{php echo webUrl('commission/apply/changecommission', array('id' => $item['id']))}">修改佣金</a>
                                        @endif
                                        @endif
                                    </td></tr>
                                    @endif
                                @endforeach
                            </table>
                            {{--{{ $list->links() }}--}}
                        @else
                        <div class='panel panel-default'>
                            <div class='panel-body' style='text-align: center;padding:30px;'>
                                暂时没有任何订单!
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection