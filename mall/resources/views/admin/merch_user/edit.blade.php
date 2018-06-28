@extends('admin.layout.main')
@section('content')

    <link href="/resource/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
    <script src="/resource/datetimepicker/jquery.datetimepicker.js"></script>
    <script src="/fileupload/js/vendor/jquery.ui.widget.js"></script>
    <script src="/fileupload/js/jquery.iframe-transport.js"></script>
    <script src="/fileupload/js/jquery.fileupload.js"></script>
    <style>
        .tabs-below > .nav-tabs,
        .tabs-right > .nav-tabs,
        .tabs-left > .nav-tabs {
            border-bottom: 0;
        }

        .tab-content > .tab-pane,
        .pill-content > .pill-pane {
            display: none;
        }

        .tab-content > .active,
        .pill-content > .active {
            display: block;
        }

        .tabs-below > .nav-tabs {
            border-top: 1px solid #ddd;
        }

        .tabs-below > .nav-tabs > li {
            margin-top: -1px;
            margin-bottom: 0;
        }

        .tabs-below > .nav-tabs > li > a {
            -webkit-border-radius: 0 0 4px 4px;
            -moz-border-radius: 0 0 4px 4px;
            border-radius: 0 0 4px 4px;
        }

        .tabs-below > .nav-tabs > li > a:hover,
        .tabs-below > .nav-tabs > li > a:focus {
            border-top-color: #ddd;
            border-bottom-color: transparent;
        }

        .tabs-below > .nav-tabs > .active > a,
        .tabs-below > .nav-tabs > .active > a:hover,
        .tabs-below > .nav-tabs > .active > a:focus {
            border-color: transparent #ddd #ddd #ddd;
        }

        .tabs-left > .nav-tabs > li,
        .tabs-right > .nav-tabs > li {
            float: none;
        }

        .tabs-left > .nav-tabs > li > a,
        .tabs-right > .nav-tabs > li > a {
            min-width: 74px;
            margin-right: 0;
            margin-bottom: 3px;
        }

        .tabs-left > .nav-tabs {
            float: left;
            margin-right: 19px;
            border-right: 1px solid #ddd;
        }

        .tabs-left > .nav-tabs > li > a {
            margin-right: -1px;
            -webkit-border-radius: 4px 0 0 4px;
            -moz-border-radius: 4px 0 0 4px;
            border-radius: 4px 0 0 4px;
        }

        .tabs-left > .nav-tabs > li > a:hover,
        .tabs-left > .nav-tabs > li > a:focus {
            border-color: #eeeeee #dddddd #eeeeee #eeeeee;
        }

        .tabs-left > .nav-tabs .active > a,
        .tabs-left > .nav-tabs .active > a:hover,
        .tabs-left > .nav-tabs .active > a:focus {
            border-color: #ddd transparent #ddd #ddd;
            *border-right-color: #ffffff;
        }

        .tabs-right > .nav-tabs {
            float: right;
            margin-left: 19px;
            border-left: 1px solid #ddd;
        }

        .tabs-right > .nav-tabs > li > a {
            margin-left: -1px;
            -webkit-border-radius: 0 4px 4px 0;
            -moz-border-radius: 0 4px 4px 0;
            border-radius: 0 4px 4px 0;
        }

        .tabs-right > .nav-tabs > li > a:hover,
        .tabs-right > .nav-tabs > li > a:focus {
            border-color: #eeeeee #eeeeee #eeeeee #dddddd;
        }

        .tabs-right > .nav-tabs .active > a,
        .tabs-right > .nav-tabs .active > a:hover,
        .tabs-right > .nav-tabs .active > a:focus {
            border-color: #ddd #ddd #ddd transparent;
            *border-left-color: #ffffff;
        }
        .tabs-container .form-group {overflow: hidden;}
        .tabs-container .tabs-left > .nav-tabs {
            width: 120px;;
        }
        .tabs-container .tabs-left .panel-body {
            margin-left: 120px;
            width:880px;
            text-align:left;
        }
        .tab-goods .nav li { width:120px; text-align:right; }

        .spec_item_thumb {position:relative;width:30px;height:20px;padding:0;border-left:none;}
        .spec_item_thumb i { position:absolute;top:-5px;right:-5px; }
        #container #buycontainer{
            width:800px;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>供应商管理</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>供应商管理 <small>供应商添加</small></h2>

                            <div class="clearfix"></div>
                        </div>

                        <form action="{{route('webMerchUserPostEdit', ['id' => $merchUser->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">商户名称</label>
                                <div class="col-sm-7"  style="padding-right:0;" >
                                    <input type="text" name="merchname" class="form-control" value="{{$merchUser->merchname}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">主营项目</label>
                                <div class="col-sm-7"  style="padding-right:0;" >
                                    <input type="text" name="salecate" class="form-control" value="{{$merchUser->salecate}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">所属地区</label>
                                <div class="col-sm-7"  style="padding-right:0;" >
                                    <select id="sheng" name='province'  class="input-sm form-control" style='width:90px;display: inline-block' >
                                        <option value="{{$merchUser->province}}" selected="true">省/直辖市</option>
                                    </select>
                                    <select id="shi" name='city'   class="input-sm form-control" style='width:90px;display: inline-block' >
                                        <option value="{{$merchUser->city}}" selected="true">市</option>
                                    </select>
                                    <select id="qu" name='area'  class="input-sm form-control" style='width:90px;display: inline-block;margin-right: 3px;' >
                                        <option value="{{$merchUser->area}}" selected="true">县/区</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">联系人</label>
                                <div class="col-sm-7"  style="padding-right:0;" >
                                    <input type="text" name="realname" class="form-control" value="{{$merchUser->realname}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">联系电话</label>
                                <div class="col-sm-7"  style="padding-right:0;" >
                                    <input type="text" name="mobile" class="form-control" value="{{$merchUser->mobile}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">商户简介</label>
                                <div class="col-sm-7"  style="padding-right:0;" >
                                    <textarea class="form-control" name="desc" value="{{$merchUser->desc}}" /></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label must">状态</label>
                                <div class="col-sm-9 col-xs-12">
                                    <label class="radio-inline"><input type="radio" name="status" value="1" @if($merchUser->status == 1)checked="true" @endif/> 允许入驻</label>
                                    <label class="radio-inline"><input type="radio" name="status" value="0" @if($merchUser->status == 0)checked="true" @endif/> 暂停中</label>
                                </div>
                            </div>


                            <div class="row panel-footer-buttons m-0">
                                <div class="col-md-12" style="text-align:center">
                                    <button type="submit" class="btn btn-primary waves-effect w-md waves-light">保存</button>
                                    <a href="javascript:;" onclick="history.go(-1);"
                                       class="btn btn-default waves-effect w-md waves-light">取消</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


