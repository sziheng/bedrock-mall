
<div class="spec_item_item" style="float:left;margin:5px;width:250px; position: relative">
	<input type="hidden" class="form-control spec_item_show" name="spec_item_show_{{array_get($spec,'id','0')}}[]" value="{{array_get($specitem,'show','0')}}" />
	<input type="hidden" class="form-control spec_item_id" name="spec_item_id_{{array_get($spec,'id','0')}}[]" value="{{array_get($specitem,'id','0')}}" />
	
	<div class="input-group">
		<span class="input-group-addon">
			<input type="checkbox" @if(array_get($specitem,'show','0') == 1)checked @endif value="1" onclick='showItem(this)'>
		</span>
		<input type="text" class="form-control spec_item_title" name="spec_item_title_{{array_get($spec,'id','0')}}[]" VALUE="{{array_get($specitem,'title','0')}}" />
		
		{{--<span class="input-group-addon spec_item_thumb {if !empty($specitem['thumb'])}has_thumb{/if}">
			           <input type='hidden'  name="spec_item_thumb_{{array_get('$spec','id','0')}}[]" value="{$specitem['thumb']}"
						/>
				<img onclick="selectSpecItemImage(this)" onerror="this.src='{php echo WESHOP_LOCAL}static/images/nopic100.jpg'"
					 src="{if empty($specitem['thumb'])}{php echo WESHOP_LOCAL}static/images/nopic100.jpg{else}{php echo tomedia($specitem['thumb'])}{/if}" style='width:100%;'
					 {if !empty($specitem['thumb'])}
							data-toggle='popover'
							data-html ='true'
							data-placement='top'
							data-trigger ='hover'
							data-content="<img src='{php echo tomedia($specitem['thumb'])}' style='width:100px;height:100px;' />"
                                                            {/if}
					 >
				<i class="fa fa-times-circle" {if empty($specitem['thumb'])}style="display:none"{/if}></i> 
		</span>--}}
		
		<span class="input-group-addon">
			<a href="javascript:;" onclick="removeSpecItem(this)" title='删除'><i class="fa fa-times"></i></a>
	  		<a href="javascript:;" class="fa fa-arrows" title="拖动调整显示顺序" ></a>
		</span>
	</div>
  
                         <div class="input-group choosetemp" style='margin-bottom: 10px;@if(array_get($good,'type','0') !=4) display:none @endif'>
                        <input type="hidden" name="spec_item_virtual_{{array_get($spec,'id','0')}}[]" value="{{array_get($specitem,'virtual','0')}}" class="form-control spec_item_virtual"  id="temp_id_{{array_get($specitem,'id','0')}}">
                        <input type="text" name="spec_item_virtualname_{{array_get($spec,'id','0')}}[]" value="@if(!array_get($specitem,'virtual','0'))}未选择@else{{array_get($specitem,'title2','0')}}@endif" class="form-control spec_item_virtualname" readonly="" id="temp_name_{{array_get($specitem,'id','0')}}">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="choosetemp('{{array_get($specitem,'id','0')}}')">选择虚拟物品</button>
                        </div>
                    </div>
</div>


