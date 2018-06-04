{{--<div class="form-group notice">
    <label class="col-sm-2 control-label">商家通知</label>
    <div class="col-sm-9 col-xs-12">
        {php echo tpl_selector('noticeopenid',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$saler,'url'=>webUrl('member/query') ))}
    </div>
</div>--}}
<div class="form-group">
    <label class="col-sm-2 control-label">通知方式</label>
    <div class="col-sm-9 col-xs-12">

        <label class="checkbox-inline">
            <input type="checkbox" value="0" name='noticetype[]' @if(is_array($good['noticetype']))@if(in_array('0',$good['noticetype']))checked @endif @endif /> 下单通知
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" value="1" name='noticetype[]' @if(is_array($good['noticetype']))@if(in_array('1',$good['noticetype']))checked @endif @endif  /> 付款通知
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" value="2" name='noticetype[]' @if(is_array($good['noticetype']))@if(in_array('2',$good['noticetype']))checked @endif @endif  /> 买家收货通知
        </label>
        <div class="help-block">通知商家方式</div>

    </div>
</div>

