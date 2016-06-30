$(document).ready(function() {
	//支付密码设置
	$("#paymentpassword").on("click",function() {
		new PopUps($("#alertpaymentpassword"));
	});
	
		$("label.pay input").focus(function(){//聚焦时清除提示
			$(this).siblings("em").text("");
		});
	
	var p=0;
    $("#pay_passwordsubmit").click(function(){//按提交按钮
    	var t=1;
    	var renewpay_password=$("input[name=renewpay_password]").val();//验证新密码和确认密码
    	var newpay_password=$("input[name=newpay_password]").val();
    	if(renewpay_password!=newpay_password){
            $("#renewpay_passwordlabel").find("em").text("Password must be the same ...");
            t=0;
    	}
    	$("label.pay").each(function(index){//输入框不能为空
    		if($(this).find("input").val()==''){
                $(this).find("em").text("cannot be empty...");
    			t=0;
    		}
    	});
    	if(t==1&&p==1){
    	  var newpay_password = $("input[name=newpay_password]").val(); 
          var url=$("#paysubmiturl").val();
          var locationurl=$("#locationurl").val();
          $.ajax({  
              url: url,
              data:{newpay_password:newpay_password},
              type: 'POST',  
              dataType: 'json',  
            //  timeout: 3000,  
              cache: false,  
              beforeSend: LoadFunction, //加载执行方法      
              error: erryFunction,  //错误执行方法      
              success: succFunction //成功执行方法      
          })  
          function LoadFunction() {  
              $("#list").html('加载中...');  
          }  
          function erryFunction() {  
              Alert("Too frequent operation");  
          }  
          function succFunction(tt) {  
         	  var json = eval(tt); //数组 
                  $.each(json, function (index, item) {
 	                 if(json[index]==0){
 	                	Alert('Option fail');
 	                	$(".cancel_but").click(function(){
 	                		location.href=locationurl;
 	                	});
 		                 }
 	                 else{
 	                	Alert('Option success');
 	                	$(".cancel_but").click(function(){
 	                		location.href=locationurl;
 	                	});
 	                 }
                  });
 			//alert(tt);
                
          }  
    	}
  });
    
	$("input[name=pay_password]").blur(function(){//密码确认
         var pay_password = $(this).val(); 
         var url=$("#url").val();
         $.ajax({  
             url: url,
             data:{pay_password:pay_password},
             type: 'POST',  
             dataType: 'json',  
             //timeout: 3000,  
             cache: false,  
             beforeSend: LoadFunction, //加载执行方法      
             error: erryFunction,  //错误执行方法      
             success: succFunction //成功执行方法      
         })  
         function LoadFunction() {  
             $("#list").html('加载中...');  
         }  
         function erryFunction() {  
             Alert("Too frequent operation");  
         }  
         function succFunction(tt) {  
        	  var json = eval(tt); //数组 
                 $.each(json, function (index, item) {
	                 if(json[index]==0){    
	                	$("#pay_password em").text("Please Input Correct Password...");
	                	p=0;
		                 }
	                 else{
	                	$("#pay_password span").find("em").text("");
	                	p=1;
	                 }
                 });
			//alert(tt);
               
         }  
 });
	//登陆密码设置
	$("#login_passwordclick").on("click",function() {
	
		new PopUps($("#alertloginpassword"));
	});
	
	$("#pay_password em").text("Please select...");
	$("#pay_password span").find("em").text("");

		$("label.login input").focus(function(){//聚焦时清除提示
			
			$(this).siblings("em").text("");
		});
      
    $("#login_passwordsubmit").click(function(){//按提交按钮
    	var t=1;
    	var renewlogin_password=$("input[name=renewlogin_password]").val();//验证新密码和确认密码
    	var newlogin_password=$("input[name=newlogin_password]").val();
    	if(renewlogin_password!=newlogin_password){
        	$("#renewlogin_passwordlabel").find("em").text("Password must be the same ...");
        	t=0;
    	}
    	$("label.login").each(function(index){//输入框不能为空
    		if($(this).find("input").val()==''){
                $(this).find("em").text("cannot be empty...");
    			t=0;
    		}
    		
    	});
    	
    	if(t==1&&p==1){
    	  var newpay_password = $("input[name=newlogin_password]").val(); 
          var url=$("#loginsubmiturl").val();
          var locationurl=$("#locationurl").val();
          $.ajax({  
              url: url,
              data:{newlogin_password:newlogin_password},
              type: 'POST',  
              dataType: 'json',  
            //  timeout: 3000,  
              cache: false,  
              beforeSend: LoadFunction, //加载执行方法      
              error: erryFunction,  //错误执行方法      
              success: succFunction //成功执行方法      
          })  
          function LoadFunction() {  
              $("#list").html('加载中...');  
          }  
          function erryFunction() {  
             Alert("Too frequent operation");  
          }  
          function succFunction(tt) {  
         	  var json = eval(tt); //数组 
                  $.each(json, function (index, item) {
 	                 if(json[index]==0){
 	                	Alert('Option fail');
 	                	$(".cancel_but").click(function(){
 	                		location.href=locationurl;
 	                	});
 		                 }
 	                 else{
 	                	Alert('Option success');
 	                	$(".cancel_but").click(function(){
 	                		location.href=locationurl;
 	                	});
 	                 }
                  });
 			//alert(tt);
                
          }  
    	}
  });
    
	$("input[name=login_password]").blur(function(){//密码确认
		
         var login_password = $(this).val(); 
         var url=$("#loginurl").val();
         $.ajax({  
             url: url,
             data:{login_password:login_password},
             type: 'POST',  
             dataType: 'json',  
            // timeout: 3000,  
             cache: false,  
             beforeSend: LoadFunction, //加载执行方法      
             error: erryFunction,  //错误执行方法      
             success: succFunction //成功执行方法      
         })  
         function LoadFunction() {  
             $("#list").html('加载中...');  
         }  
         function erryFunction() {  
             Alert("Too frequent operation");  
         }  
         function succFunction(tt) {  
        	  var json = eval(tt); //数组 
                 $.each(json, function (index, item) {
	                 if(json[index]==0){
	                	$("#login_password em").text("Please Input Correct Password...");
	                	p=0;	
	                	
		                 }
	                 else{
	                	$("#login_password em").text("");  
	                	p=1;
	                 }
                 });
         }  
	});
 });
