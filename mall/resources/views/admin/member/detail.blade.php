@extends('admin.layout.main')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>会员管理</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>会员管理
                                <small>会员详情</small>
                            </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" novalidate
                                  action="/web/member/{{$member->id}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @if($member->id)
                                    <input type="hidden" name="_method" value="PUT">
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">粉丝</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <img src='{{$member->avatar}}'
                                        style='width:50px;height:50px;padding:1px;border:1px solid #ccc' />
                                        {{$member->nickname}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">OPENID</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class="form-control-static js-clip" data-url='{{$member->openid}}'>{{$member->openid}}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">真实姓名</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class='form-control-static'>{{$member->realname}}</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">手机号码</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class='form-control-static'>{{$member->mobile}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">微信号</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class='form-control-static'>{{$member->weixin}}</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">余额</label>
                                    <div class="col-sm-3">
                                        <div class='form-control-static'>{{$member->credit2}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">注册时间</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class='form-control-static'>{{date('Y-m-d H:i:s',$member->createtime)}}
                                        </div>
                                    </div>
                                </div>
                          {{--      <div class="form-group">
                                    <label class="col-sm-2 control-label">关注状态</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class='form-control-static'>
                                            @if(!$member->followed)
                                                @if(!$member->uid)
                                                    <span class='btn  btn-sm  btn-default'>未关注</span>
                                                @else
                                                    <span class='btn  btn-sm  btn-warning'>取消关注</span>
                                                @endif
                                            @else
                                                <span class='btn  btn-sm  btn-primary'>已关注</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>--}}

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">备注</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class='form-control-static'>{{$member->content}}</div>
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





