$(function() {
	$(".selectBox a").on("click",function() {
		$(this).parent().siblings(".selectList").slideToggle();
		
		var i = $(this).find("i");
		
		if (i.hasClass("icon-chevron-down")) {
			i.removeClass("icon-chevron-down").addClass("icon-chevron-up");
		} else {
			i.removeClass("icon-chevron-up").addClass("icon-chevron-down");
		}

		return false;
	});

	$(".writeNow").on("click",function() {
		$(this).parents(".content").find(".more").slideDown();
	});

	$(".writeLater").on("click",function() {
		$(this).parents(".content").find(".more").slideUp();
	});
	
	//input文本框获取焦点时取消后方提示信息显示
	$("form#person_info_form input[type='text']").focus(function(){
		
		$(this).parent().parent().find("span.wrong").remove();
	});
	
	
	//填写护照号后判断护照号是否唯一
	$("input[type='text'][class='passport_check']").bind("blur",function(){
		var success = 1;
		var obj = $(this);
		var curr_val = $(this).val();
		var curr_index = parseInt($("input[type='text'][class='passport_check']").index(this));
		var error_text = '<span class="wrong passport_error" >已存在填写护照号，护照号需唯一</span>';
		var error_text_pass = '<span class="wrong passport_error" >该乘客已经购买了当前航线,请更换乘客</span>';
		$("input[type='text'][class='passport_check']").each(function(){
			var this_index = parseInt($("input[type='text'][class='passport_check']").index(this));
			var val = $(this).val();
			if(curr_val==val && curr_index != this_index){
				obj.parents('p').find('span.wrong').remove();
				obj.parents('p').append(error_text);
				success = 0;return false;
			}
			
		});
		if(success == 0){return false;}else{
			
			//验证该乘客是否存在重复购票
			$.ajax({
			    url:check_passport_info,
			    type:'post',
			    async:false,
			    data:'voyage_code='+voyage_code+'&passport='+curr_val,
			 	dataType:'json',
			 	success:function(data){
				 	if(parseInt(data)==0){
				 		obj.parents('p').find('span.wrong').remove();
						obj.parents('p').append(error_text_pass);
						success = 0;return false;
				 	}
				}
				
			});
		}
		
		if(success == 0){return false;}
		
		
	}); 
	
	
	
	
});



//验证信息
function checkpersoninfo(){
	
	var success = 0; // 0:失败 1：成功
	var error_text = '<span class="wrong">必填字段</span>';
	var error_email_text = '<span class="wrong">填写正确的电子邮箱</span>';
	var error_phone_text = '<span class="wrong">填写正确的手机号码</span>';
	var contact_name = $("form#person_info_form input[name='contact_name']").val();
	var contact_email = $("form#person_info_form input[name='contact_email']").val();
	var contact_phone = $("form#person_info_form input[name='contact_phone']").val();
	
	if(contact_name==''){
		$("form#person_info_form input[name='contact_name']").after(error_text); return 1;
	}
	if(contact_email == ''){
		$("form#person_info_form input[name='contact_email']").after(error_text); return 1;
	}
	var Regex = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;  
　　	if (!Regex.test(contact_email)){
		$("form#person_info_form input[name='contact_email']").after(error_email_text); return 1;
	}     

	if(contact_phone == ''){
		$("form#person_info_form input[name='contact_phone']").after(error_text); return 1;
	}
	if(!(/^1[3|4|5|7|8]\d{9}$/.test(contact_phone))){
		$("form#person_info_form input[name='contact_phone']").after(error_phone_text); return 1;
	}
	
	//成人验证
	$("form#person_info_form .adult_person_div").each(function(){
		var full_name = $(this).find("input[name='full_name[]']").val();
		if(full_name==''){
			$(this).find("input[name='full_name[]']").parents('p').append(error_text); success =1; return false;
		}
		var last_name = $(this).find("input[name='last_name[]']").val();
		var first_name = $(this).find("input[name='first_name[]']").val();
		if(last_name == '' || first_name == ''){
			$(this).find("input[name='last_name[]']").parent().parent().append(error_text); success =1; return false;
		}
		var birth = $(this).find("input[name='birth[]']").val();
		if(birth == ''){
			$(this).find("input[name='birth[]']").parent().parent().append(error_text); success =1; return false;
		}
		var phone = $(this).find("input[name='phone[]']").val();
		if(phone == ''){
			$(this).find("input[name='phone[]']").parent().parent().append(error_text); success =1; return false;
		}
		if(!(/^1[3|4|5|7|8]\d{9}$/.test(phone))){
			$(this).find("input[name='phone[]']").parent().parent().append(error_phone_text); success =1; return false;
		}
		var nationality = $(this).find("input[name='nationality[]']").val();
		if(nationality == ''){
			$(this).find("input[name='nationality[]']").parent().parent().append(error_text); success =1; return false;
		}
		
//		var is_choose = $(this).find(".adult_choose_type input[type='radio']:checked").val();
//		if(is_choose == 1){
			//现在填写信息
		var paper_num =$(this).find("input[name='paper_num[]']").val();
		if(paper_num == ''){
			$(this).find("input[name='paper_num[]']").parent().parent().append(error_text); success =1; return false;
		}
		var paper_date =$(this).find("input[name='paper_date[]']").val();
		if(paper_date == ''){
			$(this).find("input[name='paper_date[]']").parent().parent().append(error_text); success =1; return false;
		}
		var birth_place =$(this).find("input[name='birth_place[]']").val();
		if(birth_place == ''){
			$(this).find("input[name='birth_place[]']").parent().append(error_text); success =1; return false;
		}
		var issue_place =$(this).find("input[name='issue_place[]']").val();
		if(issue_place == ''){
			$(this).find("input[name='issue_place[]']").parent().append(error_text); success =1; return false;
		}
			
			
//		}
	});
	if(success == 1){return success}
	
	//儿童验证
	$("form#person_info_form .children_person_div").each(function(){
		var c_full_name = $(this).find("input[name='c_full_name[]']").val();
		if(c_full_name==''){
			$(this).find("input[name='c_full_name[]']").parent().parent().append(error_text); success =1; return false;
		}
		var c_last_name = $(this).find("input[name='c_last_name[]']").val();
		var c_first_name = $(this).find("input[name='c_first_name[]']").val();
		if(c_last_name == '' || c_first_name == ''){
			$(this).find("input[name='c_last_name[]']").parent().parent().append(error_text); success =1; return false;
		}
		var c_birth = $(this).find("input[name='c_birth[]']").val();
		if(c_birth == ''){
			$(this).find("input[name='c_birth[]']").parent().parent().append(error_text); success =1; return false;
		}
		var c_phone = $(this).find("input[name='c_phone[]']").val();
		if(c_phone == ''){
			$(this).find("input[name='c_phone[]']").parent().parent().append(error_text); success =1; return false;
		}
		if(!(/^1[3|4|5|7|8]\d{9}$/.test(c_phone))){
			$(this).find("input[name='c_phone[]']").parent().parent().append(error_phone_text); success =1; return false;
		}
		var c_nationality = $(this).find("input[name='c_nationality[]']").val();
		if(c_nationality == ''){
			$(this).find("input[name='c_nationality[]']").parent().parent().append(error_text); success =1; return false;
		}
//		
//		var is_choose = $(this).find(".children_choose_type input[type='radio']:checked").val();
//		if(is_choose == 1){
			//现在填写信息
		var c_paper_num =$(this).find("input[name='c_paper_num[]']").val();
		if(c_paper_num == ''){
			$(this).find("input[name='c_paper_num[]']").parent().after(error_text); success =1; return false;
		}
		var c_paper_date =$(this).find("input[name='c_paper_date[]']").val();
		if(c_paper_date == ''){
			$(this).find("input[name='c_paper_date[]']").parent().after(error_text); success =1; return false;
		}
		var c_birth_place =$(this).find("input[name='c_birth_place[]']").val();
		if(c_birth_place == ''){
			$(this).find("input[name='c_birth_place[]']").after(error_text); success =1; return false;
		}
		var c_issue_place =$(this).find("input[name='c_issue_place[]']").val();
		if(c_issue_place == ''){
			$(this).find("input[name='c_issue_place[]']").after(error_text); success =1; return false;
		}
			
			
//		}
	});
	
	
	//护照号验证
	var length = $("span.passport_error").length;
	if(length > 0){success =1;return false;}
	
	return success;
	
}

//下一步 0:成功可下一步 ，1：失败停止下一步操作
function savepersoninfo(){
	var success = checkpersoninfo();
	var json_data = '';
	if(success == 0){
		json_data = savecabinspersoninfojson();
		
		//保存session
		$.ajax({
		    url:save_session_cabins_noperson_info,
		    type:'post',
		    async:false,
		    data:'data_arr='+json_data,
		 	dataType:'json',
			
		});
		
		//清除附加费session
		$.ajax({
		    url:clear_session_cabins_noperson_info,
		    type:'post',
		    async:false,
		 	dataType:'json',
			
		});
		
		return true;
	}else{
		return false;
	}
	
	
}


//下一步保存json // person:1 成人 person:2 儿童
function savecabinspersoninfojson(){
	var $num = 0;  //初始化人，每人分配一个唯一key
	var json_data = '[';
	var contact_json = '';
	var cabins_json = '';
	var contact_name = $("form#person_info_form input[name='contact_name']").val();
	var contact_email = $("form#person_info_form input[name='contact_email']").val();
	var contact_phone = $("form#person_info_form input[name='contact_phone']").val();
	contact_json += '{"contact":{"name":"'+contact_name+'","email":"'+contact_email+'","phone":"'+contact_phone+'"}},';
	
	cabins_json += '{"cabins":{';
	//循环每个船舱
	$("form#person_info_form .cabins_class").each(function(){
		var type_code = $(this).attr('type_code');
		cabins_json += '"'+type_code+'":[';
		//循环成人
		$(this).find(".adult_person_div").each(function(){
			console.log($(this).find(".checkbox input"));
			var keep_contact = $(this).find("input[name='keep_contact[]']").prop("checked");
			if(keep_contact){keep_contact=1;}else{keep_contact=0;}
			var full_name = $(this).find("input[name='full_name[]']").val();
			var last_name = $(this).find("input[name='last_name[]']").val();
			var first_name = $(this).find("input[name='first_name[]']").val();
			var sex = $(this).find("input.sex:checked").val();
			var birth = $(this).find("input[name='birth[]']").val();
			var phone = $(this).find("input[name='phone[]']").val();
			var nationality = $(this).find("input[name='nationality[]']").val();
			$num = $num+1;
			cabins_json += '{"person":"1","key":"'+$num+'","keep_contact":"'+keep_contact+'","full_name":"'+full_name+'","last_name":"'+last_name+'","first_name":"'+first_name+'","sex":"'+sex+'",';
			cabins_json += '"birth":"'+birth+'","phone":"'+phone+'","nationality":"'+nationality+'"';
			var paper_num = $(this).find("input[name='paper_num[]']").val();
			var paper_date = $(this).find("input[name='paper_date[]']").val();
			var birth_place = $(this).find("input[name='birth_place[]']").val();
			var issue_place = $(this).find("input[name='issue_place[]']").val();
			cabins_json += ',"paper_num":"'+paper_num+'","paper_date":"'+paper_date+'","birth_place":"'+birth_place+'","issue_place":"'+issue_place+'"},';

		});
		
		//循环儿童
		$(this).find(".children_person_div").each(function(){
			var c_keep_contact = $(this).find("input[name='c_keep_contact[]']").prop("checked");
			if(c_keep_contact){c_keep_contact=1;}else{c_keep_contact=0;}
			var c_full_name = $(this).find("input[name='c_full_name[]']").val();
			var c_last_name = $(this).find("input[name='c_last_name[]']").val();
			var c_first_name = $(this).find("input[name='c_first_name[]']").val();
			var c_sex = $(this).find("input.c_sex:checked").val();
			var c_birth = $(this).find("input[name='c_birth[]']").val();
			var c_phone = $(this).find("input[name='c_phone[]']").val();
			var c_nationality = $(this).find("input[name='c_nationality[]']").val();
			$num = $num+1;
			cabins_json += '{"person":"2","key":"'+$num+'","keep_contact":"'+c_keep_contact+'","full_name":"'+c_full_name+'","last_name":"'+c_last_name+'","first_name":"'+c_first_name+'","sex":"'+c_sex+'",';
			cabins_json += '"birth":"'+c_birth+'","phone":"'+c_phone+'","nationality":"'+c_nationality+'"';
			var c_paper_num = $(this).find("input[name='c_paper_num[]']").val();
			var c_paper_date = $(this).find("input[name='c_paper_date[]']").val();
			var c_birth_place = $(this).find("input[name='c_birth_place[]']").val();
			var c_issue_place = $(this).find("input[name='c_issue_place[]']").val();
			cabins_json += ',"paper_num":"'+c_paper_num+'","paper_date":"'+c_paper_date+'","birth_place":"'+c_birth_place+'","issue_place":"'+c_issue_place+'"},';

		});
		
		cabins_json = cabins_json.substring(0,cabins_json.length-1);
		cabins_json += '],';
		
		
	});
	cabins_json = cabins_json.substring(0,cabins_json.length-1);
	cabins_json += '}}';
	json_data += contact_json + cabins_json + ']';
	
	return json_data;
	
	
}