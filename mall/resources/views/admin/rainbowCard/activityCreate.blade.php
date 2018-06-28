@extends('admin.layout.main')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>彩虹卡管理</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>彩虹卡管理 <small>活动添加</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" novalidate action="/web/rainbowCard/activityStore"  method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{object_get($activity,'id','')}}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label must">活动名称</label>
                                    <div class="col-sm-7"  style="padding-right:0;" >
                                        <input type="text" name="activityname" id="activityname" maxlength="50" class="form-control" value="{{object_get($activity, 'activityname', '')}}" required="true"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label must">发卡数量</label>
                                    <div class="col-sm-7"  style="padding-right:0;" >
                                        <input type="text" name="total" id="total" class="form-control" value="{{object_get($activity, 'total', '')}}" required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label must">单卡面值</label>
                                    <div class="col-sm-7"  style="padding-right:0;" >
                                        <input type="text" name="facevalue" id="facevalue" class="form-control" value="{{object_get($activity, 'facevalue', '')}}" required="true" />
                                    </div>
                                </div>
                                <input type="hidden" id="overtime" value="{{object_get($activity, 'overtime' , '')}}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label must">起止日期</label>
                                    <div class="col-sm-7"  style="padding-right:0;" >
                                        <input name="starttime" id="beginTimeStore" type="hidden" value="{{date('Y-m-d ',object_get($activity, 'starttime', ''))}}">
                                        <input name="endtime" id="endTimeStore" type="hidden" value="{{date('Y-m-d ',object_get($activity, 'endtime', ''))}}">
                                        <button type="button" class="btn btn-default btn-sm" id="daterange-btn" style="width:200px;display:inline-block;margin-bottom:0px;margin-top: -3px">
                                            <i class="fa fa-calendar"></i>
                                            <span class="timedata">起止时间</span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <script>
                                            $(function(){
                                                require(["datetimepicker"], function(){

                                                })
                                                init();
                                            });
                                            function init() {
                                                //定义locale汉化插件
                                                var locale = {
                                                    "format": 'YYYY-MM-DD',
                                                    "separator": " -222 ",
                                                    "applyLabel": "确定",
                                                    "cancelLabel": "取消",
                                                    "fromLabel": "起始时间",
                                                    "toLabel": "结束时间'",
                                                    "customRangeLabel": "自定义",
                                                    "weekLabel": "W",
                                                    "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                                                    "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                                                    "firstDay": 1
                                                };
                                                //初始化显示当前时间
                                                var starttime = $('#beginTimeStore').val();
                                                var endtime = $('#endTimeStore').val();
                                                if(starttime && endtime){
                                                    $('#daterange-btn span').html(starttime + ' - ' + endtime);
                                                } else{
                                                    $('#daterange-btn span').html('起止时间');
                                                }
                                                //日期控件初始化
                                                $('#daterange-btn').daterangepicker(
                                                    {
                                                        'locale': locale,
                                                        //汉化按钮部分
                                                        ranges: {
                                                            '今日': [moment(), moment()],
                                                            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                            '最近7日': [moment().subtract(6, 'days'), moment()],
                                                            '最近30日': [moment().subtract(29, 'days'), moment()],
                                                            '本月': [moment().startOf('month'), moment().endOf('month')],
                                                            '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                                        },
                                                        startDate: moment().subtract(29, 'days'),
                                                        endDate: moment()
                                                    },
                                                    function (start, end) {
                                                        if($('#overtime').val() && $('#beginTimeStore').val() == start){
                                                            layer.msg('已经开始的活动无法修改开始时间，请重新输入');
                                                            return false;
                                                        }
                                                        $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                                                        $('#beginTimeStore').val(start.format('YYYY-MM-DD'));
                                                        $('#endTimeStore').val(end.format('YYYY-MM-DD'));
                                                    }
                                                );
                                            };

                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label must">商品</label>
                                    @if(object_get($activity, 'id' ,''))
                                        @foreach($activity->goodsContent as $key => $val)
                                        <div class="col-sm-7"  style="padding-rigth:0px;@if($key>0)margin-left: 16.66666667%; margin-top: 20px;@endif" >
                                            <select name="goodsid[]" class='form-control input-sm select-sm select2' style="width:300px;" data-placeholder="商品名称">
                                                <option value="0" >商品名称</option>
                                                @foreach($goodslist as $good)
                                                    <option value="{{$good->id}}" @if(array_get($val,'id','') == $good->id)selected @endif >{{$good->title}}</option>
                                                @endforeach
                                            </select>
                                            <div class="must" style="display: inline;width:90px;font: bold">商品数量</div>
                                            <input type="text" name="goodscount[]" style="width: 80px;display: inline-block"  class="form-control"  value="{{array_get($val,'count',1)}}"/>
                                        </div>
                                         @endforeach
                                    @else
                                    <div class="col-sm-7"  style="padding-right:0px;" >
                                        <select name="goodsid[]" class='form-control input-sm select-sm select2' style="width:300px;" data-placeholder="商品名称">
                                            <option value="0" >商品名称</option>
                                            @foreach($goodslist as $good)
                                            <option value="{{$good->id}}" @if(object_get($activity,'goodsid','') == $good->id)selected @endif >{{$good->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="must" style="display: inline;width:90px;font: bold">商品数量</div>
                                        <input type="text" name="goodscount[]" style="width: 80px;display: inline-block"  class="form-control"  value="1" />
                                    </div>
                                    @endif
                                    <div id="addgoods">
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-9 col-xs-12">
                                        <h4><a href="javascript:;"  id='add-goods' style="margin-top:10px;margin-bottom:10px;" title="添加商品"><i class='fa fa-plus'></i> 添加商品</a></h4>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="submit"  value="提交" class="btn btn-primary" />
                                        <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="取消" class="btn btn-default" />
                                        <input type="hidden" name="isFalse" value="{$isFalse}" />
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
        $(function(){
            require(['bootstrap','select2','vaildate'],function(){

            });
            var overtime = '{{object_get($activity, 'overtime', '')}}';
            //超过开始时间不能修改的字段begin
            if(overtime){
                $('#activityname, #total, #facevalue').attr('readonly','readonly');
            }
            //end
            $('.select2').select2()
            $("form").validate({
                submitHandler:function(form){
                    var check = true;
                    if($('.timedata').html()=='起止时间'){
                        layer.msg('请选择起止时间');
                        return false;
                    }
                    form.submit();
                }
            });
            $.extend($.validator.messages, {
                required: "必填字段",
            });
            $("body").on('click','.goodsclose',function () {
                $(this).parent().remove();//删除当前元素的父级
            })
            $("#add-goods").click(function () {
                var html = "<div class='col-sm-7'  style='padding-right:0; margin-left: 16.66666667%; margin-top: 20px;'  >";
                html += "<select name='goodsid[]' class='form-control input-sm select-sm select2' style='width:300px;' data-placeholder='商品名称'>";
                html += "<option value='0' >商品名称</option>";
                html += "@foreach($goodslist as $val)";
                html += "<option value=\"{{$val->id}}\">{{$val->title}}</option>";
                html += "@endforeach";
                html += "</select>";
                html += '<div class="must" style="display: inline;width:90px;font: bold">商品数量</div>';
                html += '<input type="text" name="goodscount[]" style="width: 80px;display: inline-block"  class="form-control"  value="1" />';
                html += ' <a class="goodsclose" href="javascript:;"><i class="fa fa-close"></i></a>';
                html += '</div>';
                $("#addgoods").append(html).find('select').select2();
            })
        })
    </script>
@endsection





