<div class="form-group">
<div class="col-sm-12">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active" style="width: auto">
                <a data-toggle="tab" href="#tab-sale-1" aria-expanded="false">
                    促销方式
                </a>
            </li>
            <li style="width: auto">
                <a data-toggle="tab" href="#tab-sale-2" aria-expanded="true">
                    满返设置
                </a>
            <li style="width: auto">
                <a data-toggle="tab" href="#tab-sale-3" aria-expanded="true">
                    抵扣设置
                </a>
            <li style="width: auto">
                <a data-toggle="tab" href="#tab-sale-4" aria-expanded="true">
                    包邮条件
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab-sale-1" class="tab-pane active">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        促销方式
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        @if($good)
                        <label for="isdiscount" class="checkbox-inline">
                            <input type="checkbox" name="isdiscount" value="1" id="isdiscount" @if($good['isdiscount']) checked="true" @endif onclick="showDiscount(this)"/>
                            促销
                        </label>
                        <label for="istime" class="checkbox-inline">
                            <input type="checkbox" name="istime" value="1" id="istime" @if($good['istime']) checked="true" @endif onclick="showTime(this)" />
                            限时卖
                        </label>
                        <label for="ishalfprice" class="checkbox-inline">
                            <input type="checkbox" name="ishalfprice" value="1" id="ishalfprice" @if($good['ishalfprice']) checked="true" @endif onclick="showhalfprice(this)" />
                            第二件半价
                        </label>
                    </div>
                </div>

                <div id="timediv" class="form-group" @if($good['istime'] == 1) style="display:none" @endif>
                <label class="col-sm-2 control-label">
                    限时卖时间
                </label>
                <div class="col-sm-6 col-xs-6">
                    <div class='form-control-static'>
                        @if($good['istime'] == 1){{  date('Y-m-d H:i',$item['timestart'])}}-{{  date('Y-m-d H:i',$item['timeend'])}} @endif
                    </div>
                </div>
            </div>
            <div id="isdiscount_time" class="form-group" @if($good['isdiscount'] != 1) style="display:none" @endif>
            <label class="col-sm-2 control-label">
                促销标题
            </label>
            <div class="col-sm-9 col-xs-12">
                <div class="input-group">
                    <input type="text" name="isdiscount_title" maxlength="5" class="form-control"
                           value="{{$good['isdiscount_title']}}" />
                    <p class="help-block">
                        例如 : 季末清仓,双十一促销,品牌日 还可以输入
                        <span id="textCount">
                                    5
                                </span>
                        个字,不输入默认促销
                    </p>
                </div>
            </div>
            <label class="col-sm-2 control-label">
                促销结束时间
            </label>
            <div class="col-sm-4 col-xs-6">
                <div class='form-control-static'>
                    @if($good['isdiscount_time'] == 1) <?php echo date('Y-m-d H:i',$good['isdiscount_time']); ?> @endif
                </div>
            </div>
        </div>


        <div id="saletype" class="form-group" @if($good['isdiscount'] != 1) style="display:none" @endif >
        {if $merchid > 0}
        <label class="col-sm-2 control-label">
            手机端使用的价格
        </label>
        <div class="col-sm-9 col-xs-12">

            <label class="radio-inline"><input type="radio" name="merchsale" value="0" @if(!$good['merchsale'])checked="true" @endif /> 当前设置的促销价格</label>
            <label class="radio-inline"><input type="radio" name="merchsale" value="1" @if($good['merchsale']) checked="true" @endif   /> 商户设置的促销价格</label>
            <span class="help-block"></span>

        </div>
            @endif
    </div>

    <div id="isdiscount_true">
        <div id="isdiscount_discounts_1">
            <div class="form-group isdiscount_discounts-info">
                <div class="col-sm-12">
                    <div class='alert alert-danger'>
                        详细设置促销价格 :
                        <br>
                        如果填写纯数字我们认为单位是元 例如填写 1 也就是促销价1元
                        <br>
                        如果填写百分数,我们认为是打折数 例如填写 90% 则就是打九折
                    </div>
                </div>
            </div>
            <div id='tbisdiscount_discounts' style="padding-left:15px;">
                <div id="isdiscount_discounts" style="padding:0;">@if($good['hasoption'] ==1 ){$isdiscount_discounts_html}@endif</div>
                <div id="isdiscount_discounts_default" style="padding:0;"></div>
            </div>
        </div>
    </div>
</div>
<div id="tab-sale-2" class="tab-pane">
    <div class="form-group">
        <label class="col-sm-2 control-label">
            积分赠送
        </label>
        <div class="col-sm-9 col-xs-12">
           @if($good)
            <div class="input-group">
                <input type="text" name="credit" id="credit" class="form-control" value="{{$good['credit']}}"/>
                <span class="input-group-addon">
                                分
                            </span>
            </div>
            <p class="help-block">
                会员购物赠送的积分, 如果不填写或填写0，则默认为不赠送积分，如果带%则为按成交价格的比例计算积分
            </p>
            <p class="help-block">
                如: 购买2件，设置10 积分, 不管成交价格是多少， 则购买后获得20积分
            </p>
            <p class="help-block">
                如: 购买2件，设置10%积分, 成交价格2 * 200= 400， 则购买后获得 40 积分（400*10%）
            </p>
            @else
            <div class='form-control-static'>
                {{$good['credit']}} 分
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            余额返现
        </label>
        <div class="col-sm-9 col-xs-12">
           @if($good)
            <div class="input-group">
                <input type="text" name="money" id="money" class="form-control" value="{{$good['money']}}"
                />
                <span class="input-group-addon">
                                元
                            </span>
            </div>
            <p class="help-block">
                会员购物返现, 如果不填写或填写0，则默认为不返现，如果带%则为按成交价格的比例计算返现
            </p>
            <p class="help-block">
                如: 购买2件，设置10 元, 不管成交价格是多少， 则购买后获得20元返现
            </p>
            <p class="help-block">
                如: 购买2件，设置10%元, 成交价格2 * 200= 400， 则购买后获得 40 元返现（400*10%）
            </p>
          @else
            <div class='form-control-static'>
                {{$good['credit']}} 分
            </div>
          @endif
        </div>
    </div>
</div>
<div id="tab-sale-3" class="tab-pane">
    <div class="form-group">
        <label class="col-sm-2 control-label">
            积分抵扣
        </label>
        <div class="col-sm-9 col-xs-12">
            @if($good)
            <div class='input-group'>
                            <span class="input-group-addon">
                                最多抵扣
                            </span>
                <input type="text" name="deduct" value="{{$good['deduct']}}" class="form-control"/>
                <span class="input-group-addon">
                                元
                            </span>
            </div>
            <label class="checkbox-inline" for="manydeduct">
                <input id="manydeduct" type="checkbox" @if($good['manydeduct'] == 1) checked="true" @endif value="1" name="manydeduct">
                允许多件累计抵扣
            </label>
            <span class="help-block">
                            如果设置0，则不支持积分抵扣
                        </span>
           @else
            <div class='form-control-static'>
                @if(!$good['deduct'])不支持积分抵扣@else最多抵扣 {{$good['deduct']}} 元  @if(!$good['manydeduct']) 不允许多件累计抵扣@else 允许多件累计抵扣
                @endif @endif
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            余额抵扣
        </label>
        <div class="col-sm-9 col-xs-12">
            @if($good)
            <div class='input-group'>
                            <span class="input-group-addon">
                                最多抵扣
                            </span>
                <input type="text" name="deduct2" value="{{$good['deduct2']}}" class="form-control"
                />
                <span class="input-group-addon">
                                元
                            </span>
            </div>
            <span class="help-block">
                            如果设置0，则支持全额抵扣，设置-1 不支持余额抵扣
                        </span>
            @else
            <div class='form-control-static'>
                @if(!$good['deduct2']) 支持全额抵扣 @elseif($good['deduct2'] == -1) 不支持余额抵扣@else 最多抵扣 {{$good['deduct2']}} 元 @endif
            </div>
            @endif
        </div>
    </div>
</div>
<div id="tab-sale-4" class="tab-pane">
    <div class="form-group">
        <label class="col-sm-2 control-label">
            单品满件包邮
        </label>
        <div class="col-sm-4">
            @if($good)
            <div class='input-group'>
                            <span class="input-group-addon">
                                满
                            </span>
                <input type="text" name="ednum" value="{{$good['ednum']}}" class="form-control"
                />
                <span class="input-group-addon">
                                件
                            </span>
            </div>
            <span class="help-block">
                            如果设置0或空，则不支持满件包邮
                        </span>
            @else
            <div class='form-control-static'>
                @if(!$good['ednum'])不支持满件包邮@else支持 @endif
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            单品满额包邮
        </label>
        <div class="col-sm-4">
            @if($good)
            <div class='input-group'>
                            <span class="input-group-addon">
                                满
                            </span>
                <input type="text" name="edmoney" value="{{$good['edmoney']}}" class="form-control"
                />
                <span class="input-group-addon">
                                元
                            </span>
            </div>
            <span class="help-block">
                            如果设置0或空，则不支持满额包邮
                        </span>
            @else
            <div class='form-control-static'>
                @if(!$good['edmoney'])不支持满额包邮@else支持 @endif
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            不参与单品包邮地区
        </label>
        <div class="col-sm-9 col-xs-12">
            @if($good)
            <div id="areas" class="form-control-static">
                {{$good['edareas']}}
            </div>
            <a href="javascript:;" class="btn btn-default" onclick="selectAreas()">
                添加不参加满包邮的地区
            </a>
            <input type="hidden" id='selectedareas' name="edareas" value="{{$good['edareas']}}"
            />
            <span class="help-block">
                            如果设置0或空，则不支持满件包邮
                        </span>
            @else
            <div class='form-control-static'>
                {$set['enoughareas']}
            </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<div id="levelcontent" style="display:none">
 {{--   <table class="table table-bordered table-condensed" >
        <thead>
        <tr class="active">
            @foreach($levels as $level)
                <th>
                    <div class=""><div style="padding-bottom:10px;text-align:center;">{{$level['levename']}}</div></div>
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            {loop $levels $level}
            @foreach($levels as $level)
                @if($level['key'] == 'default')
                    <td><input name="isdiscount_discounts_level_{{$level['key']}}_default" type="text" class="form-control isdiscount_discounts_{{$level['key']}} isdiscount_discounts_{{$level['key']}}_default" value="{{is_array($isdiscount_discounts[$level["key"]]["option0"]) ? '' : $isdiscount_discounts[$level["key"]]["option0"];}} " placeholder="会员促销价格单位: 元">
                    </td>
                @else
                    <td>
                        <input name="isdiscount_discounts_level_{{$level['id']}}_default" type="text" class="form-control isdiscount_discounts_level{{$level['id']}} isdiscount_discounts_level{{$level['id']}}_default" value="{{is_array($isdiscount_discounts[$level["id"]]["option0"]) ? '' : $isdiscount_discounts[$level["id"]]["option0"];}}" placeholder="会员促销价格单位: 元">
                    </td>
                @endif
            @endforeach
        </tr>
        </tbody>
    </table>--}}
</div>

<script>
    @if($good)
    $(document).ready(function() {
        var Discount = document.getElementById("isdiscount");
        showDiscount(Discount);
    });
    function showTime(obj) {
        if (obj.checked) {
            $('#timediv').show();
            $('#isdiscount_time').hide();
            $('input[name="isdiscount"]').removeAttr('checked');
            $('#isdiscount_true').hide();
            $('input[name="ishalfprice"]').removeAttr('checked');
        } else {
            $('#timediv').hide();
        }
    }
    function showDiscount(obj) {
        if (obj.checked) {
            $('input[name="istime"]').removeAttr('checked');
            $('#timediv').hide();
            $('#isdiscount_time').show();
            $('#isdiscount_true').show();
            $('#saletype').show();
            $('input[name="ishalfprice"]').removeAttr('checked');
        } else {
            $('#isdiscount_time').hide();
            $('#isdiscount_true').hide();
            $('#saletype').hide();
        }
    }
    function showhalfprice(obj) {
        if (obj.checked) {
            $('#isdiscount_time').hide();
            $('input[name="isdiscount"]').removeAttr('checked');
            $('#isdiscount_true').hide();
            $('input[name="istime"]').removeAttr('checked');
            $('#timediv').hide();
            $('#saletype').hide();
        }
    }
    @endif
        function isdiscount_change() {
                 var html = '';
        if ($("#isdiscount_discounts").html()=='')
        {
            $('#levelcontent').css('display','block');
            $("#isdiscount_discounts_default").html($('#levelcontent').html());
        }
        else
        {
            $("#isdiscount_discounts_default").html('');
        }

        }

        isdiscount_change();

    function commission_change() {
        var html = '<table class="table table-bordered table-condensed"><thead><tr class="active">{loop $commission_level $level}<th><div class=""><div style="padding-bottom:10px;text-align:center;">{$level["levelname"]}</div></div></th>{/loop}</tr></thead><tbody><tr>{loop $commission_level $level}{if $level["key"]=="default"}<td>{php for ($c_i = 0; $c_i < $_W["shopset"]["commission"]["level"]; $c_i++): }<input name="commission_level_{$level["key"]}_default[]" type="text" class="form-control commission_{$level["key"]} commission_{$level["key"]}_default" value="{php echo $commission[$level["key"]]["option0"][$c_i ];}" style="display:inline;width: {php echo (96 / $_W["shopset"]["commission"]["level"])}%;" placeholder="{php echo $c_i+1}级"> {php endfor;}</td>{else}<td>{php for ($c_i = 0; $c_i < $_W["shopset"]["commission"]["level"]; $c_i++): }<input name="commission_level_{$level["id"]}_default[]" type="text" class="form-control commission_level{$level["id"]} commission_{$level["key"]}_default" value="{php echo $commission["level".$level["id"]]["option0"][$c_i ];}" style="display:inline;width: {php echo (96 / $_W["shopset"]["commission"]["level"])}%;" placeholder="{php echo $c_i+1}级"> {php endfor;}</td>{/if}{/loop}</tr></tbody></table>';
        if ($("#commission").html()=='')
        {
            $("#commission_default").html(html);
            $("#commission_default").show();
        }
        else
        {
            $("#commission_default").html('');
            $("#commission_default").show();
        }
    }

</script>
{{--
{template 'shop/selectareas'}--}}
@include("admin.shop.selectareas")
