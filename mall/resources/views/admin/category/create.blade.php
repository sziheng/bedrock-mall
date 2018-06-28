@extends('admin.layout.main')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>商品管理</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>商品管理 <small>分类添加</small></h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" novalidate action="/web/category"  method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id">
                                <span class="section">分类信息</span>

                           {{--     <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">分类链接(点击复制)
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="" class="form-controlcol-md-7 col-xs-12">https:www.baidu.com</a>
                                    </div>
                                </div>--}}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">排序
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="displayorder" value="" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="displayorder"  value="0" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">分类名称 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="name" value="" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">分类描述
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" value="" id="description" name="description" class="form-controlcol-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">分类图片
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="wrapper">
                                        {{--  <input type="file" id="thumb" class="file" name="thumb" >--}}
                                        <input id="fileUpload" type="file" name="thumb" value="" /><br />
                                        <div id="image-holder">

                                        </div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">分类广告链接 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" id="advurl" name="advurl"  value="" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">是否显示
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label>
                                            <input type="checkbox" class="js-switch"  checked  name="ishome" class="form-controlcol-md-7 col-xs-12" />
                                        </label>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Cancel</button>
                                        <button id="send" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    </script>
@endsection





