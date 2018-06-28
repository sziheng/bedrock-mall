@extends('admin.layout.main')
@section('content')
    <link href="/resource/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
    <style>
        .label{
            display:inline-block;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>彩虹卡管理 <small>彩虹卡列表</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form action="/web/rainbowCard/getCardList" method="get" class="form-horizontal form-search" role="form">
                                <div class="page-toolbar row m-b-sm m-t-sm">
                                    <div class="col-sm-3">
                                        <div class="input-group-btn">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pull-right" >
                                        <select name="cardId" class='form-control input-sm select-sm select2 width:160px;display: inline-block' style="width:150px;" data-placeholder="活动名称">
                                            <option value="0" >活动名称</option>
                                            @foreach($activities as $val)
                                            <option value="{{$val->id}}" @if($request->cardId == $val->id) selected @endif >{{$val['activityname']}}</option>
                                            @endforeach
                                        </select>
                                        <select name='followed' class='form-control  input-sm select-md' style="width:140px;display: inline-block">
                                            <option value='-1'>关注</option>
                                            <option value='0' @if($request->status == '0') selected @endif>未使用</option>
                                            <option value='1' @if($request->status == '1') selected @endif>已使用</option>
                                            <option value='2' @if($request->status == '2') selected @endif>已禁用</option>
                                        </select>

                                        <div class="input-group" style="width:300px;display:inline-block;">

                                            <input style="width:200px;display:inline-block;margin-top:-3px" type="text" class="input-sm form-control" name='keyword' value="{{$request->cardNo}}" placeholder="彩虹卡卡号" style="width:200px"> <span class="input-group-btn" style="width:50px;display:inline-block;margin-top:-3px">

                                                <button class="btn btn-sm btn-primary" type="submit" > 搜索</button> </span>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            @if(isset($cardList) && ($cardList->toArray())['total'])
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <th class="column-title">序号</th>
                                            <th class="column-title">卡号 </th>
                                            <th class="column-title">状态</th>
                                            <th class="column-title">会员昵称</th>
                                            <th class="column-title">订单号 </th>
                                            <th class="column-title">兑换日期</th>
                                            <th class="column-title no-link last"><span class="nobr">操作</span>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($cardList as $card)
                                            <tr class="even pointer">
                                                <td class=" " style="vertical-align:middle">
                                                    {{$card->order}}
                                                </td>
                                                <td class=" " style="vertical-align:middle">
                                                  {{$card->ticketsn}}
                                                </td>
                                                <td style="vertical-align:middle">
                                                    @if($card->status == 0)
                                                        未使用
                                                    @elseif($card->status ==1)
                                                        已使用
                                                    @else
                                                        已关闭
                                                    @endif
                                                <td style="vertical-align:middle">
                                                    {{$card->changer}}
                                                </td>
                                                <td class=""  style="vertical-align:middle">
                                                    @foreach($card->orderlist as $val)
                                                        <a href="">{{$val['ordersn']}}</a><br/>
                                                    @endforeach
                                                </td>
                                                <td class=" " style="vertical-align:middle">
                                                    @if($card->exchangetime > 0)
                                                        {{date('Y-m-d H:i:s',$card->exchangetime)}}
                                                    @endif
                                                </td>
                                                <td class=" last" style="vertical-align:middle">
                                                  <span class='btn  btn-sm  @if($card->status==0) btn-primary layer @elseif($card->status == 1) btn-default @else btn-default layer @endif'
                                                        data-content = "确认是@if($card->status==0)关闭 @else 开启 @endif 此卡号么？"
                                                        data-url = "/web/rainbowCard/changeDidable"
                                                        data-params = "@if($card->status==0)2 @else 0 @endif"
                                                        data-type ="one"
                                                        data-id = "{{$card->id}}"
                                                  >
                                                    @if($card->status == 0)关闭 @elseif($card->status == 1) 已使用 @else 开启 @endif</span>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $cardList->links() }}
                            @else
                                <div class="table-responsive">
                                    <div style="height:200px">
                                        <div style="line-height:200px;width:200px;margin:0 auto">
                                            暂无数据
                                        </div>

                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.select2').select2({
            })
        })
    </script>
@endsection



