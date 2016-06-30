$(document).ready(function(){
	// 加载header和asideNav内容
	// $("#header").load("header.html");
	// $("#asideNav").load("asideNav.html");

	// 动态改变右边部分宽度
	changeMainRWith();
	$(window).resize(function(){
		changeMainRWith();
	});

	// asideNav点击事件
	$("body").on("click","#asideNav li",function(){
		if ($(this).next().prop("tagName") === "UL") {
			if ($(this).hasClass("open")) {
				$(this).parent().find("ul").css("display","none");
				$(this).parent().find("ul").prev("li").removeClass("open");
			} else {
				$(this).next().css("display","block");
				$(this).addClass("open");
			}
		} else {
			$(".active").removeClass("active");
			$(this).addClass("active");
		}
	});

	// 左边导航关闭
	$("body").on("click","#closeAsideNav",function(){
		$("#asideNav_open").css("display","none");
		$("#asideNav_close").css("display","block");
		$("#asideNav").css("width",$("#asideNav_close").width() + "px");
		changeMainRWith();
	});

	// 左边导航打开
	$("body").on("click","#openAsideNav",function(){
		$("#asideNav_close").css("display","none");
		$("#asideNav_open").css("display","block");
		$("#asideNav").css("width",$("#asideNav_open").width() + "px");
		changeMainRWith();
	});

	// tab功能
	$("body").on("click",".tab_title li",function(){
		var index = $(".tab_title li").index($(this));
		$(".tab .active").removeClass("active");
		$(this).addClass("active");
		$($(".tab_content > div")[index]).addClass("active");
	});
	
	
	
	
	//delete删除弹框
	$(document).on('click',".delete",function(e) {
		var val = $(this).attr('id');
		 $(".ui-widget-overlay").remove();
		 $("#promptBox").remove();
		 var str = "<div class='ui-widget-overlay ui-front'></div>";
		 var str_con = '<div class="shadow"></div>'
			str_con += '<div id="promptBox" class="pop-ups write ui-dialog" >';
			str_con += '<h3>提示</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			str_con += '<p>是否删除？</p>';
			str_con += '<p class="btn">';
			str_con += '<input type="button" class="confirm_but" value="确定"></input>';
			str_con += '<input type="button" class="cancel_but" value="取消"></input>';
			str_con += '</p></div>';
			
		 //$("#promptBox").before(str); 
		 $(document.body).append(str);
		 $(document.body).append(str_con);
		 //$("#promptBox").removeClass('hide');
		 
		 $(".btn > .confirm_but").attr('id',val);
	 }); 
	
	//多选删除弹框

	$("#del_submit").on('click',function(){
		 $(".ui-widget-overlay").remove();
		 $(".shadow").remove();
		 $("#promptBox").remove();
		 
		 var str = "<div class='ui-widget-overlay ui-front'></div>";
		 var str_con = '<div class="shadow"></div>'
		    str_con += '<div id="promptBox" class="pop-ups write ui-dialog" >';
			str_con += '<h3>提示</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			str_con += '<p>这些记录是否删除？</p>';
			str_con += '<p class="btn">';
			str_con += '<input type="button" class="confirm_but_more" value="确定"></input>';
			str_con += '<input type="button" class="cancel_but" value="取消"></input>';
			str_con += '</p></div>';
		var no_str = '<div class="shadow"></div>'
		    no_str += '<div id="promptBox" class="pop-ups write ui-dialog" >';
			no_str += '<h3>没有选中</h3>';
			no_str += '<span class="op"><a class="close r"></a></span>';
			no_str += '<p>请选择删除项</p>';
			no_str += '<p class="btn">';
			no_str += '<input type="button" class="cancel_but" value="取消"></input>';
			no_str += '</p></div>';
			
		var checkbox = $("table  tbody input[type='checkbox']:checked").length;
		 if(checkbox == 0){
			 $(document.body).append(str);
			 $(document.body).append(no_str);
		 }else{
			 $(document.body).append(str);
			 $(document.body).append(str_con);
		 }
		 
		 
	 });
	
	//鼠标拖拽
	 var _move=false;//移动标记  
	 var _x,_y;//鼠标离控件左上角的相对位置  
	     $(document).on('click',"#promptBox >h3",function(){
	         //alert("click");//点击（松开后触发）  
	         }).mousedown(function(e){  
	         _move=true;  
	         _x=e.pageX-parseInt($("#promptBox").css("left"));  
	         _y=e.pageY-parseInt($("#promptBox").css("top"));  
	        // $("#promptBox").fadeTo(20, 0.5);//点击后开始拖动并透明显示 
	     });  
	     $(document).mousemove(function(e){ 
	    	 $("#promptBox >h3").css('cursor','move');	//出现移动图标
	         if(_move){  
	             var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置 
	             if (x < 0) {
	            	 x = 0;
	             } else if (x > $(window).width() - $("#promptBox").width()) {
	            	 x = $(window).width() - $("#promptBox").width();
	             }
	             
	             var y=e.pageY-_y;  
	             if(y < 0){
	            	 y = 0;
	             }else if (y > $(window).height()){
	            	 y = $(window).height();
	             }
	             $("#promptBox").css({top:y,left:x});//控件新位置  
	         }  
	     }).mouseup(function(){  
	     _move=false;  
	     //$("#promptBox").fadeTo("fast", 1);//松开鼠标后停止移动并恢复成不透明  
	   }); 
	     
	     
	     
	   //close 
	   $(document).on('click',"#promptBox >span.op,#promptBox > .btn .cancel_but",function(){
		   $(".ui-widget-overlay").addClass('hide');
		   $(".shadow").remove();
		   $("#promptBox").addClass('hide');
	   })
	
	

		
		//travel_agent_level
	/*	$(document).on('click',".travel_agent_level_add",function(e){
			var this_act = $(this).attr('value');
			alert(this_act);return false;
			$(".ui-widget-overlay").remove();
			$("#promptBox").remove();
			
			var json_str = '';
			$.ajax({
		        url:type_config_get_level_ajax_url,
		        type:'get',
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		if(data!=0){
		    			var json = eval(data); //数组 
		                $.each(json, function (index, item) {  
		                    //循环获取数据    
		                    var id = json[index].id;  
		                    var level = json[index].travel_agent_level;  
		                    json_str += "<option value='"+id+"'>"+level+"</option>";
		                    
		                });  
		    		}
		    	}      
		    });
			
			
			var str = "<div class='ui-widget-overlay ui-front'></div>";
			var str_con = '<div id="promptBox" class="pop-ups write ui-dialog" >';
			str_con += '<h3>Travel Agent Level</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			
			str_con += '<p style="height:45px;"><label><span>Class Types:</span>';
			str_con += '<input style="width:120px" type="text" id="level" name="level"></input></label><span class="tips" style="clear:both;display:block;position:absolute;left:136px;"></span></p>';
			
			str_con += '<p style="height:45px;"><label><span>Higher Agent :</span>';		
			str_con += '<select style="width:125px" id="higher_agent" name="higher_agent">';
			str_con += '<option value="0">no</option>';
			str_con += json_str;
			str_con += '</select></label></p>';	
			
			str_con += '<p style="height:45px;"><label><span>Higher Agent :</span>';		
			str_con += '<select style="width:125px" id="state" name="state">';
			str_con += '<option value="1">Usable</option>';
			str_con += '<option value="0">Disabled</option>';
			str_con += '</select></label></p>';	
			
			str_con += '<p class="btn">';
			str_con += '<input type="button" class="agent_confirm_but_more" value="Confirm"></input>';
			str_con += '<input type="button" class="agent_reset_but_val" value="Reset"></input>';
			str_con += '</p></div>';
			
			
			
			$(document.body).append(str);
			$(document.body).append(str_con);
		});*/
	   
	   
	   //代理商等级弹出框取消，重置按钮
	   $(document).on('click','#promptBox .agent_reset_but_val',function(e){
		   $("#promptBox").find("input#level").val('');
		   $("#promptBox select#higher_agent option:first").prop("selected", 'selected'); 
		   $("#promptBox select#state option:first").prop("selected", 'selected'); 
	   });
	   
	   
	   //代理商等级弹出框提交按钮
	   $(document).on('click','#promptBox .agent_confirm_but_more',function(e){
		   var level = $("#promptBox").find("input#level").val();
		   var higher_level = $("#promptBox").find("select#higher_agent").val();
		   var state = $("#promptBox").find("select#state").val();
		   if(level == ''){
			   $("#promptBox").find(".tips").html("Required fields!");
			   return false;
		   }
		   var re=/^[a-zA-Z]+$/;
		   if(!re.test(level)){
			   $("#promptBox").find(".tips").html("Can only input English!");
			   return false;
		   } 
		   
		   //验证等级唯一
		   $.ajax({
		        url:type_config_submit_level_ajax_url,
		        type:'get',
		        data:'level='+level+'&higher_level='+higher_level+'&state='+state,
		        dataType:'json',
		    	success:function(data){
		    		if(data==1){
		    			alert("Save success");
		    		}else{
		    			alert("Save failed");
		    		}
		    		location.reload();
		    	}      
		    });
		   
	   });
	   
	   
	   
	   
	   
	   
	   
	
	
	
	
	
});

// 动态改变右边部分宽度
function changeMainRWith() {
	$("#main > .r").css("width",($("#main").width() - 44 - $("#asideNav").width())+"px");
}