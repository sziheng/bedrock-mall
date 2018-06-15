@extends('admin.layout.main')
@section('content')
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

                            <form action="/web/good" method="get" class="form-horizontal form-search" role="form">
                                <div class="page-toolbar row m-b-sm m-t-sm">
                                    <div class="col-sm-3">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default btn-sm layer"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>

                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认拉进黑名单么？"
                                                        data-url = "/web/good/status"
                                                        data-params = "0"
                                                        data-type = "list"><i class='fa fa-circle-o'></i> 设置黑名单</button>


                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认取消黑名单么？"
                                                        data-url = "/web/good/status"
                                                        data-params = "1"
                                                        data-type = "list"><i class='fa fa-circle'></i> 取消黑名单</button>

                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认要全部删除？"
                                                        data-url = "/web/good/delete"
                                                        data-params = "1"
                                                        data-type ="list"
                                                ><i class='fa fa-trash'></i> 删除</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 pull-right" >
                                      {{--  <select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">

                                            <option value="" >商品分类</option>
                                            @foreach($categorys as $category)
                                                <option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">

                                            <option value="" >商品分类</option>
                                            @foreach($categorys as $category)
                                                <option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">

                                            <option value="" >商品分类</option>
                                            @foreach($categorys as $category)
                                                <option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">

                                            <option value="" >商品分类</option>
                                            @foreach($categorys as $category)
                                                <option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>

                                        <select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">

                                            <option value="" >商品分类</option>
                                            @foreach($categorys as $category)
                                                <option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>--}}

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
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">粉丝</th>
                                            <th class="column-title" style="width:50px">会员信息 </th>
                                            <th class="column-title">等级/分组</th>
                                            <th class="column-title">注册时间</th>
                                            <th class="column-title">积分/余额 </th>
                                            <th class="column-title">成交</th>
                                            <th class="column-title">关注/黑名单 </th>
                                            <th class="column-title no-link last"><span class="nobr">操作</span>
                                            </th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($members as $member)
                                            <tr class="even pointer">
                                                <td class="a-center " style="vertical-align:middle">
                                                    <input type="checkbox" class="ids flat" name="table_records" data-id="{{$good->id}}">
                                                </td>
                                                <td class=" " style="vertical-align:middle">
                                                    {{$good->displayorder}}
                                                </td>
                                                <td class=" " style="vertical-align:middle">
                                                    <img src="/storage/2018-05-17/5ZargryrgTHEkjnoUaQukVRU5URzCnBGK1PGcJtN.jpeg" alt="" style="width:40px;height:40px">
                                                </td>
                                                <td style="vertical-align:middle">
                                                    @if($good->pcate>0)
                                                        <span class="text-info" style="color:#ed5565">[{{object_get($good->categories, 'name', '暂无分类')}}]</span><br/>
                                                    @endif
                                                    {{$good->title}}
                                                </td>
                                                <td class=""  style="vertical-align:middle">{{$good->marketprice}}<i class="success fa fa-long-arrow-up"></i></td>
                                                <td class=" " style="vertical-align:middle">{{$good->total}}</td>.
                                                <td class=" " style="vertical-align:middle">{{$good->salesreal}}</td>
                                                @if($request->status != 'cycle')
                                                    <td class="a-right a-right " style="vertical-align:middle">
                                                        @if($request->status!='cycle')
                                                            <span class='btn  btn-sm layer  @if($good->status==1) btn-primary @else btn-default @endif'
                                                                  data-content = "确认是@if($good->status==1)下架 @else 上架 @endif？"
                                                                  data-url = "/web/good/status"
                                                                  data-params = "@if($good->status==1)0 @else 1 @endif"
                                                                  data-type ="one"
                                                                  data-id = "{{$good->id}}"
                                                            >
                                                    @if($good->status==1)上架 @else 下架@endif</span>
                                                            <span class='btn  btn-sm layer @if($good->checked==0) btn-primary @else btn-default @endif'
                                                                  data-content = "确认是@if($good->checked==0) 审核中 @else 审核通过 @endif？"
                                                                  data-url = "/web/good/checked"
                                                                  data-params = "@if($good->checked==0)1 @else 0 @endif"
                                                                  data-type ="one"
                                                                  data-id = "{{$good->id}}"
                                                            >
                                                    @if($good->checked==1)审核中 @else 通过 @endif</span>
                                                        @else

                                                        @endif
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif

                                                <td class=" last" style="vertical-align:middle">
                                                    <a  class='btn btn-default btn-sm' href="/web/good/{{$good->id}}/edit" ><i class='fa fa-edit'></i> 编辑</a>
                                                    @if($request->status=='cycle')
                                                        <a  class='btn btn-default btn-sm layer'
                                                            data-content = "确认要恢复？"
                                                            data-url = "/web/good/delete"
                                                            data-params = "0"
                                                            data-type ="one"
                                                            data-id = "{{$good->id}}"><i class='fa fa-reply'></i> 恢复到仓库</a>
                                                        <a  class='btn btn-default btn-sm layer'
                                                            data-content = "如果商品存在购买记录，会无法关联到商品, 确认要彻底删除吗？"
                                                            data-url = "/web/good/physicsDelete"
                                                            data-params = "1"
                                                            data-type ="one"
                                                            data-id = "{{$good->id}}"></i> 彻底删除</a>
                                                    @else
                                                        <a  class='btn btn-default btn-sm layer'
                                                            data-content = "确认是删除？"
                                                            data-url = "/web/good/delete"
                                                            data-params = "1"
                                                            data-type ="one"
                                                            data-id = "{{$good->id}}">
                                                            <i class='fa fa-trash'></i> 删除</a>
                                                    @endif

                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: left;border-top:none;padding:5px 0;">
                                                    @if($good->merchid >0)
                                                        @if(object_get($good->merchUser,'merchname',''))
                                                            <span class="text-default" style="margin-left: 190px;">商户名称:</span><span class="text-info">{{$good->merchUser->merchname}}</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td colspan="@if($request->status == 'cycle') 5 @else 5 @endif" style="text-align: right;border-top:none;padding:5px 0;">
                                                    <ul class="goodul">
                                                        <li><a href="#" class="@if($good->isnew == 1) text-danger @endif">新品</a></li>
                                                        <li><a href="#" class="@if($good->ishot == 1) text-danger @endif">热卖</a></li>
                                                        <li><a href="#" class="@if($good->isrecommand == 1) text-danger @endif">推荐</a></li>
                                                        <li><a href="#" class="@if($good->isdiscount == 1) text-danger @endif">促销</a></li>
                                                        <li><a href="#" class="@if($good->issendfree == 1) text-danger @endif">包邮</a></li>
                                                        <li><a href="#" class="@if($good->istime == 1) text-danger @endif">限时卖</a></li>
                                                        <li><a href="#" class="@if($good->isnodiscount == 1) text-danger @endif">不打折</a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $goods->links() }}
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



