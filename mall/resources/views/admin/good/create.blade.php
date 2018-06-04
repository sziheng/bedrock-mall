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

                            <form action="/good" method="post" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="tabs-container tab-goods">
                            <div class="tabbable tabs-left">
                                <ul class="nav nav-tabs ">
                                    <li class="active"><a href="#a" data-toggle="tab">基本</a></li>
                                    {{--<li><a href="#b" data-toggle="tab">库存/规格</a></li>--}}
                                    <li><a href="#c" data-toggle="tab">参数</a></li>
                                    <li><a href="#d" data-toggle="tab">详情</a></li>
                                    <li><a href="#e" data-toggle="tab">购买权限</a></li>
                                    <li><a href="#f" data-toggle="tab">营销</a></li>
                                    <li><a href="#g" data-toggle="tab">会员折扣</a></li>
                                    <li><a href="#h" data-toggle="tab">分享关注</a></li>
                                    <li><a href="#i" data-toggle="tab">下单通知</a></li>
                                    {{--<li><a href="#j" data-toggle="tab">分销</a></li>
                                    <li><a href="#k" data-toggle="tab">线下核销</a></li>--}}
                                    <li><a href="#l" data-toggle="tab">自定义表单</a></li>
                                {{--    <li><a href="#m" data-toggle="tab">店铺信息</a></li>--}}
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="a"><div class="panel-body">@include("admin.good.nav.basic")</div></div>
                                 {{--   <div class="tab-pane" id="b"><div class="panel-body">@include("admin.good.nav.option")</div></div>--}}
                                    <div class="tab-pane" id="c"><div class="panel-body">@include("admin.good.nav.params")</div></div>
                                    <div class="tab-pane" id="d"><div class="panel-body">@include("admin.good.nav.detail")</div></div>
                                    <div class="tab-pane" id="e"><div class="panel-body">@include("admin.good.nav.buy")</div></div>
                                    <div class="tab-pane" id="f"><div class="panel-body">@include("admin.good.nav.sale")</div></div>
                                    <div class="tab-pane" id="g"><div class="panel-body">@include("admin.good.nav.discount")</div></div>
                                    <div class="tab-pane" id="h"><div class="panel-body">@include("admin.good.nav.share")</div></div>
                                    <div class="tab-pane" id="i"><div class="panel-body">@include("admin.good.nav.notice")</div></div>
                                    <div class="tab-pane" id="l"><div class="panel-body">@include("admin.good.nav.diyform")</div></div>
                                   {{--
                                    <div class="tab-pane" id="j">@include("admin.good.nav.sell")</div>
                                    <div class="tab-pane" id="k">@include("admin.good.nav.verify")</div>
                                    <div class="tab-pane" id="m">@include("admin.good.nav.merch")</div>--}}
                                </div>
                            </div>
                            <div class='panel-body' style='position:fixed;bottom:0;width:1000px; text-align: right; '>
                                <input type="submit" value="保存商品" class="btn btn-primary"/>
                            </div>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#myTab a').click(function (object) {
            object.preventDefault()
            $(this).tab('show')
        })

        $(function(){
            $("#sel_menu2").select2({
                tags: true,
                maximumSelectionLength: 10 //最多能够选择的个数
            });
            if($('input[name=hasoption]').val() == 1){
                $('.hasoption').attr('readonly','readonly');
            }

            var ue = UE.getEditor('container', {

            });

            $('input[name=buyshow]').click(function(){
                var ue = UE.getEditor('buycontainer', {

                });
                if($(this).is(":checked")){
                    $('.bcontent').css('display','block');
                }else{
                    $('.bcontent').css('display','none');
                }
            })
            $('.deleteimg').on('click',function(){
                $(this).parent().remove();
            })
            $('.fileupload').fileupload({
                dataType: 'json',
                done: function (e, data) {
                    var option = $(this).data('option');
                    if(!option){
                        option = 'thumb';
                    }
                    if($(this).data('type')=='one'){
                        $(this).next('.imgcontainer').empty();
                    }
                    var html ='';
                    html += '<div style="width:115px;display:inline-block"><input name="'+option+'" value="'+data.result+'" type="hidden"><img src="'+data.result+'" style="width:100px"><em class="close deleteimg" title="删除这张图片">×</em></div>';
                    $(this).next('.imgcontainer').append(html);
                    $('.deleteimg').on('click',function(){
                        $(this).parent().remove();
                    })
                }
            });
            $('.select2').select2({
                placeholder: "请选择所属选项",
                allowClear: true
            })
        })
    </script>
@endsection


