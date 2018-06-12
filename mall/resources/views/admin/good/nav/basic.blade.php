<div class="form-group">
    <label class="col-sm-2 control-label">排序</label>
    <div class="col-sm-9 col-xs-12">
        <input type="text" name="displayorder" id="displayorder" class="form-control" value="{{$good['displayorder']}}" />
        <span class='help-block'>数字越大，排名越靠前,如果为空，默认排序方式为创建时间</span>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label must">商品名称</label>
    <div class="col-sm-7"  style="padding-right:0;" >
        <input type="text" name="title" id="title" class="form-control" value="{{$good['title']}}"  />
    </div>
    <div class="col-sm-2" style="padding-left:5px">
        <input type="text" name="unit" id="unit" class="form-control" value="{{$good['unit']}}" placeholder="单位, 如: 个/件/包"  />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">副标题</label>

    <div class="col-sm-9 subtitle">
        <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{$good['subtitle']}}" data-parent=".subtitle" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">商品类型</label>
    <div class="col-sm-9 col-xs-12">
        <input type="hidden" name="goodstype" value="{{$good['type']}}">


        <label class="radio-inline"><input type="radio" name="type" value="1"  @if($good) disabled @endif @if($good['type'] <= 1)checked="true" @endif onclick="$('#product').show();$('#type_virtual').hide()" /> 实体商品</label>
        <label class="radio-inline"><input type="radio" name="type" value="2" @if($good) disabled @endif @if($good['type']  == 2)checked="true" @endif  onclick="$('#product').hide();$('#type_virtual').hide()" /> 虚拟商品</label>

        <label class="radio-inline"><input type="radio" name="type" value="3" @if($good) disabled @endif @if($good['type']  == 3)checked="true" @endif  onclick="$('#type_virtual').show();" /> 虚拟物品(卡密)</label>

        <label class="radio-inline"><input type="radio" name="type" value="10" @if($good) disabled @endif @if($good['type']  == 10)checked="true" @endif  onclick="$('#type_virtual').hide();$('#product').hide();" /> 话费流量充值</label>


        <span class="help-block">商品类型，商品保存后无法修改，请谨慎选择</span>

    </div>
</div>


<div class="form-group send-group" style="@if(object_get($good,'type','0') != 2)display: none;@endif">
    <label class="col-sm-2 control-label">自动发货</label>
    <div class="col-sm-9 col-xs-12">
        <label class="radio-inline"><input type="radio" name="virtualsend" value="0"  @if(!$good['virtualsend'])checked="true" @endif/> 否</label>
        <label class="radio-inline"><input type="radio" name="virtualsend" value="1" @if($good['virtualsend']==1)checked="true" @endif   /> 是</label>
        <span class="help-block">提示：发货后订单自动完成</span>
    </div>
</div>

<div class="form-group send-group" style="@if(object_get($good,'type','0') != 2)display: none;@endif{/if}">
    <label class="col-sm-2 control-label">自动发货内容</label>
    <div class="col-sm-9 col-xs-12">
        <textarea class="form-control" name="virtualsendcontent">{{$good['virtualsendcontent']}}</textarea>
    </div>
</div>


<div class="form-group" style="@if(object_get($good,'type','0') != 3)display: none;@endif" id="type_virtual" {if !empty($good['id'])}disabled{/if}>
<label class="col-sm-2 control-label"></label>
<div class="col-sm-6 col-xs-6">


    <select class="form-control select2" id="virtual" name="virtual">
        <option value="0">多规格虚拟物品</option>
        @if(is_array($virtualTypes))
        @foreach($virtualTypes as $virtualType)
        <option value="{{$virtualType['id']}}" @if($good['virtual'] == $virtualType['id'])selected="true"@endif>{{$virtualType['usedata']}}/{{$virtualType['alldata']}}| {{$virtualType['title']}}</option>
        @endforeach
        @endif
    </select>
    <span>提示：直接选中虚拟物品模板即可，选择多规格需在商品规格页面设置</span>
</div>
</div>

<div class="form-group splitter"></div>
<div class="form-group">
    <label class="col-sm-2 control-label">商品分类</label>
    <div class="col-sm-8 col-xs-12">

        <select id="sel_menu2" multiple="multiple" class="form-control" name="cates[]">
            @foreach($categorys as $category)
                <option value="{{$category['id']}}" @if(is_array($categorys) && in_array($category['id'],$good['category'])) selected @endif >{{$category['name']}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">商品属性</label>
    <div class="col-sm-9 col-xs-12" >
        <label for="isrecommand" class="checkbox-inline">
            <input type="checkbox" name="isrecommand" value="1" id="isrecommand" @if($good['isrecommand'] == 1) checked="true" @endif /> 推荐
        </label>
        <label for="isnew" class="checkbox-inline">
            <input type="checkbox" name="isnew" value="1" id="isnew" @if($good['isnew'] == 1) checked="true" @endif /> 新品
        </label>
        <label for="ishot" class="checkbox-inline">
            <input type="checkbox" name="ishot" value="1" id="ishot" @if($good['ishot'] == 1) checked="true" @endif  /> 热卖
        </label>

        <label for="issendfree" class="checkbox-inline">
            <input type="checkbox" name="issendfree" value="1" id="issendfree" @if($good['issendfree'] == 1) checked="true" @endif  /> 包邮
        </label>

        <label for="isnodiscount" class="checkbox-inline">
            <input type="checkbox" name="isnodiscount" value="1" id="isnodiscount" @if($good['isnodiscount'] == 1) checked="true" @endif  /> 不参与会员折扣
        </label>
    </div>
</div>

<div class="form-group splitter"></div>


<div class="form-group">
    <label class="col-sm-2 control-label">商品价格</label>
    <div class="col-sm-9 col-xs-12">

        <div class="input-group">
            <input type="text" name="marketprice" id="marketprice" class="form-control" value="{{$good['marketprice']}}" />
            <span class="input-group-addon">元 原价</span>
            <input type="text" name="productprice" id="productprice" class="form-control" value="{{$good['productprice']}}" />
            <span class="input-group-addon">元 成本</span>
            <input type="text" name="costprice" id="costprice" class="form-control" value="{{$good['costprice']}}" />
            <span class="input-group-addon">元</span>
        </div>
        <span class='help-block'>尽量填写完整，有助于于商品销售的数据分析</span>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label must">商品图片</label>
    <div class="col-sm-9 col-xs-12 gimgs">
       {{-- {!! tpl_form_field_multi_image('thumbs',$good['piclist']) !!}--}}
        <input class="fileupload" type="file" name="thumbs" data-url="/uploadImage" multiple data-option="thumbs[]">
        <div class="imgcontainer">
            @if($good['thumb'])
                @foreach($good['piclist'] as $image)
                <div style="width:115px;display:inline-block">
                    <input name="thumbs[]" value="{{$image}}" type="hidden">
                    <img src="{{$image}}" style="width:100px">
                    <em class="close deleteimg" title="删除这张图片">×</em>
                </div>
                @endforeach
            @endif
        </div>
        <span class="help-block image-block">第一张为缩略图，建议为正方型图片，其他为详情页面图片，尺寸建议宽度为640，并保持图片大小一致</span>
        <span class="help-block">您可以拖动图片改变其显示顺序 </span>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-9 col-xs-12">

        <label class="checkbox-inline"><input type="checkbox" name="thumb_first" value="1" @if($good['thumb_first'] == 1)checked="true" @endif   /> 详情显示首图</label>
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group" @if($good['type'] == 10) style="display:none" @endif>
<label class="col-sm-2 control-label">已出售数</label>
<div class="col-sm-6 col-xs-12">

    <div class="input-group">
        <input type="text" name="sales" id="sales" class="form-control" value="{{$good['sales']}}" />
        <span class="input-group-addon">件</span>
    </div>
    <span class="help-block">物品虚拟出售数，会员下单此数据就增加, 无论是否支付</span>
</div>
</div>
<div class="form-group splitter dispatch_info" @if($good['type'] != 1)style="display: none;" @endif></div>
<div class="form-group dispatch_info" @if($good['type'] != 1)style="display: none;" @endif>
<label class="col-sm-2 control-label">运费设置</label>
<div class="col-sm-6 col-xs-6" style='padding-left:0'>
    <div class="input-group">
        <span class='input-group-addon' style='border:none'><label class="radio-inline" style='margin-top:-7px;' ><input type="radio" name="dispatchtype" value="0" @if(!$good['dispatchtype'])checked="true" @endif}   /> 运费模板</label></span>
        <select class="form-control tpl-category-parent select2" id="dispatchid" name="dispatchid">
            <option value="0">默认模板</option>
            @foreach($dispatchs as $dispatch)
            <option value="{{$dispatch['id']}}" @if($good['dispatchid'] == $dispatch['id'])selected="true"@endif>{{$dispatch['dispatchname']}}</option>
            @endforeach
        </select>
    </div>
</div>
</div>
<div class="form-group dispatch_info" @if($good['type'] != 1)style="display: none;" @endif>
<label class="col-sm-2 control-label"></label>
<div class="col-sm-6 col-xs-6" style='padding-left:0'>
    <div class="input-group">
        <span class='input-group-addon' style='border:none'><label class="radio-inline"  style='margin-top:-7px;' ><input type="radio"name="dispatchtype" value="1"  @if($good['dispatchtype'] == 1) checked="true" @endif  /> 统一邮费</label></span>
        <input type="text" name="dispatchprice" id="dispatchprice" class="form-control" value="{{$good['dispatchprice']}}" />
        <span class="input-group-addon">元</span>
    </div>
</div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">原产地</label>
    <div class="col-sm-10 col-xs-10">
        <select id="sheng" name='sheng'  class="form-control" style='width:100px;display: inline-block' >
            @if($good['sheng'])
            <option value="{{$good['sheng']}}" selected="true">{{array_get($good['province'],'Add_Name','')}}</option>
            @else
            <option value="" selected="true">省/直辖市</option>
            @endif
        </select>
        <select id="shi" name='shi'   class="form-control" style='width:100px;display: inline-block' >
            @if($good['shi'])
            <option value="{{$good['sheng']}}" selected="true">{{array_get($good['city'], 'Add_Name' , '')}}</option>
            @else
            <option value="" selected="true">请选择</option>
            @endif
        </select>
        <select id="qu" name='qu'  class="form-control" style='width:100px; margin-right:10px;display: inline-block;' >
            @if($good['qu'])
            <option value="{{$good['qu']}}" selected="true">{{array_get($good['area'],'Add_Name','')}}</option>
            @else
            <option value="" selected="true">请选择</option>
            @endif
        </select>

        <!--<div class="col-sm-2">-->
        <label class="radio-inline"><input type="radio" style="display: inline-block;" name="other" value="1" @if($good['other'] == 1) checked="true" @endif  /> 其他</label>
        <input type="text" name="other_value" id="other_value" class="form-control" style='width:100px;display: inline-block;' value="{{$good['other_value']}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">推荐单位</label>
    <div class="col-sm-8 col-xs-12">
        <select id="recommend"  name='recommend' class="form-control select2" style='width: 310px;' >
            <option value="0">无推荐单位</option>
            @foreach($companyies as $company)
            <option value="{{$company['id']}}" @if($good && $good['recommend'] == $company['id'])selected @endif >{{$company['text']}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">推荐描述</label>
    <div class="col-sm-6 col-xs-12">
        <div class="input-group">
            <input type="text" name="referrer"  class="form-control" value="{{$good['referrer']}}" placeholder=" 人/部门/其他" style="width: 320px;"/>
        </div>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">其他</label>
    <div class="col-sm-9 col-xs-12">
        <label class="checkbox-inline" @if($good['isverify'] == 2) style="display:none;" @endif><input type="checkbox" name="cash" value="2"  @if($good['cash'] == 2) checked="true" @endif  /> 货到付款</label>
        <label class="checkbox-inline"><input type="checkbox" name="quality" value="1" @if($good['quality']) checked="true" @endif   /> 正品保证</label>
        <label class="checkbox-inline"><input type="checkbox" name="seven" value="1" @if($good['seven']) checked="true" @endif  /> 7天无理由退换</label>
        <label class="checkbox-inline"><input type="checkbox" name="invoice" value="1" @if($good['invoice']) checked="true" @endif   /> 发票</label>
        <label class="checkbox-inline"><input type="checkbox" name="repair" value="1" @if($good['repair']) checked="true" @endif   /> 保修</label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">上架</label>
    <div class="col-sm-9 col-xs-12">

        <label class="radio-inline"><input type="radio" name="status" value="0" @if(!$good['status']) checked="true" @endif/> 否</label>
        <label class="radio-inline"><input type="radio" name="status" value="1" @if($good['status']) checked="true" @endif   /> 是</label>
        <!--<span class="help-block"></span>-->
    </div>
</div>

<!-- 商品是否显示，add by tianchao 2018-2-28 -->
<div class="form-group">
    <label class="col-sm-2 control-label">显示</label>
    <div class="col-sm-9 col-xs-12">
        <label class="radio-inline"><input type="radio" name="isshow" value="0" @if($good['isshow'] == 0 )  checked="true" @endif/> 否</label>
        <label class="radio-inline"><input type="radio" name="isshow" value="1" @if(!$good || $good['isshow'] == 1) checked="true" @endif/> 是</label>
        <!--<span class="help-block"></span>-->
    </div>
</div>
<!-- end -->

<div class="form-group" style="display: none;">
    <label class="col-sm-2 control-label">是否支持拼团</label>
    <div class="col-sm-9 col-xs-12">
        <label>
            <input type="checkbox" class="js-switch" @if($good['groupstype'] == 1) checked @endif name="groupstype" />
        </label>
        <span class="help-block"></span>
    </div>
</div>



