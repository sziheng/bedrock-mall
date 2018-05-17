$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})
//商品分类显示/隐藏事件
$(function(){
    $('.ishome').click(function(){
        var t = $(this);
        var id = $(this).data('id');
        if (t.html() == '隐藏') {
            ishome = 1;
        } else {
            ishome = 0
        }
        $.post("/category/"+id+"/ishome",{ishome:ishome},function(result){
            if (result.error){
                alert(result.msg)
            }else{
                if(ishome == 1){
                    t.attr('class','btn ishome btn-info  btn-xs');
                    t.html('显示')
                } else {
                    t.attr('class','btn ishome btn-default  btn-xs')
                    t.html('隐藏')
                }

            }
        });
    })

})

