@extends('admin.layout.main')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>商品管理 <small>商品分类</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <a href="/web/category/create" class="btn btn-primary" type="button" style="float:right">添加分类</a>
                        <div class="x_content">

                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">

                                        <th class="column-title" style="width:15%">id </th>
                                        <th class="column-title" style="width:60%">名称 </th>
                                        <th class="column-title no-link last"><span class="nobr">操作</span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($categorys as $category)
                                        <tr class="even pointer">
                                            <td class=" ">{{$category->id}}</td>
                                            <td class=" ">{{$category->name}}</td>
                                            <td class=" last">
                                                <button data-id="{{$category->id}}" type="button" class="btn  btn-sm  ishome @if($category->ishome)btn-info @else btn-default @endif " @if($category->ishome) data-ishome="0" @else data-ishome="1" @endif>@if($category->ishome)显示@else隐藏@endif</button>
                                                <a  class='btn btn-default btn-sm' href="/web/category/{{$category->id}}/edit" ><i class='fa fa-edit'></i> 编辑</a>
                                                <a  class = "btn btn-default btn-sm layer"
                                                    data-content = "确认要删除该分类吗？"
                                                    data-url = "/web/category/{{$category->id}}/delete"
                                                    data-params = "1"
                                                    data-type ="one"
                                                    data-id = "{{$category->id}}">
                                                    <i class='fa fa-remove'></i> 删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $categorys->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.ishome').click(function(){
            var t = $(this);
            var id = $(this).data('id');
            if (t.html() == '隐藏') {
                ishome = 1;
            } else {
                ishome = 0
            }
            $.post("/web/category/"+id+"/ishome",{ishome:ishome},function(result){
                if (result.error){
                    alert(result.msg)
                }else{
                    if(ishome == 1){
                        t.attr('class','btn ishome btn-info  btn-sm');
                        t.html('显示')
                    } else {
                        t.attr('class','btn ishome btn-default  btn-sm')
                        t.html('隐藏')
                    }

                }
            });
        })
    </script>
@endsection