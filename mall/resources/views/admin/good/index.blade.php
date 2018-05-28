@extends('admin.layout.main')
@section('content')
    <style>
        td{vertical-align:middle}
        .table>thead>tr>td{vertical-align:middle}
        .goodul{list-style:none;float:right;text-align: right:width:80%;padding-right:20px}
        .goodul li{float:left;width:70px};
    </style>
    <script src="/layer.js"></script>

    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>商品管理 <small>商品列表</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="/good" method="get" class="form-horizontal form-search" role="form">
                                <input type="hidden" name="status" value="{{$request->status}}">
                                <div class="page-toolbar row m-b-sm m-t-sm">
                                    <div class="col-sm-3">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default btn-sm layer"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>
                                            @if($request->status == 'sale')
                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认全部下架？"
                                                        data-url = "/good/status"
                                                        data-params = "0"
                                                        data-type = "list"><i class='fa fa-circle-o'></i> 下架</button>
                                            @endif
                                            @if($request->status  == 'stock')
                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认全部上架？"
                                                        data-url = "/good/status"
                                                        data-params = "1"
                                                        data-type = "list"><i class='fa fa-circle'></i> 上架</button>
                                            @endif
                                            @if($request->status  == 'cycle')
                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "如果商品存在购买记录，会无法关联到商品, 确认要彻底删除吗？"
                                                        data-url = "/good/physicsDelete"
                                                        data-params = "1"
                                                        data-type ="list"><i class='fa fa-remove'></i> 彻底删除</button>
                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认要恢复？"
                                                        data-url = "/good/delete"
                                                        data-params = "0"
                                                        data-type ="list"><i class='fa fa-reply'></i> 恢复到仓库</button>
                                            @else
                                                <button class="btn btn-default btn-sm layer" type="button"
                                                        data-content = "确认要全部删除？"
                                                        data-url = "/good/delete"
                                                        data-params = "1"
                                                        data-type ="list"
                                                        ><i class='fa fa-trash'></i> 删除</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pull-right">

                                        <select id="sheng" name='province'  class="input-sm form-control" style='width:90px;display: inline-block' >

                                            @if($request->province)
                                                <option value="{{$provinces[0]->Add_Code}}" selected="true">{{$provinces[0]->Add_Name}}</option>
                                            @else
                                                <option value="" selected="true">省/直辖市</option>
                                            @endif
                                        </select>
                                        <select id="shi" name='city'   class="input-sm form-control" style='width:90px;display: inline-block' >
                                            @if($request->city)
                                                @foreach($citys as $city)
                                                    <option value="{{$city->Add_Code}}" @if($city->Add_Code == $provinces[1]->Add_Code)selected="true" @endif>{{$city->Add_Name}}</option>
                                                @endforeach
                                            @else
                                                <option value="" selected="true">请选择</option>
                                            @endif

                                        </select>
                                        <select id="qu" name='area'  class="input-sm form-control" style='width:90px;display: inline-block;margin-right: 3px;' >
                                            @if($request->area)
                                                @foreach($areas as $area)
                                                    <option value="{{$area->Add_Code}}" @if($area->Add_Code == $provinces[2]->Add_Code) selected="true" @endif>{{$area->Add_Name}}</option>
                                                @endforeach
                                            @else
                                                <option value="" selected="true">请选择</option>
                                            @endif
                                        </select>

                                        <select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">

                                            <option value="" >商品分类</option>
                                            @foreach($categorys as $category)
                                                <option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>

                                        <div class="input-group" style="width:300px;display:inline-block;">
                                            <input style="width:200px;display:inline-block;margin-top:-3px" type="text" class="input-sm form-control" name='keyword' value="{{$request->keyword}}" placeholder="ID/名称/编号/条码/商户名称" style="width:200px"> <span class="input-group-btn" style="width:50px;display:inline-block;margin-top:-3px">

                                                <button class="btn btn-sm btn-primary" type="submit" > 搜索</button> </span>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" id="check-all" class="flat">
                                        </th>
                                        <th class="column-title">排序</th>
                                        <th class="column-title" style="width:50px">商品 </th>
                                        <th class="column-title"> </th>
                                        <th class="column-title">价格 </th>
                                        <th class="column-title">库存 </th>
                                        <th class="column-title">销量 </th>
                                        @if($request->status != 'cycle')
                                            <th class="column-title">状态 </th>
                                        @else
                                            <th class="column-title" style="width:13%"></th>
                                        @endif
                                        <th class="column-title no-link last"><span class="nobr">Action</span>
                                        </th>
                                        <th class="bulk-actions" colspan="7">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($goods as $good)
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
                                                    <span class="text-info" style="color:#ed5565">[{{object_get($good->categories,'name','暂无分类')}}]</span><br/>
                                                @endif
                                                    {{$good->title}}
                                            </td>
                                            <td class=""  style="vertical-align:middle">{{$good->marketprice}}<i class="success fa fa-long-arrow-up"></i></td>
                                            <td class=" " style="vertical-align:middle">{{$good->total}}</td>
                                            <td class=" " style="vertical-align:middle">{{$good->salesreal}}</td>
                                            @if($request->status != 'cycle')
                                            <td class="a-right a-right " style="vertical-align:middle">
                                                @if($request->status!='cycle')
                                                    <span class='btn  btn-sm layer  @if($good->status==1) btn-primary @else btn-default @endif'
                                                    data-content = "确认是@if($good->status==1)下架 @else 上架 @endif？"
                                                    data-url = "/good/status"
                                                    data-params = "@if($good->status==1)0 @else 1 @endif"
                                                    data-type ="one"
                                                    data-id = "{{$good->id}}"
                                                    >
                                                    @if($good->status==1)上架 @else 下架@endif</span>
                                                    <span class='btn  btn-sm layer @if($good->checked==0) btn-primary @else btn-default @endif'
                                                    data-content = "确认是@if($good->checked==0) 审核中 @else 审核通过 @endif？"
                                                    data-url = "/good/checked"
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
                                                <a  class='btn btn-default btn-sm' href="{php echo webUrl('goods/edit', array('id' => $item['id'],'goodsfrom'=>$goodsfrom,'page'=>$page))}" ><i class='fa fa-edit'></i> 编辑</a>
                                                @if($request->status=='cycle')
                                                <a  class='btn btn-default btn-sm layer'
                                                    data-content = "确认要恢复？"
                                                    data-url = "/good/delete"
                                                    data-params = "0"
                                                    data-type ="one"
                                                    data-id = "{{$good->id}}"><i class='fa fa-reply'></i> 恢复到仓库</a>
                                                <a  class='btn btn-default btn-sm layer'
                                                    data-content = "如果商品存在购买记录，会无法关联到商品, 确认要彻底删除吗？"
                                                    data-url = "/good/physicsDelete"
                                                    data-params = "1"
                                                    data-type ="one"
                                                    data-id = "{{$good->id}}"></i> 彻底删除</a>
                                                @else
                                                <a  class='btn btn-default btn-sm layer'
                                                    data-content = "确认是删除？"
                                                    data-url = "/good/delete"
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
                                                    @if($good->merchUser->merchname)
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $()
    </script>
@endsection



