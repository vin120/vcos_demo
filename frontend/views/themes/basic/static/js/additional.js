$(function() {
	$(".itemBtn a").on("click",function() {
		var index = $(this).index();

		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(this).parents("li").find(".itemContent div").eq(index).slideUp();
		} else {
			$(this).addClass("active").siblings().removeClass("active");
			$(this).parents("li").find(".itemContent div").eq(index).slideDown().siblings().slideUp();
		}
		
		return false;
	});
	
	//包含产品点击
	$(".contains_product .itemContent .checkbox input").on('click',function(){
		//获取当前点击乘客唯一值key
		var key = $(this).val();
		var checked  = $(this).prop('checked');
		var index = $(".contains_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").index(this);
		if(checked == true){
			//选中
			$(".contains_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").each(function(){
				var curr_index  = $(".contains_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").index(this);
				if(index != curr_index){
					$(this).attr("disabled","disabled");
					
					}
			});
		}else if(checked == false){
			//取消选中
			$(".contains_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").each(function(){
				var curr_index  = $(".contains_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").index(this);
				if(index != curr_index){
					$(this).removeAttr("disabled");
					
					}
			});
		}
		
	});
	
	
	//附加产品
	$(".additional_product .itemContent .checkbox input").on('click',function(){
		//获取当前点击乘客唯一值key
		var key = $(this).val();
		var checked  = $(this).prop('checked');
		var index = $(".additional_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").index(this);
		if(checked == true){
			//选中
			$(".additional_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").each(function(){
				var curr_index  = $(".additional_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").index(this);
				if(index != curr_index){
					$(this).attr("disabled","disabled");
					
					}
			});
		}else if(checked == false){
			//取消选中
			$(".additional_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").each(function(){
				var curr_index  = $(".additional_product .itemContent .traveler>ul li input[type='checkbox'][value='"+key+"']").index(this);
				if(index != curr_index){
					$(this).removeAttr("disabled");
					
					}
			});
		}
		
	});
	
	
	//船舱房间选择
	$(".cabins_distribution select").on('change',function(){
		var curr_val = $(this).val();
		var cabin_type = $(this).parents("tr").attr("cabin_type");
		
		//获取该船舱房全部乘客
		var cabins_all = new Array();
		$(".cabins_distribution tr[cabin_type='"+cabin_type+"'] select").eq(0).find("option").each(function(){
			var cabin = $(this).val();
			if(cabin!='')
			cabins_all.push(cabin);
		});
		//获取已经选中的乘客
		var cabin_checked = new Array();
		$(".cabins_distribution tr[cabin_type='"+cabin_type+"'] select option:checked").each(function(){
			var cabin = $(this).val();
			if(cabin!='')
			cabin_checked.push(cabin);
		});
		
		$.each(cabins_all,function(i,val){
			if($.inArray(val, cabin_checked) == -1){
				$(".cabins_distribution tr[cabin_type='"+cabin_type+"'] select option[value='"+val+"']").css("display","block");
			}
		});
		
		if(curr_val!=''){
			$(".cabins_distribution tr[cabin_type='"+cabin_type+"'] select option[value='"+curr_val+"']").css("display","none");
			$(this).find("option[value='"+curr_val+"']").css("display","block");
		}
	});
	
	
});

//附加费保存
function saveaddition(){
	var success = 1;
	//判断包含产品选择验证
	var success = checkcontains_product();
	if(success == 0){return false;}
	
	//房间分配验证
	var success = checkcabin_person();
	if(success == 0){return false;}
	return false;
}


//判断包含产品选择验证、
function checkcontains_product(){
	var success = 0;
	//获取总人数
	var all_count = $(".contains_product ul li:first-child .itemContent .traveler input[type='checkbox']").length;
	
	var checked_count = $(".contains_product .traveler input[type='checkbox']:checked").length;
	
	if(all_count == checked_count){
		success = 1;
	}else{
		alert("存在乘客未选择观光路线");
	}
	
	return success;
	
}

//房间分配验证
function checkcabin_person(){
	var success = 0;
	//获取总人数
	var all_count = $(".contains_product ul li:first-child .itemContent .traveler input[type='checkbox']").length;
	
	var checked_count = $(".cabins_distribution tr select option[value!='']:checked").length;
	
	if(all_count == checked_count){
		success = 1;
	}else{
		alert("存在乘客未选择舱房床位");
	}
	
	return success;
	
}