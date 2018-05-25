$(function(){
    $('.layer').click(function(){
        var content = $(this).data('content');
        var url = $(this).data('url');
        var type = $(this).data('type');
        if( type == 'list') {
            var id = []
            $('.ids').each(function(){
                if($(this).is(":checked")){
                    id.push($(this).data('id'));
                }
            })
        } else {
            var id = $(this).data('id');
        }

        var params = $(this).data('params');
        var json = {
            "id" : id,
            "params" : params
        }
        layer.confirm(content, {
            btn: ['确认','关闭'] //按钮
        }, function(){
            $.post(url,json,function(result){
                if (result.error) {
                    alert(result.msg);
                } else {
                    window.location.reload();
                }
            });

        }, function(){
            layer.close();
        });
    })
})