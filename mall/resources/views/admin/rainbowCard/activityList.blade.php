@extends('admin.layout.main')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>彩虹卡管理 <small>活动列表</small></h2>
                            <a href="/web/rainbowCard/create" class="btn btn-primary" type="button" style="float:right">添加活动</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(isset($activities) && ($activities->toArray())['total'])
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <th class="column-title">活动名称</th>
                                            <th class="column-title">彩虹卡面值 </th>
                                            <th class="column-title">起止时间</th>
                                            <th class="column-title">发卡数量</th>
                                            <th class="column-title">已使用数量</th>
                                            <th class="column-title no-link last"><span class="nobr">操作</span>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($activities as $activity)
                                            <tr class="even pointer">
                                                <td class=" " title="{{$activity->activityname}}" style="vertical-align:middle">{{$activity->activityname}}</td>
                                                <td class=" " style="vertical-align:middle">
                                                  {{$activity->facevalue}}
                                                </td>
                                                <td style="vertical-align:middle">
                                                    {{date('Y-m-d', object_get($activity, 'starttime', 0))}}<br/> {{date('Y-m-d', object_get($activity, 'endtime', 0))}}
                                                </td>
                                                <td class=""  style="vertical-align:middle">{{$activity->total}}</td>
                                                <td class=" " style="vertical-align:middle">
                                                    @if($activity->alreadyusecount > 0)
                                                        <a  target="view_window" href="/order/list?searchfield=activity&keyword={{$activity->activityname}}"  style="text-decoration:underline">{{$activity->alreadyusecount}}</a>
                                                    @else
                                                        {{$activity->alreadyusecount}}
                                                    @endif
                                                </td>
                                                <td class=" last" style="vertical-align:middle">
                                                    <span class='btn  btn-sm   @if($activity->isdisable==0) closed btn-primary  @else layer btn-default @endif'
                                                             @if($activity->isdisable == 0)
                                                                data-toggle="modal" data-target="#myModal"
                                                                style="cursor:pointer;height:30px"
                                                             @endif
                                                             data-content = "确认@if($activity->isdisable==0)关闭 @else 开启 @endif此活动么？"
                                                             data-url = "/web/rainbowCard/changeIsdisable"
                                                             data-params = "@if($activity->isdisable==0)1 @else 0 @endif"
                                                             data-type ="one"
                                                             data-id = "{{$activity->id}}"
                                                       >
                                                    @if($activity->isdisable==0)关闭 @else 开启@endif</span>
                                                    <a  class='btn btn-default btn-sm' href="/web/rainbowCard/activity/{{$activity->id}}" ><i class='fa fa-edit'></i> 编辑</a>
                                                    <a  class = "btn btn-default btn-sm layer"
                                                        data-content = "确认要删除该活动吗？"
                                                        data-url = "/web/member/delete"
                                                        data-params = "1"
                                                        data-type ="one"
                                                        data-id = "{{$activity->id}}">
                                                        <i class='fa fa-remove'></i> 删除</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $activities->links() }}
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
    {{--关闭操作时候出现的模态框begin--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" role="document" >
            <div class="modal-content" style="transition-duration: 0.5s; transition-timing-function: cubic-bezier(0.36, 1.1, 0.2, 1.2); margin-top: 255.5px; transition-property: transform, opacity, box-shadow, margin;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="float:left">请填写关闭理由(可不填)</h4>
                </div>
                <div class="modal-body" style="float:left;margin-left:20px">
                    理由 ：<input type="text" id="text" value="" size="50">
                </div>
                <div style="clear:both"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary sure" data-id="" id="sure" data-url="/web/rainbowCard/changeIsdisable">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    {{-- 关闭时候出现的模态框 end--}}
    <script>
        $(function(){
            $('.closed').click(function(){
                var id = $(this).data('id');
                $('#sure').data('id',id);
            })
            $('#sure').click(function(){
                var id=$(this).data('id');
                var text =$('#text').val();
                var url = $(this).data('url');
                $.post(url,{id:id,text:text,params:1},function(result){
                    if(result.error == 1) {
                        layer.msg(result.msg);
                    } else {
                        layer.msg('操作成功');
                        window.location.reload();
                    }

                });
            })
        })
    </script>
@endsection





