<div class="form-group">
    <label class="col-sm-2 control-label">单次最多购买</label>
    <div class="col-sm-6 col-xs-12">

        <div class="input-group">
            <input type="text" name="maxbuy" id="maxbuy" class="form-control" value="{{$good['maxbuy']}}" />
            <span class="input-group-addon">件</span>

        </div>
        <span class="help-block">用户单次购买此商品数量限制</span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">单次最低购买</label>
    <div class="col-sm-6 col-xs-12">
        <div class="input-group">
            <input type="text" name="minbuy" id="minbuy" class="form-control" value="{{$good['minbuy']}}" />
            <span class="input-group-addon">件</span>

        </div>
        <span class="help-block">用户单次必须最少购买此商品数量限制</span>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">最多购买</label>

    <div class="col-sm-6 col-xs-12">
        <div class="input-group">
            <input type="text" name="usermaxbuy" class="form-control" value="{{$good['usermaxbuy']}}" />
            <span class="input-group-addon">件</span>
        </div>
        <span class="help-block">用户购买过的此商品数量限制</span>

    </div>
</div>

{{--
<div class="form-group">
    <label class="col-sm-2 control-label">会员等级浏览权限</label>
    <div class="col-sm-9 col-xs-12 chks">
        {ife 'goods' $item}
        <select name='showlevels[]' class='form-control select2' multiple=''>
            <!--<option value="0"  {if $item['showlevels']!='' && is_array($item['showlevels'])  && in_array('0', $item['showlevels'])}selected{/if}>普通等级</option>-->
            {loop $levels $level}
            <option value="{$level['id']}" {if is_array($item['showlevels']) && in_array($level['id'], $item['showlevels'])}selected{/if}>{$level['levelname']}</option>
            {/loop}
        </select>
        <span class='help-block'>不设置默认全部会员等级</span>

        {else}
        <div class='form-control-static'>
            {if $item['showlevels']==''}
            全部会员等级
            {else}
            {if $item['showlevels']!='' && is_array($item['showlevels']) && in_array('0', $item['showlevels'])}
            {php echo empty($shop['levelname'])?'普通等级':$shop['levelname']};
            {/if}
            {loop $levels $level}
            {if $item['showlevels']!='' && is_array($item['showlevels'])  && in_array($level['id'], $item['showlevels'])}
            {$level['levelname']};
            {/if}
            {/loop}
            {/if}
        </div>

        {/if}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">会员等级购买权限</label>
    <div class="col-sm-9 col-xs-12 chks" >
        {ife 'goods' $item}
        <select name='buylevels[]' class='form-control select2' multiple=''>

            <!--<option value="0"  {if $item['buylevels']!='' && is_array($item['buylevels'])  && in_array('0', $item['buylevels'])}selected{/if}>普通等级</option>-->
            {loop $levels $level}
            <option value="{$level['id']}" {if is_array($item['buylevels']) && in_array($level['id'], $item['buylevels'])}selected{/if}>{$level['levelname']}</option>
            {/loop}
        </select>
        <span class='help-block'>不设置默认全部会员等级</span>
        {else}
        <div class='form-control-static'>
            {if $item['buylevels']==''}
            全部会员等级
            {else}
            {if $item['buylevels']!='' && is_array($item['buylevels']) && in_array('0', $item['buylevels'])}
            {php echo empty($shop['levelname'])?'普通等级':$shop['levelname']};
            {/if}
            {loop $levels $level}
            {if $item['buylevels']!='' && is_array($item['buylevels'])  && in_array($level['id'], $item['buylevels'])}
            {$level['levelname']};
            {/if}
            {/loop}
            {/if}
        </div>

        {/if}


    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">会员组浏览权限</label>
    <div class="col-sm-9 col-xs-12 chks" >
        {ife 'goods' $item}
        <select name='showgroups[]' class='form-control select2' multiple=''>
            <option value="0"  {if $item['showgroups']!='' && is_array($item['showgroups'])  && in_array('0', $item['showgroups'])}selected{/if}>无分组</option>
            {loop $groups $group}
            <option value="{$group['id']}" {if is_array($item['showgroups']) && in_array($group['id'], $item['showgroups'])}selected{/if}>{$group['groupname']}</option>
            {/loop}
        </select>
        <span class='help-block'>不设置默认全部会员分组</span>

        {else}
        <div class='form-control-static'>
            {if $item['showgroups']==''}
            全部会员等级
            {else}
            {if $item['showgroups']!='' && is_array($item['showgroups']) && in_array('0', $item['showgroups'])}
            {php echo empty($shop['levelname'])?'普通等级':$shop['levelname']};
            {/if}
            {loop $levels $level}
            {if $item['showgroups']!='' && is_array($item['showgroups'])  && in_array($level['id'], $item['showgroups'])}
            {$level['levelname']};
            {/if}
            {/loop}
            {/if}
        </div>

        {/if}

    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">会员组购买权限</label>
    <div class="col-sm-9 col-xs-12 chks" >
        {ife 'goods' $item}
        <select name='buygroups[]' class='form-control select2' multiple=''>
            <option value="0"  {if $item['buygroups']!='' && is_array($item['buygroups'])  && in_array('0', $item['buygroups'])}selected{/if}>无分组</option>
            {loop $groups $group}
            <option value="{$group['id']}" {if is_array($item['buygroups']) && in_array($group['id'], $item['buygroups'])}selected{/if}>{$group['groupname']}</option>
            {/loop}
        </select>
        <span class='help-block'>不设置默认全部会员分组</span>
        {else}
        <div class='form-control-static'>
            {if $item['buygroups']==''}
            全部会员等级
            {else}
            {if $item['buygroups']!='' && is_array($item['buygroups']) && in_array('0', $item['buygroups'])}
            {php echo empty($shop['levelname'])?'普通等级':$shop['levelname']};
            {/if}
            {loop $levels $level}
            {if $item['buygroups']!='' && is_array($item['buygroups'])  && in_array($level['id'], $item['buygroups'])}
            {$level['levelname']};
            {/if}
            {/loop}
            {/if}
        </div>

        {/if}

    </div>
</div>--}}
