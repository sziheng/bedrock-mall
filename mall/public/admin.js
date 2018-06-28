//商品分类显示/隐藏事件
$(function(){

    //加载显示数据
    //1.加载省份
    FillSheng();

    //2.加载市
    //    FillShi();
    // //3.加载区
    //    FillQu();

    //当省份选中变化，重新加载市和区
    $("#sheng").change(function(){ //当元素的值发生改变时，会发生 change 事件,该事件仅适用于文本域（text field），以及 textarea 和 select 元素。
        if($(this).val()== 0){
            var cityhtml = ' <option value="" selected="true">请选择</option>';
            $("#shi").html(cityhtml);
            var areahtml = ' <option value="" selected="true">请选择</option>';
            $("#qu").html(areahtml);
        }else{
            //加载市
            FillShi();
            //加载区
            FillQu();
        }


    });

    //当市选中变化，重新加载区
    $("#shi").change(function(){
        //加载区
        FillQu();
    })

})




//加载省份信息
function FillSheng()
{
    //取父级代号
    var pcode ="0";

    //根据父级代号查数据
    $.ajax({
        //取消异步，也就是必须完成上面才能走下面
        async:false,
        url:"/web/good/chooseAddress",
        data:{pcode:pcode},
        type:"POST",
        dataType:"JSON",
        success: function(data){
            var str="";
            //遍历数组，把它放入sj
            for(var sj in data){
                str=str+"<option value='"+data[sj].Add_Code+"'>"+data[sj].Add_Name +"</option>";
            }
            var yuan=$('#sheng').html();
            $("#sheng").html(yuan+str);

        }
    });
}

//加载市信息
function FillShi()
{
    //取父级代号
    var pcode =$("#sheng").val();

    //根据父级代号查数据
    $.ajax({
        //取消异步，也就是必须完成上面才能走下面
        async:false,
        url:"/web/good/chooseAddress",
        data:{pcode:pcode},
        type:"POST",
        dataType:"JSON",
        success: function(data){
            var str="";
            //遍历数组，把它放入sj
            for(var sj in data){
                //<option value="11">北京</option>
                str=str+"<option value='"+data[sj].Add_Code+"'>"+data[sj].Add_Name +"</option>";
            }
            $("#shi").html(str);

        }



    });

}


//加载区信息
function FillQu()
{
    //取父级代号
    var pcode =$("#shi").val();

    //根据父级代号查数据
    $.ajax({
        //不需要取消异步
        url:"/web/good/chooseAddress",
        data:{pcode:pcode},
        type:"POST",
        dataType:"JSON",
        success: function(data){
            var str="";
            //遍历数组，把它放入sj
            for(var sj in data){
                //<option value="11">北京</option>
                str=str+"<option value='"+data[sj].Add_Code+"'>"+data[sj].Add_Name +"</option>";

            }
            $("#qu").html(str);

        }



    });

}








