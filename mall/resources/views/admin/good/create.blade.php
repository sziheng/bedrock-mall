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
                            <h2>商品管理 <small>商品添加</small></h2>
                            <a  style="float:right" href="/web/good?status=sale" class="btn btn-primary" type="button" style="float:right">商品列表</a>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <form action="/web/good" method="post" class="form-horizontal" enctype="multipart/form-data" id="goodform">
                                <input type="hidden" name="id" value="{{$good['id']}}">
                                {{ csrf_field() }}
                                <input type="hidden"  name="commissionLevelsjs" name="{{json_encode($commissionLevels)}}">
                            <div class="tabs-container tab-goods">
                            <div class="tabbable tabs-left">
                                <ul class="nav nav-tabs ">
                                    <li class="active"><a href="#a" data-toggle="tab">基本</a></li>
                                    <li><a href="#b" data-toggle="tab">库存/规格</a></li>
                                    <li><a href="#c" data-toggle="tab">参数</a></li>
                                    <li><a href="#d" data-toggle="tab">详情</a></li>
                                    <li><a href="#e" data-toggle="tab">购买权限</a></li>
                                    <li style="display: none"><a href="#f" data-toggle="tab">营销</a></li>
                                    <li><a href="#g" data-toggle="tab">会员折扣</a></li>
                                    <li><a href="#h" data-toggle="tab">分享关注</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="a"><div class="panel-body">@include("admin.good.nav.basic")</div></div>
                                    <div class="tab-pane" id="b"><div class="panel-body">@include("admin.good.nav.option")</div></div>
                                    <div class="tab-pane" id="c"><div class="panel-body">@include("admin.good.nav.params")</div></div>
                                    <div class="tab-pane" id="d"><div class="panel-body">@include("admin.good.nav.detail")</div></div>
                                    <div class="tab-pane" id="e"><div class="panel-body">@include("admin.good.nav.buy")</div></div>
                                    <div class="tab-pane" id="f"><div class="panel-body">@include("admin.good.nav.sale")</div></div>
                                    <div class="tab-pane" id="g"><div class="panel-body">@include("admin.good.nav.discount")</div></div>
                                    <div class="tab-pane" id="h"><div class="panel-body">@include("admin.good.nav.share")</div></div>
                                </div>
                            </div>
                            <div class='panel-body submit' style='display:none;position:fixed;bottom:0;width:1000px; text-align: right;'>
                                <input type="submit"  value="保存商品" class="btn btn-primary"/>
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
        $(function(){
            $('.submit').css('display','block');
            //下拉框
            $('.select2').select2({
                placeholder: "请选择所属选项",
                allowClear: true
            })
                $('#myTab a').click(function (e) {
                    $('#tab').val( $(this).attr('href'));
                    e.preventDefault();
                    $(this).tab('show');
                })
            $(':radio[name=isverify]').click(function () {
                window.type = $("input[name='isverify']:checked").val();

                if (window.type == '2') {
                    $(':checkbox[name=cash]').attr("checked",false);
                    $(':checkbox[name=cash]').parent().hide();
                } else {
                    $(':checkbox[name=cash]').parent().show();
                }
            })

            //地址联动begin
            $('.province').mouseover(function(){
                $(this).find('ul').show();
            }).mouseout(function(){
                $(this).find('ul').hide();
            });

            $('.cityall').click(function(){
                var checked = $(this).get(0).checked;
                var citys = $(this).parent().parent().find('.city');
                citys.each(function(){
                    $(this).get(0).checked = checked;
                });
                var count = 0;
                if(checked){
                    count =  $(this).parent().parent().find('.city:checked').length;
                }
                if(count>0){
                    $(this).next().html("(" + count + ")")    ;
                }
                else{
                    $(this).next().html("");
                }
            });
            $('.city').click(function(){
                var checked = $(this).get(0).checked;
                var cityall = $(this).parent().parent().parent().parent().find('.cityall');

                if(checked){
                    cityall.get(0).checked = true;
                }
                var count = cityall.parent().parent().find('.city:checked').length;
                if(count>0){
                    cityall.next().html("(" + count + ")")    ;
                }
                else{
                    cityall.next().html("");
                }
            });
            //地址联动end
            //标签选择
            $("#sel_menu2").select2({
                tags: true,
                maximumSelectionLength: 10 //最多能够选择的个数
            });
            //规格页面 如是多规格其他输入框变为只读
            if('{{$good['hasoption']}}'== 1){
                $('.hasoption').attr('readonly','readonly');
            }
            //实例化富文本
            var ue = UE.getEditor('container', {

            });
            //详情页面可读时展示
            $('input[name=buyshow]').click(function(){
                var ue = UE.getEditor('buycontainer', {

                });
                if($(this).is(":checked")){
                    $('.bcontent').css('display','block');
                }else{
                    $('.bcontent').css('display','none');
                }
            })
            //删除文件
            $('.deleteimg').on('click',function(){
                $(this).parent().remove();
            })
            //文件上传类
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

                    $("form").validate({
                        submitHandler:function(form){
                            var check = true;

                            window.type = $("input[name='type']:checked").val();
                            window.virtual = $("#virtual").val();
                            if ($("#title").val()== '') {
                                layer.msg('商品名称不能为空');
                                return false;
                            }
                            var inum = 0;
                            $("input[name='thumbs[]']").each(function(){
                                inum++;
                            })
                            if (inum == 0) {
                                layer.msg('请上传商品图片');
                                return false;
                            }

                            full = checkoption();
                            if (!full) {
                                return false;
                            }
                            if (optionchanged) {
                                layer.msg('规格数据有变动，请重新点击 [刷新规格项目表] 按钮!');
                                return false;
                            }
                            var spec_item_title = 1;
                            $(".spec_item").each(function (i) {
                                var _this = this;
                                if($(_this).find(".spec_item_title").length == 0){
                                    spec_item_title = 0;
                                }
                            });
                            if(spec_item_title == 0){
                                layer.msg('详细规格没有填写,请填写详细规格!');
                                return false;
                            }
                            //处理规格
                            optionArray();
                            isdiscountDiscountsArray();
                            discountArray();
                            commissionArray();
                            form.submit();

                        }
                    });

        })


        window.optionchanged = false;


        function optionArray()
        {
            var option_stock = new Array();
            $('.option_stock').each(function (index,item) {
                option_stock.push($(item).val());
            });

            var option_id = new Array();
            $('.option_id').each(function (index,item) {
                option_id.push($(item).val());
            });

            var option_ids = new Array();
            $('.option_ids').each(function (index,item) {
                option_ids.push($(item).val());
            });

            var option_title = new Array();
            $('.option_title').each(function (index,item) {
                option_title.push($(item).val());
            });

            var option_virtual = new Array();
            $('.option_virtual').each(function (index,item) {
                option_virtual.push($(item).val());
            });

            var option_marketprice = new Array();
            $('.option_marketprice').each(function (index,item) {
                option_marketprice.push($(item).val());
            });

            var option_productprice = new Array();
            $('.option_productprice').each(function (index,item) {
                option_productprice.push($(item).val());
            });

            var option_costprice = new Array();
            $('.option_costprice').each(function (index,item) {
                option_costprice.push($(item).val());
            });

            var option_goodssn = new Array();
            $('.option_goodssn').each(function (index,item) {
                option_goodssn.push($(item).val());
            });

            var option_productsn = new Array();
            $('.option_productsn').each(function (index,item) {
                option_productsn.push($(item).val());
            });

            var option_weight = new Array();
            $('.option_weight').each(function (index,item) {
                option_weight.push($(item).val());
            });

            var options = {
                option_stock : option_stock,
                option_id : option_id,
                option_ids : option_ids,
                option_title : option_title,
                option_marketprice : option_marketprice,
                option_productprice : option_productprice,
                option_costprice : option_costprice,
                option_goodssn : option_goodssn,
                option_productsn : option_productsn,
                option_weight : option_weight,
                option_virtual : option_virtual
            };
            $("input[name='optionArray']").val(JSON.stringify(options));
        }

        function isdiscountDiscountsArray()
        {

            @foreach($levels as $level)
            var isdiscount_discounts_{{$level['key']}} = new Array();
            $(".isdiscount_discounts_{{$level['key']}}").each(function (index,item) {
                isdiscount_discounts_{{$level['key']}}.push($(item).val());
            });
            @endforeach

                var isdiscount_discounts_id = new Array();
                $('.isdiscount_discounts_id').each(function (index,item) {
                    isdiscount_discounts_id.push($(item).val());
                });

                var isdiscount_discounts_ids = new Array();
                $('.isdiscount_discounts_ids').each(function (index,item) {
                    isdiscount_discounts_ids.push($(item).val());
                });

                var isdiscount_discounts_title = new Array();
                $('.isdiscount_discounts_title').each(function (index,item) {
                    isdiscount_discounts_title.push($(item).val());
                });

                var isdiscount_discounts_virtual = new Array();
                $('.isdiscount_discounts_virtual').each(function (index,item) {
                    isdiscount_discounts_virtual.push($(item).val());
                });

                var options = {
                @foreach($levels as $level)
                isdiscount_discounts_{{$level['key']}} : isdiscount_discounts_{{$level['key']}},
                @endforeach
                    isdiscount_discounts_id : isdiscount_discounts_id,
                        isdiscount_discounts_ids : isdiscount_discounts_ids,
                    isdiscount_discounts_title : isdiscount_discounts_title,
                    isdiscount_discounts_virtual : isdiscount_discounts_virtual
                };
                $("input[name='isdiscountDiscountsArray']").val(JSON.stringify(options));
            }

                function discountArray()
                {

                     @foreach($levels as $level)
                    var discount_{{$level['key']}} = new Array();
                    $(".discount_{{$level['key']}}").each(function (index,item) {
                        discount_{{$level['key']}}.push($(item).val());
                    });
                    @endforeach

                        var discount_id = new Array();
                        $('.discount_id').each(function (index,item) {
                            discount_id.push($(item).val());
                        });

                        var discount_ids = new Array();
                        $('.discount_ids').each(function (index,item) {
                            discount_ids.push($(item).val());
                        });

                        var discount_title = new Array();
                        $('.discount_title').each(function (index,item) {
                            discount_title.push($(item).val());
                        });

                        var discount_virtual = new Array();
                        $('.discount_virtual').each(function (index,item) {
                            discount_virtual.push($(item).val());
                        });

                        var options = {
                        @foreach($levels as $level)
                        discount_{{$level['key']}} : discount_{{$level['key']}},
                        @endforeach
                            discount_id : discount_id,
                                discount_ids : discount_ids,
                            discount_title : discount_title,
                            discount_virtual : discount_virtual
                        };
                        $("input[name='discountArray']").val(JSON.stringify(options));
                    }

                        function commissionArray()
                        {
                            var specs = [];
                            $(".spec_item").each(function (i) {
                                var _this = $(this);

                                var spec = {
                                    id: _this.find(".spec_id").val(),
                                    title: _this.find(".spec_title").val()
                                };

                                var items = [];
                                _this.find(".spec_item_item").each(function () {
                                    var __this = $(this);
                                    var item = {
                                        id: __this.find(".spec_item_id").val(),
                                        title: __this.find(".spec_item_title").val(),
                                        virtual: __this.find(".spec_item_virtual").val(),
                                        show: __this.find(".spec_item_show").get(0).checked ? "1" : "0"
                                    }
                                    items.push(item);
                                });
                                spec.items = items;
                                specs.push(spec);
                            });
                            specs.sort(function (x, y) {
                                if (x.items.length > y.items.length) {
                                    return 1;
                                }
                                if (x.items.length < y.items.length) {
                                    return -1;
                                }
                            });

                            var len = specs.length;
                            var newlen = 1;
                            var h = new Array(len);
                            var rowspans = new Array(len);
                            for (var i = 0; i < len; i++) {
                                var itemlen = specs[i].items.length;
                                if (itemlen <= 0) {
                                    itemlen = 1
                                }
                                newlen *= itemlen;
                                h[i] = new Array(newlen);
                                for (var j = 0; j < newlen; j++) {
                                    h[i][j] = new Array();
                                }
                                var l = specs[i].items.length;
                                rowspans[i] = 1;
                                for (j = i + 1; j < len; j++) {
                                    rowspans[i] *= specs[j].items.length;
                                }
                            }

                            for (var m = 0; m < len; m++) {
                                var k = 0, kid = 0, n = 0;
                                for (var j = 0; j < newlen; j++) {
                                    var rowspan = rowspans[m];
                                    if (j % rowspan == 0) {
                                        h[m][j] = {
                                            title: specs[m].items[kid].title,
                                            virtual: specs[m].items[kid].virtual,
                                            id: specs[m].items[kid].id
                                        };
                                    }
                                    else {
                                        h[m][j] = {
                                            title: specs[m].items[kid].title,
                                            virtual: specs[m].items[kid].virtual,
                                            id: specs[m].items[kid].id
                                        };
                                    }
                                    n++;
                                    if (n == rowspan) {
                                        kid++;
                                        if (kid > specs[m].items.length - 1) {
                                            kid = 0;
                                        }
                                        n = 0;
                                    }
                                }
                            }

                            var commission = {};
                            var commission_level = $('input[name=commissionLevelsjs]').val();
                            for (var i = 0; i < newlen; i++) {
                                var ids = [];
                                for (var j = 0; j < len; j++) {
                                    ids.push(h[j][i].id);
                                }
                                ids = ids.join('_');
                                $.each(commission_level,function (key,val) {
                                    if(val.key == 'default')
                                    {
                                        var kkk = "commission_level_"+val.key+"_"+ids;
                                        commission[kkk] = {};
                                        $("input[data-name=commission_level_"+val.key+"_"+ids+"]").each(function (k,v) {
                                            commission[kkk][k] = $(v).val();
                                        });
                                    }
                                    else
                                    {
                                        var kkk = "commission_level_"+val.id+"_"+ids;
                                        commission[kkk] = {};
                                        $("input[data-name=commission_level_"+val.id+"_"+ids+"]").each(function (k,v) {
                                            commission[kkk][k] = $(v).val();
                                        });
                                        var kkk = "commission_level_"+val.id+"_"+ids;
                                        commission[kkk] = {};
                                        $("input[data-name=commission_level_"+val.id+"_"+ids+"]").each(function (k,v) {
                                            commission[kkk][k] = $(v).val();
                                        });
                                    }
                                })
                            }

                            var commission_id = new Array();
                            $('.commission_id').each(function (index,item) {
                                commission_id.push($(item).val());
                            });

                            var commission_ids = new Array();
                            $('.commission_ids').each(function (index,item) {
                                commission_ids.push($(item).val());
                            });

                            var commission_title = new Array();
                            $('.commission_title').each(function (index,item) {
                                commission_title.push($(item).val());
                            });

                            var commission_virtual = new Array();
                            $('.commission_virtual').each(function (index,item) {
                                commission_virtual.push($(item).val());
                            });



                            var options = {
                                commission : commission,
                                commission_id : commission_id,
                                commission_ids : commission_ids,
                                commission_title : commission_title,
                                commission_virtual : commission_virtual
                            };
                            $("input[name='commissionArray']").val(JSON.stringify(options));
                        }

                        function checkoption() {

                            var full = true;
                            if ($("#hasoption").get(0).checked) {
                                $(".spec_title").each(function (i) {
                                    if ($(this).val() == '') {
                                        layer.msg('请输入规格名称');
                                        full = false;
                                        return false;
                                    }
                                });
                                $(".spec_item_title").each(function (i) {
                                    if ($(this).val() == '') {
                                        layer.msg('请输入规格名称');
                                        full = false;
                                        return false;
                                    }
                                });
                            }
                            if (!full) {
                                return false;
                            }
                            return full;
                        }
    </script>
@endsection


