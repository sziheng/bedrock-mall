
<table class="table" style="width:50%">
    <thead>
    <tr>

        <td style='width:150px;'>参数名称</td>
        <td>参数值 <small>拖动行可进行排序</small></td>
        <th style='width:50px;'></th>
    </tr>
    </thead>
    <tbody id="param-items">
    @foreach($params as $param)
    <tr>
        <td>
            <input name="param_title[]" type="text" class="form-control param_title" value="{{$param['title']}}"/>
            <input name="param_id[]" type="hidden" class="form-control" value="{{$param['id']}}"/>
        </td>
        <td>
            <input name="param_value[]" type="text" class="form-control param_value" value="{{$param['value']}}"/>
        </td>
        <td>
            <a href="javascript:;" class='btn btn-default btn-sm' onclick="deleteParam(this)" title="删除"><i class='fa fa-remove'></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tbody>
    <tr>
        <td colspan="3">
            <a href="javascript:;" id='add-param' onclick="addParam()" class="btn btn-default"  title="添加参数"><i class='fa fa-plus'></i> 添加参数</a>
        </td>
    </tr>
    </tbody>
</table>


<script language="javascript">
    $(function() {
        requirejs.config({
            shim: {
                'vaildate' : ['jquery'],
                'jquery.ui': ['jquery'],
                'util' : ['jquery'],
                'fileUploader' : ['jquery'],
                'bootstrap' : ['jquery']
            },
            paths : {
                'jquery' : '/vendors/jquery/dist/jquery.min',
                'vaildate' : '/js/jquery.validate.min',
                'jquery.ui' : '/js/jquery-ui-1.10.3.min',
                'bootstrap' : '/vendors/bootstrap/dist/js/bootstrap.min',
                'util' : '/upload/util',
                'fileUploader' : '/upload/fileUploader'
            }
        });
/*        require(['vaildate'], function () {
            $('#goodform').vaildate({
                submitHandler:function(form){
                    alert(1);
                    return false
                }
            })
        });*/
        require(['jquery.ui'],function(){
            $("#param-items").sortable();
        });
        $("#chkoption").click(function() {
            var obj = $(this);
            if (obj.get(0).checked) {
                $("#tboption").show();
                $(".trp").hide();
            }
            else {
                $("#tboption").hide();
                $(".trp").show();
            }
        });
    })
    function addParam() {
        var url = "/good/addParams?tpl=param";
        $.ajax({
            "url": url,
            success: function(data) {
                $('#param-items').append(data);
            }
        });
        return;
    }
    function deleteParam(o) {
        $(o).parent().parent().remove();
    }
</script>