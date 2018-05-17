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
                        <button class="btn btn-primary" type="button" style="float:right">添加分类</button>
                        <div class="x_content">

                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">

                                        <th class="column-title">id </th>
                                        <th class="column-title">名称 </th>
                                        <th class="column-title no-link last"><span class="nobr">操作</span>
                                        </th>
                                        <th class="bulk-actions" colspan="7">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($categorys as $category)
                                        <tr class="even pointer">
                                            <td class=" ">{{$category->id}}</td>
                                            <td class=" ">{{$category->name}}</td>
                                            <td class=" last"><a href="#">View</a>
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
@endsection