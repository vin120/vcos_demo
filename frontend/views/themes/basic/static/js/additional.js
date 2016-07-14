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
		
		var str = '';
		//循环包含产品，显示右边总价
		$(".contains_product>ul>li").each(function(){
			
			var shore_code = $(this).find("span.shore_info").attr("id");
			var shore_name = $(this).find("span.shore_info").html();
			var shore_price = $(this).find("span.shore_info").attr('price');
			
			var count = $(this).find(".traveler ul li input[type='checkbox']:checked").length;
			if(count > 0){
				var count_price = parseFloat(shore_price)*parseInt(count);
				str += '<tr count="'+count_price+'" shore_code="'+shore_code+'">';
				str += '<td>'+shore_name+'</td>';
				str += '<td>'+count+'份</td>';
				str += '<td>￥'+shore_price+'</td>';
				str += '</tr>';
				
			}
			$(".orderForm .add>table>thead").html(str);
		});
		
		count_contains_additional_product();
		
		
	});
	
	
	//附加产品
	$(".additional_product .itemContent .checkbox input").on('click',function(){
		//获取当前点击乘客唯一值key
		
		var str = '';
		
		//循环附加产品，显示右边总价
		$(".additional_product>ul>li").each(function(){
			
			var surcharge_code = $(this).find("span.surcharge_info").attr("id");
			var surcharge_name = $(this).find("span.surcharge_info").html();
			var surcharge_price = $(this).find("span.surcharge_info").attr('price');
			
			var count = $(this).find(".traveler ul li input[type='checkbox']:checked").length;
			if(count > 0){
				var count_price = parseFloat(surcharge_price)*parseInt(count);
				str += '<tr count="'+count_price+'" surcharge_code="'+surcharge_code+'">';
				str += '<td>'+surcharge_name+'</td>';
				str += '<td>'+count+'份</td>';
				str += '<td>￥'+surcharge_price+'</td>';
				str += '</tr>';
				
			}
			$(".orderForm .add>table>tbody").html(str);
			
		});
		
		count_contains_additional_product();
	});
	
	
	
	//船舱房间选择
	$(".cabins_distribution select").on('change',function(){
		var curr_val = $(this).val();
		var cabin_type = $(this).parents("tr").attr("cabin_type");
		var person_type = $(this).find("option:selected").attr('person_type');
		var live_num = $(this).parents("tr").attr("live_num");
		var old_selected = $(this).attr("old_selected");
		
		if(person_type == 2){
			var length = 0;
			$(this).parents("tr").find("select[name='cabin_per[]']").each(function(){
				var this_val = $(this).val();
				if(this_val!=''){
					var person = $(this).find("option:selected").attr('person_type');
					if(person == '1'){
						length += 1;
					}
				}
				
			});
			
			if(length < live_num){
				alert("该船舱至少需入住"+live_num+"个成人，请先选择入住成人");
				$(this).find("option:selected").removeClass('selected');
				$(this).find("option[value='"+old_selected+"']").prop("selected","selected");return false;
			}
		}
		
		//修改old_selected 成当前选中值
		$(this).attr('old_selected',curr_val);
		
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

	var json_data = joint_json();
	//入库保存
	
	return true;
}

//拼接json
function joint_json(){
	//var data_arr = '[{"additional":{';
	
	//拼接包含产品
	var contains_product = '"contains_product":[';
	var contains_data = '';
	$(".contains_product>ul>li").each(function(){
		
		var shore_code = $(this).find("span.shore_info").attr("id");
		var shore_name = $(this).find("span.shore_info").html();
		var shore_price = $(this).find("span.shore_info").attr('price');
		var length = $(this).find(".traveler ul li input[type='checkbox']:checked").length;
		if(length>0){
			contains_data += '{"shore_code":"'+shore_code+'","shore_name":"'+shore_name+'","shore_price":"'+shore_price+'","person_key":[';
			var keys = '';
			$(this).find(".traveler ul li input[type='checkbox']:checked").each(function(){
				var key_this = $(this).val();
				keys += '"'+key_this+'",';
			});
			keys = keys.substring(0,keys.length-1);
			contains_data += keys ;
			contains_data += ']},';
		}

		
	});
	contains_data = contains_data.substring(0,contains_data.length-1);
	contains_product += contains_data;
	contains_product += '],';
	
	//拼接附加产品
	var additional_product = '"additional_product":[';
	var additional_data = '';
	$(".additional_product>ul>li").each(function(){
		
		var surcharge_code = $(this).find("span.surcharge_info").attr("id");
		var surcharge_name = $(this).find("span.surcharge_info").html();
		var surcharge_price = $(this).find("span.surcharge_info").attr('price');
		var length = $(this).find(".traveler ul li input[type='checkbox']:checked").length;
		if(length>0){
			additional_data += '{"surcharge_code":"'+surcharge_code+'","surcharge_name":"'+surcharge_name+'","surcharge_price":"'+surcharge_price+'","person_key":[';
			var keys = '';
			$(this).find(".traveler ul li input[type='checkbox']:checked").each(function(){
				var key_this = $(this).val();
				keys += '"'+key_this+'",';
			});
			keys = keys.substring(0,keys.length-1);
			additional_data += keys ;
			additional_data += ']},';
		}

		
	});
	additional_data = additional_data.substring(0,additional_data.length-1);
	additional_product += additional_data;
	additional_product += '],';
	
	
	//拼接房间
	var cabins_distribution = '"cabins_distribution":[';
	var cabins_data = '';
	$(".cabins_distribution >table>tbody tr").each(function(){
		var cabin_type = $(this).attr("cabin_type");
		cabins_data += '{"cabin_type":"'+cabin_type+'","person_key":[';
		var person_key = '';
		$(this).find("td select[name='cabin_per[]']").each(function(){
			var key = $(this).val();
			if(key!=''){
				person_key += '"'+key+'",';
			}
		});
		person_key = person_key.substring(0,person_key.length-1);
		cabins_data += person_key;
		cabins_data += ']},';
		
	});
	
	cabins_data = cabins_data.substring(0,cabins_data.length-1);
	cabins_distribution += cabins_data;
	cabins_distribution += ']'
	
	var data_arr = '[{"additional":{';
	data_arr += contains_product;
	data_arr += additional_product;
	data_arr += cabins_distribution;
	data_arr += '}}]'
	
	$.ajax({
	    url:save_session_additional,
	    type:'post',
	    async:false,
	    data:'data_arr='+data_arr,
	 	dataType:'json',
		
	});
	
	return 1;
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
		alert("存在乘客未选择观光路线");success = 0;
	}
	
	return success;
	
}

//房间分配验证
function checkcabin_person(){
	var success = 0;
	//获取总人数
	var all_count = $(".contains_product ul li:first-child .itemContent .traveler input[type='checkbox']").length;
	
	var checked_count = $(".cabins_distribution table tbody tr select option[value!='']:checked").length;
	
	if(all_count == checked_count){
		success = 1;
	}else{
		alert("存在乘客未选择舱房床位");success = 0;
	}
	if(success == 0){return false;}
	//判断是否存在空船舱
	$(".cabins_distribution table tbody tr").each(function(){
		var selected_num = $(this).find("select option[value!='']:checked").length;
		
		if(selected_num == 0){
			alert("不能存在空船舱");success = 0;return false;
		}
		
	});
	
	return success;
	
}


//计算包含产品及附加产品总价格
function count_contains_additional_product(){
	
	var length = $(".orderForm .add table tr").length;
	if(length == 0){
		$(".orderForm .add .head").css('display','none');
	}else{
		$(".orderForm .add .head").css('display','block');
		var count_price = 0;
		$(".orderForm .add table tr").each(function(){
			count_price += parseFloat($(this).attr('count'));
		});
		$(".orderForm .add .head>.price").html("￥"+count_price);
	}
	
}

