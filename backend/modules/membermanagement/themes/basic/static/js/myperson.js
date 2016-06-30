
 $(document).ready(function() {

 	$(function() {
    $( ".datepicker" ).datepicker();
  });
 	


















						 $(" select#vip_grade option").each(function()
			     {

			        if ($.trim($(this).val())==$.trim($('#vipgrade').text())) {
			           $(this).prop('selected', 'selected');

			        }
			    });


				 $(" select#country_code option").each(function()
			     {

			        if ($.trim($(this).val())==$.trim($('#country').text())) {
			           $(this).prop('selected', 'selected');

			        }
			    });


			

				  $(" select#gender option").each(function()
			     {

			        if ($.trim($(this).val())==$.trim($('#gender_sex').text())) {
			           $(this).prop('selected', 'selected');

			        }
			    });

				  	  $(" select#post_country_code option").each(function()
			     {

			        if ($.trim($(this).val())==$.trim($('#passport_country').text())) {
			           $(this).prop('selected', 'selected');

			        }
			    });



		

		





  jQuery.validator.addMethod("fixnumber", function(value, element) {
	return this.optional(element) || /^([0-9]{3,4}-)?[0-9]{7,8}$/.test(value);
}, "A positive or negative non-decimal number please");

  //手机号码
  jQuery.validator.addMethod("mobile", function(value, element) {
 
		return this.optional(element) || /^((\+?86)|(\(\+86\)))?(13[012356789][0-9]{8}|15[012356789][0-9]{8}|18[02356789][0-9]{8}|147[0-9]{8}|1349[0-9]{7})$/.test(value);
	}, "A positive or negative non-decimal number please");


  jQuery.validator.addMethod("emailsame", function(value, element) {
         $.ajax({
            type: "post",
            url: "<?= Url::to(['default/member_email_validate']);?>",     
            data: {'email':$.trim($('#email').val())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    return false;
                  }
                  else {
                  	return true;
                  	
                  }          	 
             
            },
            error: function(data) {
                alert('请求错误');
             return false;
            }
        });
  
 }, " email  have been exist");



    jQuery.validator.addMethod("mobliesame", function(value, element) {
         
         $.ajax({
            type: "post",
            url: "<?= Url::to(['default/member_moblie_validate']);?>",     
            data: {'mobile_number':$.trim($('#mobile_number').val())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    return false;
                  }
                  else {
                  	return true;
                  	
                  }
               	 
             
            },
            error: function(data) {
                alert('请求错误');
             return false;


            }
        });
  
 }, " moblie number have been exist");





  

		$("#member_add_form").validate({
		   rules: {

		   	vip_grade: { required : true},
		    country_code: { required : true},
		   	m_name: { required : true,shuzi:true},
            balance:{required:true,digits:true},
		   	first_name: { required : true},
		   	fixed_telephone: { required : true,fixnumber:true},
		   	points: { required : true,digits:true},
		   	last_name: { required : true},
		   	mobile_number: { required : true,mobile:true,mobliesame:true},
		   	birthday: { required : true},			
            email:{required:true,email:true,emailsame:true},
	        gender: { required : true},
		    birth_place: { required : true},
			create_time: { required : true},
			passport_number: { required : true,shuzi:true},
			m_password: { required : true,rangelength:[6,30]},
			date_expire: { required : true,date:true},
			date_issue: { required : true},
			place_issue: { required : true},
			post_country_code: { required : true},
			
		  },
		messages: {
            vip_grade: { required : '请选择Membership Grade'},
		    country_code: { required : '请选择Country'},
		   	m_name: { required : 'Chinese Name不能为空'},
		   	balance:{required:'Balance不能为空',digits:'balance只能填入整数'},
		   	first_name: { required : 'first_name不能为空'},
		   	fixed_telephone: { required : 'Landline Telephone不能为空',
			   	fixnumber:'Landline Telephone格式不对'


			   	},
		   	points: { required : 'Integral不能为空',digits:'Integral只能是整数'},
		   	last_name: { required : 'last_name不能为空'},
		   	mobile_number: { required : 'mobile_number不能为空',mobile:'mobile_number格式不对'},
		   	birthday: { required : 'birthday不能为空'},			
            email:{required:'email不能为空',email:"E-mail 地址格式不对" },
	         gender: { required : '请选择性别'},
		    birth_place: { required : 'birth_place不能为空'},
			create_time: { required : 'create_time不能为空'},
			passport_number: { required : 'passport_number不能为空'},
			m_password: { required : 'password不能为空',rangelength:'密码长度6-30位'},
			date_expire: { required : 'date_expire不能为空'},
			date_issue: { required : 'date_issue不能为空'},
			place_issue: { required : 'place_issue不能为空'},
			post_country_code: { required : '请选择post_country_code'},
		
		
			
		},
		showErrors : function(errorMap, errorList) {  

          var sum=0;
		   
		   $.each(errorList, function(i, v) {  
		   
		   	if(sum!=0) return false;
		   		sum++;
		    var msg='';
		     msg  = (v.message + "\r\n"); 

		     alert(msg);  
		  
		    }); 
		
		    
          },


           submitHandler:function(form){
            $.ajax({
            type: "post",
            url: "<?= Url::to(['default/member_email_validate']);?>",     
            data: {'email':$.trim($('#email').val()),'mobile_number':$.trim($('#mobile_number').val())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	 var jsonObj=JSON.parse(data);
                  email_code
            	 if(jsonObj.email_code=='0')
            	 {
            	 	alert('该邮箱已被注册');

            	 }

            	 if(jsonObj.mobile_code=='0')
            	 {
            	 	alert('Phone已被注册');

            	 }

            	 if((jsonObj.email_code=='1')&&(jsonObj.mobile_code=='1'))
            	 {
            	 	$('#member_add_form').submit();

            	 }

             
            },
            error: function(data) {
//                 alert(data);

            }
        });
        } ,



        
            onfocusout:false,
             onkeyup:false,
              focusCleanup:true,
              onclick:false,


	 });

			
	 });








