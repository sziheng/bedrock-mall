<div class="form-group">
    <label class="col-sm-2 control-label">购买强制关注</label>
    <div class="col-sm-9">

        <label class="radio-inline"><input type="radio" name="needfollow" value="0" @if(!$good['needfollow'])checked="true" @endif  /> 不需关注</label>
        <label class="radio-inline"><input type="radio" name="needfollow" value="1" @if($good['needfollow']) checked="true" @endif   /> 必须关注</label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">未关注提示</label>
    <div class="col-sm-9">
        <input type='text' class="form-control" name='followtip' value='{{$good['followtip']}}' />
        <span  class='help-block'>购买商品必须关注，如果未关注，弹出的提示，如果为空默认为“如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~”</span>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">关注引导</label>
    <div class="col-sm-9">
        <input type='text' class="form-control" name='followurl' value='{{$good['followurl']}}' />
        <span  class='help-block'>购买商品必须关注，如果未关注，跳转的链接，如果为空默认为系统关注页</span>
    </div>
</div>
<div class="form-group splitter"></div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享标题</label>
    <div class="col-sm-9 col-xs-12">

        <input type="text" name="share_title" id="share_title" class="form-control" value="{{$good['share_title']}}" />
        <span class='help-block'>如果不填写，默认为商品名称</span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享图标</label>
    <div class="col-sm-9 col-xs-12">
        <span class='help-block'>如果不选择，默认为商品缩略图片</span>
        <input class="fileupload" type="file" name="thumbs" data-url="/uploadImage"  data-option="share_icon" data-type="one">
        <div class="imgcontainer">
            @if($good['share_icon'])
                <div style="width:115px;display:inline-block">
                    <input name="share_icon" value="{{$good['share_icon']}}" type="hidden">
                    <img src="{{$good['share_icon']}}" style="width:100px">
                    <em class="close deleteimg" title="删除这张图片">×</em>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享描述</label>
    <div class="col-sm-9 col-xs-12">
        <textarea name="description" class="form-control" >{{$good['description']}}</textarea>
        <span class='help-block'>如果不填写，则使用商品副标题，如商品副标题为空则使用店铺名称</span>
    </div>
</div>