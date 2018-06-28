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
                            <h2>会员管理 <small>会员列表</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="/web/member/getList" method="get" class="form-horizontal form-search" role="form">
                                <div class="page-toolbar row m-b-sm m-t-sm">
                                    <div class="col-sm-3">
                                        <div class="input-group-btn">

                                          {{--  <button class="btn btn-default btn-sm layer"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>
                                                 <button class="btn btn-default btn-sm layer" type="button"
                                                    data-content = "确认取消黑名单么？"
                                                    data-url = "/web/member/changeBlack"
                                                    data-params = "0"
                                                    data-type = "list"><i class='fa fa-circle'></i> 取消黑名单</button>
                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认取消黑名单么？"
                                                        data-url = "/web/member/changeBlack"
                                                        data-params = "0"
                                                        data-type = "list"><i class='fa fa-circle'></i> 取消黑名单</button>

                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认要全部删除？"
                                                        data-url = "/web/member/delete"
                                                        data-params = "1"
                                                        data-type ="list"
                                                ><i class='fa fa-trash'></i> 删除</button>--}}
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pull-right" >
                                        <select name='followed' class='form-control  input-sm select-md' style="width:140px;display: inline-block">
                                            <option value=''>关注</option>
                                            <option value='0' @if($request->followed == '0') selected @endif>未关注</option>
                                            <option value='1' @if($request->followed == '1') selected @endif>已关注</option>
                                            <option value='2' @if($request->followed == '2') selected @endif>取消关注</option>
                                        </select>

                                        <div class="input-group" style="width:300px;display:inline-block;">

                                            <input style="width:200px;display:inline-block;margin-top:-3px" type="text" class="input-sm form-control" name='keyword' value="{{$request->keyword}}" placeholder="ID/名称/编号/条码/商户名称" style="width:200px"> <span class="input-group-btn" style="width:50px;display:inline-block;margin-top:-3px">

                                                <button class="btn btn-sm btn-primary" type="submit" > 搜索</button> </span>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            @if(isset($members) && ($members->toArray())['total'])
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                           {{-- <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>--}}
                                            <th class="column-title">粉丝</th>
                                            <th class="column-title" style="width:50px">会员信息 </th>
                                            <th class="column-title">等级/分组</th>
                                            <th class="column-title">注册时间</th>
                                            <th class="column-title">余额 </th>
                                            <th class="column-title">成交</th>
                                            <th class="column-title">关注 </th>
                                            <th class="column-title no-link last"><span class="nobr">操作</span>
                                            </th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($members as $member)
                                            <tr class="even pointer">
                                             {{--   <td class="a-center " style="vertical-align:middle">
                                                    <input type="checkbox" class="ids flat" name="table_records" data-id="{{$member->id}}">
                                                </td>--}}
                                                <td class=" " style="vertical-align:middle">
                                                    <div>
                                                        @if($member->avatar)
                                                            <img src='{{$member->avatar}}' style='width:30px;height:30px;padding1px;border:1px solid #ccc' />
                                                        @endif

                                                        @if($member->nickname)
                                                            {{$member->nickname}}
                                                        @else
                                                            未更新
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class=" " style="vertical-align:middle">
                                                    {{$member->realname}}<br/>{{$member->mobile}}
                                                </td>
                                                <td style="vertical-align:middle">
                                                    @if(!$member->levelname)普通会员 @else {{$member->levelname}} @endif
                                                    <br/>@if(!$member->groupname)无分组 @else {{$member->groupname}}@endif</td>
                                                <td style="vertical-align:middle">
                                                    {{date('Y-m-d', object_get($member, 'createtime', 0))}}<br/> {{date('H:i:s', object_get($member, 'createtime', 0))}}
                                                </td>
                                                <td class=""  style="vertical-align:middle">
                                                    <span class='btn  btn-sm  btn-primary'>余额: {{intval($member->credit2)}}</span>
                                                </td>
                                                <td class=" " style="vertical-align:middle">
                                                    <span class='btn  btn-sm  btn-primary'>订单: {{$member->ordercount}}<br/>金额: {{round($member->ordermoney,2)}}</span>
                                                </td>

                                                <td class=" " style="vertical-align:middle">
                                                    @if(!$member->followed)
                                                        @if(!$member->uid)
                                                            <span class='btn  btn-sm  btn-default'>未关注</span>
                                                        @else
                                                            <span class='btn  btn-sm  btn-warning'>取消关注</span>
                                                        @endif
                                                    @else
                                                        <span class='btn  btn-sm  btn-primary'>已关注</span>
                                                    @endif
                                                      {{--  <br/>
                                                        <label class="label @if($member->isblack == 1)label-default @else label-primary @endif layer" type="button"
                                                               data-content = "确认@if($member->isblack==0) 拉入黑名单么 @else 恢复正常么 @endif？"
                                                               data-url = "/web/member/changeBlack"
                                                               data-params = "@if($member->isblack==0)1 @else 0 @endif"
                                                               data-type ="one"
                                                               data-id = "{{$member->id}}">@if($member->isblack==1)黑名单 @else 正常 @endif</label>--}}
                                                </td>
                                                <td class=" last" style="vertical-align:middle">
                                                    <a  class='btn btn-default btn-sm' href="/web/member/{{$member->id}}" ><i class='fa fa-edit'></i> 编辑</a>
                                                    <a  class = "btn btn-default btn-sm layer"
                                                        data-content = "确认要删除该会员吗？"
                                                        data-url = "/web/member/delete"
                                                        data-params = "1"
                                                        data-type ="one"
                                                        data-id = "{{$member->id}}">
                                                        <i class='fa fa-remove'></i> 删除</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $members->links() }}
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
@endsection



