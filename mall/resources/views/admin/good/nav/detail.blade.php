<div class="form-group"></div>
<div class="form-group">
    <label class="col-sm-2 form-control-static">商品详情</label>
    <div class="col-sm-11">
            <script id="container" name="content" type="text/plain">
                {!! $good['content'] !!}
            </script>
    </div>
</div>

<div class="form-group" >
    <div class="col-sm-10 col-xs-12">
        <h4>购买后可见</h4>
        <span>开启后购买过的商品才会显示</span>
    </div>
    <div class="col-sm-2 pull-right" style="padding-right:50px;text-align: right" >

        <label>
            <input type="checkbox" class="js-switch" @if($good['buyshow'] == 1) checked @endif name="buyshow" />
        </label>
    </div>

    <div class="col-sm-11 bcontent" @if(!$good['buyshow']) style="display:none;" @endif>
        <script id="buycontainer" name="buycontent" type="text/plain">
            {!! $good['buycontent'] !!}
        </script>
    </div>
</div>