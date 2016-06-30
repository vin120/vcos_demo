$(function() {
	// tab选项卡
	$(".tabTitle li").on("click",function() {
		$(this).addClass("active").siblings(".active").removeClass("active");
		$("html,body").animate({scrollTop: ($(".tabContent > *").eq($(this).index()).offset().top - 66)}, 1000);
		
		return false;
	});

	var top = $(".roomType").offset().top;
	var height = 66;
	
	// 滚动条事件
	$(window).scroll(function() {
		if ($(this).scrollTop() > top) {
			if ($(".roomType").hasClass("fixed")) {
				return;
			}
			
			$(".roomType").addClass("fixed").parent().css("padding-top",height + "px");
		} else {
			$(".roomType").removeClass("fixed").parent().css("padding-top","0");
		}
	});

	// 入住优惠
	$(".preferential a").on("mouseover",function() {
		$(this).parent().find("div").fadeIn();
	});

	$(".preferential a").on("mouseout",function() {
		var that = $(this);
		timer = setTimeout(function(){
			that.parent().find("div").fadeOut();
		},500);
	});

	$(".preferential div").on("mouseover",function() {
		clearTimeout(timer);
	});

	$(".preferential div").on("mouseout",function() {
		$(this).fadeOut();
	});

	// 图片及介绍
	$(".infoBtn").on("click",function() {
		$(this).parents("li").find(".roomInfo").slideToggle();

		var i = $(this).find("i");
		
		if (i.hasClass("icon-chevron-down")) {
			i.removeClass("icon-chevron-down").addClass("icon-chevron-up");
		} else {
			i.removeClass("icon-chevron-up").addClass("icon-chevron-down");
		}

		return false;
	});
	
	
	// inputNum
	$(".inputNum span:last-child").on("click",function() {
		if ($(this).hasClass("disabled")) {
			return;
		}
		
		var curr_op = $(this).parent().attr('op');
		var tbody_obj = $(this).parent().parent().parent().parent();
		var curr_room_num = parseInt(tbody_obj.attr('room_num'));
		var curr_bed_num = parseInt(tbody_obj.attr('bed_num'));
		var curr_min_adult = parseInt(tbody_obj.attr('min_adult'));
		//alert(curr_bed_num);
		//无剩余房间，不可增加床位
		if(curr_room_num==0){return false;}
		
		//床位数增加，若超过该房间居住人数则自动增加房间数
		//房间数
		var adult_num = parseInt(tbody_obj.find("span[op='adult'] input[type='text']").val());
		var children_num = parseInt(tbody_obj.find("span[op='children'] input[type='text']").val());
		var sum_num_val = parseInt(tbody_obj.find("span[op='sum'] input[type='text']").val());
		if(curr_op == 'adult' || curr_op == 'children'){
			var sum_num_tmp = parseInt(adult_num) + parseInt(children_num) + 1;
		}else{
			var sum_num_tmp = parseInt(adult_num) + parseInt(children_num) ;
		}
		var sum_num = Math.ceil(sum_num_tmp/curr_bed_num);
		//alert(sum_num);
		if(sum_num>sum_num_val && sum_num<=curr_room_num){
			tbody_obj.find("span[op='sum'] input[type='text']").val(sum_num);
			sum_num_val = sum_num;
		}
		
		
		//成人
		if(curr_op == 'adult'){
			adult_num = adult_num + 1;
			var ex = /^\d+$/;
			var v = adult_num/curr_min_adult;
			
//			if(!ex.test(v)){
//				//提示至少入住人数
//				tbody_obj.find("span[op='sum'] input[type='text']").val(sum_num-1);
//				tbody_obj.find("span[op='adult'] input[type='text']").val(adult_num);
//				tbody_obj.find("span[op='adult'] span:first-child").removeClass("disabled");
//				return false;
//			}
			
			if(sum_num_val == curr_room_num){
				if(sum_num_tmp >= (curr_bed_num*curr_room_num)){
					if(adult_num ==  (curr_bed_num*curr_room_num) ){
						tbody_obj.find("span[op='children'] input[type='text']").val(0);
						tbody_obj.find("span[op='adult'] span:last-child").addClass("disabled");
						tbody_obj.find("span[op='children'] span:first-child").addClass("disabled");
					}else{
						tbody_obj.find("span[op='children'] input[type='text']").val(children_num-1);
						tbody_obj.find("span[op='children'] span:last-child").removeClass("disabled");
					}
				}
			}
			
			//开启儿童增加按钮
			if(adult_num<curr_min_adult){
				tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
			}else if((adult_num%curr_min_adult==0) && (curr_min_adult<curr_bed_num)){
				tbody_obj.find("span[op='children'] span:last-child").removeClass("disabled");
			}
			
			//开启房间数增加按钮
			//alert(Math.ceil(adult_num/curr_min_adult));//alert(sum_num);
			if(Math.ceil(adult_num/curr_min_adult) > sum_num_val && sum_num_val < curr_room_num){
				tbody_obj.find("span[op='sum'] span:last-child").removeClass("disabled");
			}else{
				tbody_obj.find("span[op='sum'] span:last-child").addClass("disabled");
			}
			
			tbody_obj.find("span[op='adult'] span:first-child").removeClass("disabled");

		}
		
		
		
		//儿童
		if(curr_op == 'children'){
			children_num = children_num + 1;
			
			if(sum_num_val == curr_room_num){
				if(sum_num_tmp >= (curr_bed_num*curr_room_num)){
					if(Math.floor((adult_num-1)/curr_min_adult) >= curr_room_num){
						tbody_obj.find("span[op='adult'] input[type='text']").val(adult_num-1);
						if(((curr_bed_num-curr_min_adult) * Math.ceil(adult_num-1/curr_min_adult)) == children_num){
							tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
						}
					}else{
						tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
					}
				}
				tbody_obj.find("span[op='adult'] span:last-child").removeClass("disabled");
			}else{
			
				if(children_num >= (curr_bed_num-curr_min_adult)*Math.floor((adult_num/curr_min_adult))){
					tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
				}else{
					tbody_obj.find("span[op='children'] span:last-child").removeClass("disabled");
				}
			}
			
			if((curr_bed_num-curr_min_adult)*sum_num_val == children_num){
				tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
			}
			
			//开启房间数增加按钮
			//if((Math.ceil(adult_num/curr_min_adult) > sum_num) && (adult_num>sum_num_val)){
			//alert(Math.ceil(adult_num/curr_min_adult));
			if(Math.ceil(adult_num/curr_min_adult) > sum_num_val && sum_num_val < curr_room_num){
				tbody_obj.find("span[op='sum'] span:last-child").removeClass("disabled");
			}else{
				tbody_obj.find("span[op='sum'] span:last-child").addClass("disabled");
			}
			//开启房间数减少按钮
			if(sum_num < sum_num_val){
				tbody_obj.find("span[op='sum'] span:first-child").removeClass("disabled");
			}else{
				tbody_obj.find("span[op='sum'] span:first-child").addClass("disabled");
			}
			
		}
		
		//房间数
		if(curr_op == 'sum'){
			sum_num_val = sum_num_val + 1;
			if(sum_num_val >= (adult_num/curr_min_adult)){
				tbody_obj.find("span[op='sum'] span:last-child").addClass("disabled");
			}else if(sum_num_val < curr_room_num){
				tbody_obj.find("span[op='sum'] span:last-child").removeClass("disabled");
			}
			
			//开启房间数减少按钮
			if(sum_num <= sum_num_val){
				tbody_obj.find("span[op='sum'] span:first-child").removeClass("disabled");
			}
			
		}
		
		var numNode = $(this).prev();
		var num = Number(numNode.val());

		numNode.val(num + 1);

		if (num === 0) {
			numNode.prev().removeClass("disabled");
		}
		
		var par_obj = $(this).parents('.tr_table_cabin');
		var bed_price = par_obj.attr('bed_price');
		var bed_2_price = par_obj.attr('bed_2_price');
		var bed_child = par_obj.attr('bed_child')/100;
		var bed_2_child = par_obj.attr('bed_2_child')/100;
		var bed_empty = par_obj.attr('bed_empty')/100;
		var bed_2_empty = par_obj.attr('bed_2_empty')/100;
		
		//计算总价格及人均价格并显示对应字段
		var $bed_sum_price =  cabin_count_price(curr_bed_num,sum_num_val,bed_price,bed_2_price,bed_empty,bed_2_empty,bed_child,bed_2_child,adult_num,children_num);
		
		var age_person_price = Math.ceil($bed_sum_price/(adult_num+children_num));
		
		if(adult_num%curr_min_adult!=0){
			par_obj.find('.error_tips').removeClass('hidden');
			par_obj.find('.cabin_price_show').addClass('hidden');
		}else{
			par_obj.find('.cabin_price_show p:first-child>em').html('￥'+$bed_sum_price);
			par_obj.find('.cabin_price_show p:last-child').html('人均：￥'+age_person_price);
			par_obj.find('.cabin_price_show').removeClass('hidden');
			par_obj.find('.error_tips').addClass('hidden');
		}
		
		par_obj.find('.delete').removeClass('hidden');
		par_obj.find('.tips').addClass('hidden');
		
		cabins_all_count();
		
	});

	$(".inputNum span:first-child").on("click",function() {
		if ($(this).hasClass("disabled")) {
			return;
		}
		
		var curr_op = $(this).parent().attr('op');
		var tbody_obj = $(this).parent().parent().parent().parent();
		var curr_room_num = parseInt(tbody_obj.attr('room_num'));
		var curr_bed_num = parseInt(tbody_obj.attr('bed_num'));
		var curr_min_adult = parseInt(tbody_obj.attr('min_adult'));
		
		
		var adult_num = parseInt(tbody_obj.find("span[op='adult'] input[type='text']").val());
		var children_num = parseInt(tbody_obj.find("span[op='children'] input[type='text']").val());
		var sum_num_val = parseInt(tbody_obj.find("span[op='sum'] input[type='text']").val());
		if(curr_op == 'adult' || curr_op == 'children'){
			var sum_num_tmp = parseInt(adult_num) + parseInt(children_num) - 1;
		}else{
			var sum_num_tmp = parseInt(adult_num) + parseInt(children_num) ;
		}
		var sum_num = Math.ceil(sum_num_tmp/curr_bed_num);
		
		
		//成人数减少，儿童数随之减少，房间数随之减少
		if(curr_op == 'adult'){
			adult_num = adult_num - 1;
			if(Math.ceil(adult_num/curr_min_adult) < sum_num_val){
				tbody_obj.find("span[op='sum'] input[type='text']").val(adult_num/curr_min_adult);
				tbody_obj.find("span[op='sum'] span:last-child").addClass("disabled");
				
				var children_num_val = ((adult_num/curr_min_adult)*curr_bed_num)-adult_num;
				if(children_num>children_num_val){
					tbody_obj.find("span[op='children'] input[type='text']").val(children_num_val);
					tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
					
					if(Math.ceil((adult_num+children_num_val)/curr_bed_num) >= (adult_num/curr_min_adult)){
						tbody_obj.find("span[op='sum'] span:first-child").addClass("disabled");
						if(adult_num == 0){
							tbody_obj.find("span[op='children'] span:first-child").addClass("disabled");
							tbody_obj.find("span[op='children'] span:last-child").addClass("disabled");
						}
					}
				}
				
			}else{
				//提示每间舱房最少入住成人数为x
			}
			tbody_obj.find("span[op='adult'] span:last-child").removeClass("disabled");
		}
		
		
		//儿童数减少，房间数可开启减少按钮
		if(curr_op == 'children'){
			if(sum_num < sum_num_val){
				tbody_obj.find("span[op='sum'] span:first-child").removeClass("disabled");
			}else{
				tbody_obj.find("span[op='sum'] span:first-child").addClass("disabled");
			}
			
			tbody_obj.find("span[op='children'] span:last-child").removeClass("disabled");
			tbody_obj.find("span[op='adult'] span:last-child").removeClass("disabled");
		}
		
		
		//房间数减少
		if(curr_op == 'sum'){
			sum_num_val = sum_num_val - 1;
			if(sum_num < sum_num_val && sum_num_val <= curr_room_num){
				tbody_obj.find("span[op='sum'] span:first-child").removeClass("disabled");
			}else{
				tbody_obj.find("span[op='sum'] span:first-child").addClass("disabled");
			}
			if(adult_num>sum_num_val && sum_num_val <= curr_room_num){
				tbody_obj.find("span[op='sum'] span:last-child").removeClass("disabled");
			}
		}
		
		var numNode = $(this).next();
		var num = Number(numNode.val());

		numNode.val(num - 1);

		if (num === 1) {
			$(this).addClass("disabled");
		}
		
		var par_obj = $(this).parents('.tr_table_cabin');
		var bed_price = par_obj.attr('bed_price');
		var bed_2_price = par_obj.attr('bed_2_price');
		var bed_child = par_obj.attr('bed_child')/100;
		var bed_2_child = par_obj.attr('bed_2_child')/100;
		var bed_empty = par_obj.attr('bed_empty')/100;
		var bed_2_empty = par_obj.attr('bed_2_empty')/100;
		
		
		var $bed_sum_price =  cabin_count_price(curr_bed_num,sum_num_val,bed_price,bed_2_price,bed_empty,bed_2_empty,bed_child,bed_2_child,adult_num,children_num);
		
		var age_person_price = Math.ceil($bed_sum_price/(adult_num+children_num));
		
		if(adult_num == 0 || sum_num_val == 0){
			par_obj.find('.cabin_price_show').addClass('hidden');
			par_obj.find('.delete').addClass('hidden');
			par_obj.find('.error_tips').addClass('hidden');
			par_obj.find('.tips').removeClass('hidden');
		}else if(adult_num%curr_min_adult!=0){
			par_obj.find('.error_tips').removeClass('hidden');
			par_obj.find('.cabin_price_show').addClass('hidden');
		}else{
			par_obj.find('.cabin_price_show p:first-child>em').html('￥'+$bed_sum_price);
			par_obj.find('.cabin_price_show p:last-child').html('人均：￥'+age_person_price);
			par_obj.find('.cabin_price_show').removeClass('hidden');
			par_obj.find('.error_tips').addClass('hidden');
		}
		
		cabins_all_count();
		
	});
	
	//清除选择
	$(document).on('click','.tr_table_cabin .delete',function(){
		var obj = $(this).parents(".tr_table_cabin");
		obj.find('.cabin_price_show').addClass('hidden');
		obj.find('.error_tips').addClass('hidden');
		obj.find('.delete').addClass('hidden');
		obj.find('.tips').removeClass('hidden');
		obj.find("span[op='adult'] span:first-child").addClass('disabled');
		obj.find("span[op='adult'] span:last-child").removeClass('disabled');
		obj.find("span[op='children'] span:first-child").addClass('disabled');
		obj.find("span[op='children'] span:last-child").addClass('disabled');
		obj.find("span[op='sum'] span:first-child").addClass('disabled');
		obj.find("span[op='sum'] span:last-child").addClass('disabled');
		obj.find("span[op='adult'] input[type='text']").val(0);
		obj.find("span[op='children'] input[type='text']").val(0);
		obj.find("span[op='sum'] input[type='text']").val(0);
		
		cabins_all_count();
	});
	
	
	// 点击下一步
	$(".roomType .nextBtn").on("click",function() {
		if ($(this).hasClass("disabled")) {
			return;
		}

		$(".shadow").show();
		$(".loginBox").show();
	});

	// 点击关闭登录弹窗
	$(".loginBox .close").on("click",function() {
		$(".shadow").hide();
		$(".loginBox").hide();
	});
});



//船舱价格计算
function cabin_count_price(curr_bed_num,sum_num_val,bed_price,bed_2_price,bed_empty,bed_2_empty,bed_child,bed_2_child,adult_num,children_num){

	var $z = sum_num_val*curr_bed_num;		//一共床位
	if(curr_bed_num>=2){
		//一间船舱有两个以上的床位
		var $x = sum_num_val*2;		//1/2床位总数
		var $y = sum_num_val * (curr_bed_num-2);	//3/4床位总数
	}else{
		//一间船舱只有一个床位
		var $x = sum_num_val*1;
		var $y = 0;
	}
	
	
	//求成人数总价格
	if($x >= adult_num){
		//成人数小于等于一共船舱1/2床位总数
		var $one_two_bed = bed_price * adult_num;
		var $over_bed_x = $x - adult_num; //船舱剩余1/2床位总数
		var $over_x = 0; // 剩余成人数
		
	}else{
		//成人数大于一共船舱1/2床位总数
		var $one_two_bed = bed_price * $x;
		var $over_x = adult_num - $x;	// 剩余成人数
		var $over_bed_x = 0;
	}
	
	
	//求儿童优惠总价格
	if(children_num == 0){
		if($over_x == 0){
			//计算空床位价格
			var $one_two_other = $over_bed_x * bed_price * bed_empty;
			var $one_two_bed = parseFloat($one_two_bed) + parseFloat($one_two_other);
			var $three_four_bed = $y * bed_2_price * bed_2_empty;
			var $bed_sum_price = $one_two_bed + $three_four_bed;
			
		}else{
			//剩余成人数按3/4床位计算
			var $adult_other_price = $over_x * bed_2_price;
			var $three_four_bed = ($y-$over_x) * bed_2_price * bed_2_empty;
			var $bed_sum_price = $one_two_bed + $adult_other_price + $three_four_bed;
		}
	}else{
		if($over_x == 0){
			//1/2床位未满人
			if($over_bed_x >= children_num){
				//1/2床位能装下全部儿童
				var $other_one_two = children_num * bed_price * bed_child;
				var $other_one_two_over = ($over_bed_x-children_num) * bed_price * bed_empty;
				var $three_four_price = $y * bed_2_price * bed_2_empty;
				var $bed_sum_price = $one_two_bed + $other_one_two + $other_one_two_over + $three_four_price;
				
			}else{
				//1/2床位不能装下全部儿童
				var $other_one_two = $over_bed_x * bed_price * bed_child;
				var $three_four_price = (children_num-$over_bed_x) * bed_2_price * bed_2_child;
				var $three_four_other = ($y-(children_num-$over_bed_x)) * bed_2_price * bed_2_empty;
				var $bed_sum_price = $one_two_bed + $other_one_two + $three_four_price + $three_four_other;
			}
		}else{
			//1/2床位已经满人
			var $adult_other_price = $over_x * bed_2_price ;
			var $three_four_bed = children_num * bed_2_price * bed_2_child;
			var $other_three_four = ($y-$over_x-children_num) * bed_2_price * bed_2_empty;
			var $bed_sum_price = $one_two_bed + $adult_other_price + $three_four_bed + $other_three_four;
			
		}
	}
	
	return $bed_sum_price;
}

//船舱总数据显示
function cabins_all_count(){

	//判断是否有选择成人或儿童，是否每个船舱后有价格总数显示，若存在有选择，顶部总船舱显示相应数据
	var cabins_all_price = 0;
	var cabins_adult_count = 0;
	var cabins_children_count = 0;
	var cabins_room_count = 0;
	var cabins_age_price = 0;
	
	$(".roomList .cabin_price_show").each(function(){
		var display = $(this).css('display');
		var obj = $(this).parents('.tr_table_cabin');
		if(display == 'block'){
			var single_cabin = $(this).find("p:first-child em").html();
			single_cabin = parseFloat(single_cabin.replace("￥", ""));
			cabins_all_price += single_cabin;
			
			var this_adult = obj.find("span[op='adult'] input[type='text']").val();
			cabins_adult_count += parseInt(this_adult);
			var this_children = obj.find("span[op='children'] input[type='text']").val();
			cabins_children_count += parseInt(this_children);
			var this_sum = obj.find("span[op='sum'] input[type='text']").val();
			cabins_room_count += parseInt(this_sum);
			
		}
		
	});
	
	cabins_age_price = Math.ceil(cabins_all_price/(cabins_adult_count+cabins_children_count));
	
	if(cabins_room_count == 0){
		//无选择房间
		$(".roomType .title_error").removeClass('hidden');
		$(".roomType .title_sum_price").addClass('hidden');
		$(".roomType .title_sum_number").addClass('hidden');
		$(".roomType .nextBtn").addClass('disabled');
	}else{
		$(".roomType .title_error").addClass('hidden');
		$(".roomType .title_sum_price span:first-child > em").html("￥"+cabins_all_price);
		$(".roomType .title_sum_price span:last-child").html("人均：￥"+cabins_age_price);
		$(".roomType .title_sum_price").removeClass('hidden');
		var text = '入住：成人'+cabins_adult_count+'人';
		if(cabins_children_count){
			text += '，儿童'+cabins_children_count+'人';
		}
		$(".roomType .title_sum_number span:first-child").html(text);
		$(".roomType .title_sum_number span:last-child").html("房间："+cabins_room_count+"间");
		$(".roomType .title_sum_number").removeClass('hidden');
		$(".roomType .nextBtn").removeClass('disabled');
	}
	
}


function nextCheck(){
	
	return false;
}



//下一步封装json数据
function savejson(){
	var data_arr = '[';
	$(".roomList .cabin_price_show").each(function(){
		var display = $(this).css('display');
		var obj = $(this).parents('.tr_table_cabin');
		if(display == 'block'){
			var type_code = obj.attr('type_code');
			data_arr += '{"type_code":"'+type_code+'",';
			
			var this_adult = obj.find("span[op='adult'] input[type='text']").val();
			data_arr += '"adult":"'+this_adult+'",';
			
			var this_children = obj.find("span[op='children'] input[type='text']").val();
			data_arr += '"children":"'+this_children+'",';
			
			var this_sum = obj.find("span[op='sum'] input[type='text']").val();
			data_arr += '"room":"'+this_sum+'",';
			
			var single_cabin = $(this).find("p:first-child em").html();
			single_cabin = parseFloat(single_cabin.replace("￥", ""));
			data_arr += '"price":"'+single_cabin+'"},';
			
		}
		
	});
	data_arr = data_arr.substring(0,data_arr.length-1);
	data_arr += ']';
	
	$.ajax({
	    url:save_session_cabins,
	    type:'post',
	    async:false,
	    data:'data_arr='+data_arr,
	 	dataType:'json',
		
	});
	
	
	//设置session
	//$.session.set("room", data_arr);
	//var data = $.session.get(p_no); // 获取
	//删除
    //$.session.remove(key);
    //清除数据
    //$.session.clear();
	
	//var data = $.session.get('room');
	//alert(data);
	
	return true;
	
}