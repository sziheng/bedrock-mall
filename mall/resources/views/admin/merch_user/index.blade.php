@extends('admin.layout.main')
@section('content')
    <script src="/layer.js"></script>

    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>供应商管理 <small>供应商列表</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            {{--<form action="/good" method="get" class="form-horizontal form-search" role="form">--}}
                                {{--<input type="hidden" name="status" value="{{$request->status}}">--}}
                                {{--<div class="page-toolbar row m-b-sm m-t-sm">--}}
                                    {{--<div class="col-sm-3">--}}
                                        {{--<div class="input-group-btn">--}}
                                            {{--<button class="btn btn-default btn-sm layer"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>--}}
                                            {{--@if($request->status == 'sale')--}}
                                                {{--<button class="btn btn-default btn-sm layer" type="button"--}}
                                                        {{--data-content = "确认全部下架？"--}}
                                                        {{--data-url = "/good/status"--}}
                                                        {{--data-params = "0"--}}
                                                        {{--data-type = "list"><i class='fa fa-circle-o'></i> 下架</button>--}}
                                            {{--@endif--}}
                                            {{--@if($request->status  == 'stock')--}}
                                                {{--<button class="btn btn-default btn-sm layer" type="button"--}}
                                                        {{--data-content = "确认全部上架？"--}}
                                                        {{--data-url = "/good/status"--}}
                                                        {{--data-params = "1"--}}
                                                        {{--data-type = "list"><i class='fa fa-circle'></i> 上架</button>--}}
                                            {{--@endif--}}
                                            {{--@if($request->status  == 'cycle')--}}
                                                {{--<button class="btn btn-default btn-sm layer" type="button"--}}
                                                        {{--data-content = "如果商品存在购买记录，会无法关联到商品, 确认要彻底删除吗？"--}}
                                                        {{--data-url = "/good/physicsDelete"--}}
                                                        {{--data-params = "1"--}}
                                                        {{--data-type ="list"><i class='fa fa-remove'></i> 彻底删除</button>--}}
                                                {{--<button class="btn btn-default btn-sm layer" type="button"--}}
                                                        {{--data-content = "确认要恢复？"--}}
                                                        {{--data-url = "/good/delete"--}}
                                                        {{--data-params = "0"--}}
                                                        {{--data-type ="list"><i class='fa fa-reply'></i> 恢复到仓库</button>--}}
                                            {{--@else--}}
                                                {{--<button class="btn btn-default btn-sm layer" type="button"--}}
                                                        {{--data-content = "确认要全部删除？"--}}
                                                        {{--data-url = "/good/delete"--}}
                                                        {{--data-params = "1"--}}
                                                        {{--data-type ="list"--}}
                                                        {{--><i class='fa fa-trash'></i> 删除</button>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-6 pull-right">--}}

                                        {{--<select id="sheng" name='province'  class="input-sm form-control" style='width:90px;display: inline-block' >--}}

                                            {{--@if($request->province)--}}
                                                {{--<option value="{{$provinces[0]->Add_Code}}" selected="true">{{$provinces[0]->Add_Name}}</option>--}}
                                            {{--@else--}}
                                                {{--<option value="" selected="true">省/直辖市</option>--}}
                                            {{--@endif--}}
                                        {{--</select>--}}
                                        {{--<select id="shi" name='city'   class="input-sm form-control" style='width:90px;display: inline-block' >--}}
                                            {{--@if($request->city)--}}
                                                {{--@foreach($citys as $city)--}}
                                                    {{--<option value="{{$city->Add_Code}}" @if($city->Add_Code == $provinces[1]->Add_Code)selected="true" @endif>{{$city->Add_Name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<option value="" selected="true">请选择</option>--}}
                                            {{--@endif--}}

                                        {{--</select>--}}
                                        {{--<select id="qu" name='area'  class="input-sm form-control" style='width:90px;display: inline-block;margin-right: 3px;' >--}}
                                            {{--@if($request->area)--}}
                                                {{--@foreach($areas as $area)--}}
                                                    {{--<option value="{{$area->Add_Code}}" @if($area->Add_Code == $provinces[2]->Add_Code) selected="true" @endif>{{$area->Add_Name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<option value="" selected="true">请选择</option>--}}
                                            {{--@endif--}}
                                        {{--</select>--}}

                                        {{--<select name="cate" class='form-control input-sm select-sm select2' style="width:150px;display: inline-block" data-placeholder="商品分类">--}}

                                            {{--<option value="" >商品分类</option>--}}
                                            {{--@foreach($categorys as $category)--}}
                                                {{--<option value="{{$category->id}}" @if($category->id == $request->cate) selected @endif >{{$category->name}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}

                                        {{--<div class="input-group" style="width:300px;display:inline-block;">--}}
                                            {{--<input style="width:200px;display:inline-block;margin-top:-3px" type="text" class="input-sm form-control" name='keyword' value="{{$request->keyword}}" placeholder="ID/名称/编号/条码/商户名称" style="width:200px"> <span class="input-group-btn" style="width:50px;display:inline-block;margin-top:-3px">--}}

                                                {{--<button class="btn btn-sm btn-primary" type="submit" > 搜索</button> </span>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</form>--}}

                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">ID</th>
                                            <th class="column-title" style="width:200px;">供应商名称</th>
                                            <th class="column-title" style="width:230px;">主营范围</th>
                                            <th class="column-title">负责人 </th>
                                            <th class="column-title">电话 </th>
                                            <th class="column-title">加入时间 </th>
                                            <th class="column-title">状态 </th>
                                            <th class="column-title no-link last"><span class="nobr">操作</span></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($merchUsers as $merchUser)
                                        <tr class="even pointer">
                                            <td class=" " style="vertical-align:middle">{{$merchUser->id}}</td>
                                            <td style="vertical-align:middle;">{{$merchUser->merchname}}</td>
                                            <td class=""  style="vertical-align:middle;">{{$merchUser->salecate}}</td>
                                            <td class=" " style="vertical-align:middle">{{$merchUser->realname}}</td>
                                            <td class=" " style="vertical-align:middle">{{$merchUser->mobile}}</td>
                                            <td class=" " style="vertical-align:middle">{{date('Y-m-d H:i:s',$merchUser->jointime)}}</td>
                                            <td class="a-right a-right " style="vertical-align:middle">
                                                @if($merchUser->status == 1)
                                                    <button type="button" class="btn btn-round btn-primary">已入驻</button>
                                                @else
                                                    <button type="button" class="btn btn-round btn-warning">待审核</button>
                                                @endif
                                            </td>

                                            <td class=" last" style="vertical-align:middle">
                                                <a  class='btn btn-default btn-sm' href="{{route('webMerchUserGetEdit', ['id' => $merchUser->id])}}" ><i class='fa fa-edit'></i> 编辑</a >
                                                <a  class='btn btn-default btn-sm layer' data-content = "确认是删除？"
                                                    data-url = "{{route('webMerchUserDelete', ['id' => $merchUser->id])}}"
                                                    data-params = "1"
                                                    data-type ="one"
                                                     ><i class='fa fa-trash'></i> 删除</a >
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



