<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
        @if($good)
        <label for="discounts_type0" class="radio-inline"><input type="radio" name="discounts[type]" value="0" id="discounts_type0"  @if(!$good['discounts'] || $good['discounts']['type'] == 0 ) checked="true" @endif /> 统一设置折扣 0.1-10之间</label>
{{--        <label for="discounts_type1" class="radio-inline" @if($good['hasoption']!=1) style='display:none' @endif><input type="radio" name="discounts[type]" value="1" id="discounts_type1"  @if($good['discounts'] && $good['discounts']['type'] == 1 ) checked="true" @endif  /> 详细设置折扣</label>--}}
        @else
        <div class='form-control-static'>
            @if(!$good['discounts'] || $good['discounts']['type'] == 0 )统一设置折扣 0.1-10之间@endif
         {{--   @if($good['discounts'] && $good['discounts']['type'] == 1 ) 详细设置折扣@endif--}}
        </div>

        @endif
    </div>
</div>

<div id="discounts_0" @if($good['discounts']['type'] !=0)  style="display:none;" @endif>

<div class="form-group discounts-info">
    <div class="col-sm-12">
        <div class='alert alert-info'>
            只有当折扣大于0，小于10的情况下才能生效，否则按自身会员等级折扣计算
        </div>
    </div>
</div>

@foreach($levels as $level)
<div class="form-group">
    <div class="col-sm-9">
        <div class='input-group'>
            <div class='input-group-addon'>{{$level['levelname']}}</div>
            <input type='text' name='discounts[{{$level['key']}}]' class="form-control"  value="@if(isset($good['discounts'][$level['key']])) {{$good['discounts'][$level['key']]}}  @endif" />
            <div class='input-group-addon'>折</div>
        </div>
    </div>
</div>
@endforeach
</div>
{{--<div id="discounts_1" @if($discounts['type']!=1) style="display:none;" @endif>
<div class="form-group discounts-info">
    <div class="col-sm-12">
        <div class='alert alert-info'>
            例如：当前商品原价是100元，如直接填写80，则优惠以后的最终价是80元，如果填写80%则为8 折，为空按自身会员等级折扣计算
        </div>
    </div>
</div>
<div id='tbdiscount' style="padding-left:15px;" >
    <div id="discount" style="padding:0;">{if $item['hasoption']==1}{$discounts_html}{/if}</div>
</div>
</div>--}}
{{--
<script>
    $(function () {
        $("label[for='discounts_type0']").click(function () {
            $("#discounts_1").hide();
            $("#discounts_0").show();
        })
        $("label[for='discounts_type1']").click(function () {
            $("#discounts_0").hide();
            $("#discounts_1").show();
        })
    });
</script>--}}
