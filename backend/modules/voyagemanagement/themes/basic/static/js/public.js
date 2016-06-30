$(document).ready(function(){
	// 加载header和asideNav内容
	// $("#header").load("header.html");
	// $("#asideNav").load("asideNav.html");
	
	
	
	
	//delete删除弹框
	$(document).on('click',".delete",function(e) {
		var val = $(this).attr('id');
		 $(".ui-widget-overlay").remove();
		 $("#promptBox").remove();
		 var str = "<div class='ui-widget-overlay ui-front'></div>";
		 var str_con = '<div id="promptBox" class="pop-ups write ui-dialog" >';
			str_con += '<h3>Prompt</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			str_con += '<p>Are you sure to delete ?</p>';
			str_con += '<p class="btn">';
			str_con += '<input type="button" class="confirm_but" value="Confirm"></input>';
			str_con += '<input type="button" class="cancel_but" value="Cancel"></input>';
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
		 $("#promptBox").remove();
		 
		 var str = "<div class='ui-widget-overlay ui-front'></div>";
		 var str_con = '<div id="promptBox" class="pop-ups write ui-dialog" >';
			str_con += '<h3>Prompt</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			str_con += '<p>These records are deleted？</p>';
			str_con += '<p class="btn">';
			str_con += '<input type="button" class="confirm_but_more" value="Submit"></input>';
			str_con += '<input type="button" class="cancel_but" value="Cancel"></input>';
			str_con += '</p></div>';
		 var no_str = '<div id="promptBox" class="pop-ups write ui-dialog" >';
			no_str += '<h3>There is no selected</h3>';
			no_str += '<span class="op"><a class="close r"></a></span>';
			no_str += '<p>Please select delete items</p>';
			no_str += '<p class="btn">';
			no_str += '<input type="button" class="cancel_but" value="Cancel"></input>';
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
	     $(document).on('mousemove',"#promptBox >h3",function(e){ 
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
		   $("#promptBox").addClass('hide');
	   })
	
	     
	
	
	//国家添加编辑页面判断code是否唯一
	$('form#country_val').submit(function(){
        var a=0;
        var op = $(this).attr('class');
        var code = $("input#code").val();
        var name = $("input#name").val();
        var code_ch = $("input#code_chara").val();
        var data = "<span class='point' >Required fields cannot be empty</span>";
        
        $(".check_save_div input[type=text]").each(function(e){	//如果文本框为空值			
    		if($(this).val()==''){
    			$(this).parent().append(data);
    			$(this).addClass("point");
    			a=1;
    			return false;
    		}
       	}); 
        
        if(a==1){return false;}
        
        
        
        if(code!='' && name!='' && code_ch!=''){
        	var act = (op == 'country_edit')?1:2;
        	if(op == "country_edit")
        		var id = $("input#id").val();
        	else 
        		var id = '';
        	
        	 $.ajax({
			        url:ajax_url,
			        type:'get',
			        data:'code='+code+'&act='+act+'&id='+id,
			        async:false,
			     	dataType:'json',
			    	success:function(data){
			    		if(data==0) a=0;
			    		else{Alert("Code can't repeat!");a=1;}
			    	}      
			    });
        }
       if(a == 1){
           return false;
       }
    });
	//country and port
    $(".check_save_div input[type=text]").each(function(){//聚焦是清除
		$(this).focus(function(){
			 $(this).parent().find("span.point").remove();
			 $(this).removeClass("point");
		});
	 });
    
    
    //textarea聚焦是清除
	$("textarea").focus(function(){
		 $(this).parent().find("span.point").remove();
		 $(this).removeClass("point");
	});

	
	//港口添加编辑页面判断港口code是否唯一
	$('form#port_val').submit(function(){
        var a=0;
        var op = $(this).attr('class');
        var code = $("input#code").val();
        var name = $("input#name").val();
        var code_ch = $("input#code_chara").val();
        var data = "<span class='point' >Required fields cannot be empty</span>";
        
        $(".check_save_div input[type=text]").each(function(e){	//如果文本框为空值			
    		if($(this).val()==''){
    			$(this).parent().append(data);
    			$(this).addClass("point");
    			a=1;
    			return false;
    		}
       	}); 
        
        if(a==1){return false;}
        
        
        if(code!='' && name!='' && code_ch!=''){
        	
        	var act = (op == 'port_edit')?1:2;
        	if(op == "port_edit")
        		var id = $("input#id").val();
        	else 
        		var id = '';
        	
        	 $.ajax({
			        url:port_ajax_url,
			        type:'get',
			        data:'code='+code+'&act='+act+'&id='+id,
			        async:false,
			     	dataType:'json',
			    	success:function(data){
			    		if(data==0) a=0;
			    		else{Alert("Code can't repeat!");a=1;}
			    	}      
			    });
        }
       if(a == 1){
           return false;
       }
    });
	
	
	//cruise 
	//邮轮数据验证
	/*$("#cruise_val").validate({
        rules: {
            code:{required:true,isEnglish:true},
            desc:{required:true,isEnglish:true},
            name:{required:true,isEnglish:true},
            //photoimg:{required:true}
        },
        errorPlacement: function(error, element) { //错误信息位置设置方法
        	error.appendTo( element.parent().parent().find("span.tips") ); //这里的element是录入数据的对象
    	},
    });*/
	
	
	$("#photoimg").on('change',function(){
		var display = $("#img_back").css('display');
		if(display == 'none'){$("#img_back").css('display','')}
	});
	
	
	//cabin_type添加编辑页面判断type_code是否唯一
	$('form#cabin_type_val').submit(function(){
        var a=1;
        var op = $(this).attr('class');
        var code = $("input#code").val();
        var name = $("input#name").val();
        var live_number = $("select#live_number").val();
        var beds = $("select#beds").val();
        var room_min = $("input#room_min").val();
        var room_max = $("input#room_max").val();
        var floor = $("input#floor").val();
        var data = "<span class='point' >Required fields cannot be empty</span>";
        var room_data= "<span class='point' >Room area is not more than 200 ㎡ and the maximum is greater than the minimum</span>";
        var live_data = "<span class='point' >Maximum number of adults can not be greater than the number of beds</span>";
        
        if(code==''){
        	$("input#code").parent().append(data);
        	$("input#code").addClass("point");
			return false;
		}
        if(name == ''){
        	$("input#name").parent().append(data);
        	$("input#name").addClass("point");
			return false;
        }
        if(room_min==''){
        	$("input#room_min").parent().append(data);
        	$("input#room_min").addClass("point");
			return false;
        }
        if(room_min=='' || room_max==''){
        	$("input#room_max").parent().append(data);
        	$("input#room_max").addClass("point");
			return false;
        }
        if(live_number>beds){
        	$("select#live_number").parent().append(live_data);
        	$("select#live_number").addClass("point");
			return false;
        }else{
        	$("select#live_number").parent().find("span.point").remove();
        	$("select#live_number").removeClass("point");
        }
        if(room_min>=200 || room_max>=200 || room_max<=0 || (room_min>room_max)){
        	$("input#room_max").parent().append(room_data);
        	$("input#room_max").addClass("point");
			return false;
        }
        if(floor == ''){
        	$("input#floor").parent().append(data);
        	$("input#floor").addClass("point");
			return false;
        }
    	var act = (op == 'cabin_type_edit')?1:2;
    	if(op == "cabin_type_edit")
    		var id = $("input#id").val();
    	else 
    		var id = '';
    	
    	 $.ajax({
		        url:cabin_type_ajax_url,
		        type:'get',
		        data:'code='+code+'&act='+act+'&id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		if(data==0) a=0;
		    		else{Alert("Code can't repeat!");a=1;}
		    	}      
		    });
       if(a == 1){
           return false;
       }
    });
	
	
	
	//cabintype->graphic
	$('form#cabin_type_graphic_val').submit(function(){
        var op = $(this).attr('class');
        var desc = UE.getEditor('desc').getContentTxt();
        var file = $("input[type='file']").val();
        var data = "<span class='point' >Required fields cannot be empty</span>";
        
        if(desc==''){
        	Alert("Description cannot be empty");
			return false;
		}
   
        
    	if(op != 'cabin_type_graphic_edit'){
    		if(file==''){Alert("Please choose to upload pictures");
       	   	return false;}
    	}
    });
	
	
	//cabin 
	$('form#cabin_val').submit(function(){
		var a = 0;
		var op = $(this).attr('class');
		var deck = $("input[name='deck']").val();
//		var min = $(".check_save_div input[name='min']").val();
//		var max = $(".check_save_div input[name='max']").val();
		var cabin_type = $("select[name='cabin_type_id']").val();
		var data = "<span class='point' >Required fields cannot be empty</span>";
		var live_data = "<span class='point' >Can only enter an integer between 1-4, and the largest in number cannot be less than the minimum number</span>";
		
		$(".check_save_div input[type=text]").each(function(e){	//如果文本框为空值			
    		if($(this).val()==''){
    			$(this).parent().append(data);
    			$(this).addClass("point");
    			a=1;
    			return false;
    		}
       	}); 
		
        if(a==1){return false;}
       /* 
        if(min<1 || min>5 ){
        	$(".check_save_div input[name='min']").parent().append(live_data);
        	$(".check_save_div input[name='min']").addClass("point");
			return false;
        }
        if(max<1 || max>5 || (min>max)){
        	$(".check_save_div input[name='max']").parent().append(live_data);
        	$(".check_save_div input[name='max']").addClass("point");
			return false;
        }*/
        
        if(op == 'cabin_add'){
	        if($.trim($(".check_save_div textarea[name='name']").val())==''){
	        	$(".check_save_div textarea[name='name']").parent().append(data);
	        	$(".check_save_div textarea[name='name']").addClass("point");
	        	return false;
	        }
        }
        if(op == 'cabin_add'){
        	var cabin_name = $.trim($(".check_save_div textarea[name='name']").val());
        	var id = '';
        }else{
        	var cabin_name = $("input[name='name']").val();
        	var id = $("input[name='cabin_id']").val();
        }
      //提交前验证甲板数不能大于当前邮轮甲板数
  		$.ajax({
  	       url:check_cabin_deck_ajax_url,
  	       type:'post',
  	       dataType:'json',
  	       async:false,
  	       success:function(data){
  	    	   	if(data!=0){
  	    	   		var cruise_deck = data['deck_number'];
  	    	   		if(parseInt(deck) > parseInt(cruise_deck)){
  	    	   			alert("The cruise ship deck for a maximum of "+cruise_deck);a=1;
  	    	   		}
  	    	   	}
  	       }
  		});
  		if(a==1){return false;}
  		
      //提交前验证房间号是否已经存在
        //获取类型 
  		$.ajax({
  	       url:check_cabin_name_ajax_url,
  	       type:'post',
  	       data:'cabin_type='+cabin_type+'&id='+id+'&cabin_name='+cabin_name,
  	       dataType:'json',
  	       async:false,
  	       success:function(data){
  	    	   	if(data!=0){
  	    	   		var str = '';
  	    	   		$.each(data,function(k){
  	    	   			str += data[k]['cabin_name']+',';
  	    	   		});
  	    	   		str = str.substring(0,str.length-1);
  	    	   		alert("The cabin type already exists room number:"+str);a=1;
  	    	   	}
  	       }
  		});
      
  		if(a==1){return false;}
		
	})
	
	
	//shore_excursion添加编辑页面判断shore_excursion_code是否唯一
	$('form#shore_excursion_val').submit(function(){
        var a=0;
        var op = $(this).attr('class');
        var code = $("input#code").val();
        var name = $("input#name").val();
        var desc = UE.getEditor('desc').getContentTxt();
        var price = $("input#price").val();
        var data = "<span class='point' >Required fields cannot be empty</span>";
        var price_data = "<span class='point' >The price is within 1000000</span>";
        $(".check_save_div input[type=text]").each(function(e){	//如果文本框为空值			
    		if($(this).val()==''){
    			$(this).parent().append(data);
    			$(this).addClass("point");
    			a=1;
    			return false;
    		}
       	}); 
		
        if(a==1){return false;}
        
        var reg = /^\d+(\.\d{2})?$/;
    	if(!reg.test(price) || price>1000000){
    		$("input#price").parent().append(price_data);
    		$("input#price").addClass("point");
			return false;
    	}
        if(desc==''){
        	Alert("Description cannot be empty");
			return false;
		}
        
    	var act = (op == 'shore_excursion_edit')?1:2;
    	if(op == "shore_excursion_edit")
    		var id = $("input#id").val();
    	else 
    		var id = '';
    	
    	 $.ajax({
		        url:shore_excursion_ajax_url,
		        type:'get',
		        data:'code='+code+'&act='+act+'&id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		if(data==0) a=0;
		    		else{Alert("Code can't repeat!");a=1;}
		    	}      
		   });
        
       if(a == 1){
           return false;
       }
    });
	
	
	//preferential_way
	$("form#way_val").submit(function(){
		var data = "<span class='point' >Required fields cannot be empty</span>";
		if($("input[name='name']").val()==''){
			$("input[name='name']").parent().append(data);
			$("input[name='name']").addClass("point");
			return false;
		}
	});
	
	//area添加编辑验证
	$('form#area_val').submit(function(){
		var data = "<span class='point' >Required fields cannot be empty</span>";
		$(".check_save_div input[type=text]").each(function(e){	//如果文本框为空值			
    		if($(this).val()==''){
    			$(this).parent().append(data);
    			$(this).addClass("point");
    			a=1;
    			return false;
    		}
       	}); 
        if(a==1){return false;}
      
        var id = $(".check_save_div input[name='id']").val();
        
    	 $.ajax({
		        url:voyage_set_code_check_ajax_url,
		        type:'get',
		        data:'code='+code+'&act='+act+'&id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		if(data==0) a=0;
		    		else{Alert("Code can't repeat!");a=1;}
		    	}      
		  });
        
       if(a == 1){
           return false;
       }
        
	});
	
	
	//voyage_set添加编辑页面判断voyage_code是否唯一
	$('form#voyage_val').submit(function(){
        var a=0;
        var op = $(this).attr('class');
        var code = $("input[name='voyage_code']").val();
        var ticket_price = $("input[name='ticket_price']").val();
        var harbour_taxes = $("input[name='harbour_taxes']").val();
        var ticket_taxes = $("input[name='ticket_taxes']").val();
        var deposit_ratio = $("input[name='deposit_ratio']").val();
        
        var data = "<span class='point' >Required fields cannot be empty</span>";
        var price_data = "<span class='point' >A maximum of millions, and can only keep two decimal places</span>";
        var t_data = "<span class='point' >Can only input values between 0 and 100</span>";
        var file = $("input[type='file']").val();
        $(".check_save_div input[type=text]").each(function(e){	//如果文本框为空值			
    		if($(this).val()==''){
    			$(this).parent().append(data);
    			$(this).addClass("point");
    			a=1;
    			return false;
    		}
       	}); 
        if(a==1){return false;}
        
        var reg = /^\d+(\.\d{2})?$/;
    	
    	if(!reg.test(ticket_price) || ticket_price>1000000){
    		$("input[name='ticket_price']").parent().append(price_data);
    		$("input[name='ticket_price']").addClass("point");
			return false;
    	}
    	if(ticket_taxes<0 || ticket_taxes>100){
    		$("input[name='ticket_taxes']").parent().append(t_data);
    		$("input[name='ticket_taxes']").addClass("point");
			return false;
    	}
    	if(!reg.test(harbour_taxes) || harbour_taxes>1000000){
    		$("input[name='harbour_taxes']").parent().append(price_data);
    		$("input[name='harbour_taxes']").addClass("point");
			return false;
    	}
    	if(deposit_ratio<0 || deposit_ratio>100){
    		$("input[name='deposit_ratio']").parent().append(t_data);
    		$("input[name='deposit_ratio']").addClass("point");
			return false;
    	}
    	
        
        
//        if($("textarea[name='desc']").val() == ''){
//        	$("textarea[name='desc']").parent().append(data);
//        	$("textarea[name='desc']").addClass("point");
//			return false;
//        }
    	var desc = UE.getEditor('desc').getContentTxt();
	    if(desc == '') {
	    	Alert("Description cannot be empty");
			return false;
		}
        
        if(op == 'voyage_add'){
        	if(file == ''){
        		Alert("Please choose to upload pdf");
           	   	return false;
        	}
        }
        
        var act = (op == 'voyage_edit')?1:2;
    	if(op == "voyage_edit")
    		var id = $("input#voyage_id").val();
    	else 
    		var id = '';
    	
    	 $.ajax({
		        url:voyage_set_code_check_ajax_url,
		        type:'get',
		        data:'code='+code+'&act='+act+'&id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		if(data==0) a=0;
		    		else{Alert("Code can't repeat!");a=1;}
		    	}      
		   });
        
       if(a == 1){
           return false;
       }
        
       
    });
	
	
	
	
	
	//船舱定价弹出框
	$(document).on('click',".btn > input#cabin_pricing_add_but,.op_btn >.cabin_pricing_edit",function(){
		
		//判断用户点击按钮是添加操作还是编辑操作
		var act = $(this).attr('value');
		
		//获取航线
		var voyage_code = $("#cabin_pricing_vayage").val();
		//alert(voyage);return false;
		
		//定义以下程序所用变量
		var data_total = '';
		var other_data_total = '';
		var pricing_data = '';
		if(act == 'edit'){
			var id = $(this).attr('id');
			//获取编辑记录数据
			$.ajax({
		        url:get_cabin_pricing_data_ajax_url,
		        type:'get',
		        data:'id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		pricing_data = data;
		    	}      
		    });
			
		}
		//获取船舱类型
		$.ajax({
	        url:get_cabin_type_ajax_url,
	        type:'get',
	        data:'voyage_code='+voyage_code,
	        async:false,
	     	dataType:'json',
	    	success:function(data){
	    		if(data!=0){
		    		//data_total = data['all_result'];
		    		other_data_total = data['other_result'];
	    		}
	    	}      
	    });
		
		 $voyage = $("select#cabin_pricing_vayage").val();
		 $(".ui-widget-overlay").remove();
		 $("#promptBox").remove();
		 
		 
		 var is_selected = 0; // 0：表示床位数小于等于2 ，1：表示床位数大于2
		
		 
		 var str = "<div class='ui-widget-overlay ui-front'></div>";
		 var str_con = '<div id="promptBox" class="check_save_div pop-ups write ui-dialog" style="width:450px;" >';
			str_con += '<h3>Cabin Pricing</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			str_con += '<p style="height:30px;"><label><span style="margin-top: 4px;width:200px;float:left;display:block;text-align:right;">Cabin Type Name:</span>';
			
			if(act == 'edit'){
				//if(data_total!=''){
					/*$.each(data_total,function(key){
						var type_id = '';
						type_id = data_total[key]['id']==pricing_data['cabin_type_id']?"selected='selected'":'';
						
						str_con += '<option '+type_id+' value="'+data_total[key]['id']+'">'+data_total[key]['type_name']+'</option>';
					});*/
					str_con += '<input class="cabin_type_tmp_id" type="hidden" name="cabin_type_id" value="'+pricing_data['cabin_type_id']+'" /><input readonly="readonly" style="float:left;width:126px" type="text" value="'+pricing_data['type_name']+'" />';
					if(pricing_data['check_num'] > 2){
						is_selected = 1;
					}
				//}
				
			}else{
				if(other_data_total!=''){
					str_con += '<select  class="cabin_type_tmp_id" style="float:left;width:126px" id="cabin_type_id" name="cabin_type_id">';
					$.each(other_data_total,function(key){
						str_con += '<option value="'+other_data_total[key]['id']+'">'+other_data_total[key]['type_name']+'</option>';
					});
					str_con += '</select>';
					if(other_data_total[0]['check_num'] > 2){
						is_selected = 1;
					}
				}else{
					return false;
				}
			}
			
			str_con += '</label></p>';
			/*
			str_con += '<p><label><span style="width:200px;margin-left:-100px;display:inline-block;text-align:right;">Check Num:</span>';
			
			str_con += '<select style="width:126px" id="check_num" name="check_num">';
			
			for(var i=1;i<5;i++){
				var check_num = act == 'edit'?(i==pricing_data['check_num']?"selected='selected'":''):'';
				str_con += '<option '+check_num+' value="'+i+'">'+i+'</option>';
			}
			
			
			str_con += '</select></label></p>';*/
			
			
			if(is_selected == 0){
				var index = "disabled='disabled'";
			}else{
				var index = '';
			}
			
			
			str_con += '<p style="height:30px;"><label><span style="margin-top: 4px;width:200px;float:left;display:block;text-align:right;">Bed Price:</span>';
			var bed_price = act=='edit'?pricing_data['bed_price']:'';
			str_con += '<input style="width:120px;float:left;" onkeyup="this.value=this.value.replace(/[^0-9.]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^0-9.]/g,\'\')" type="text" value="'+bed_price+'" id="bed_price" name="bed_price" maxlength="7"/></label></p>';
			
			str_con += '<p style="height:30px;"><label><span style="margin-top: 4px;width:200px;float:left;display:block;text-align:right;">3/4th-Bed Price:</span>';
			var last_bed_price = act=='edit'?pricing_data['last_bed_price']:'';
			str_con += '<input style="float:left;width:120px" onkeyup="this.value=this.value.replace(/[^0-9.]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^0-9.]/g,\'\')" '+index+'  type="text" value="'+last_bed_price+'" id="last_bed_price" name="last_bed_price" maxlength="7"/></label></p>';
			
			
			str_con += '<p style="height:30px;"><label><span style="margin-top: 4px;width:200px;float:left;display:block;text-align:right;">2th-Bed Sates(%):</span>';
			var t_2_sates = act=='edit'?pricing_data['2_empty_bed_preferential']:'';
			str_con += '<input  onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" style="float:left;width:120px" type="text" value="'+t_2_sates+'" id="t_2_sates" name="t_2_sates" maxlength="3" /></label></p>';
			
			str_con += '<p style="height:30px;"><label><span style="margin-top: 4px;width:200px;float:left;display:block;text-align:right;">3/4th-Bed Sates(%):</span>';
			var t_3_sates = act=='edit'?(pricing_data['3_4_empty_bed_preferential']==0?'':pricing_data['3_4_empty_bed_preferential']):'';
			str_con += '<input style="float:left;width:120px"  onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" type="text" '+index+' value="'+t_3_sates+'"  id="t_3_sates" name="t_3_sates" maxlength="3" /></label></p>';
			str_con += "<span style='display:block;clear:both'></span>";
			str_con += '<p class="btn">';
			var sub_id = act=='edit'?id:0;
			str_con += '<input type="button" id="'+sub_id+'" class="cabin_pricing_confirm_but" value="submit"></input>';
			str_con += '<input type="button" style="margin-left:10px;" class="cancel_but" value="cancel"></input>';
			str_con += '</p></div>';
			
		 //$("#promptBox").before(str); 
		 $(document.body).append(str);
		 $(document.body).append(str_con);
		 //$("#promptBox").removeClass('hide');
		 $(".btn > .cabin_pricing_confirm_but").attr('voyage_code',$voyage);
		 $("#promptBox input[type=text]").each(function(){//聚焦是清除
				$(this).focus(function(){
					 $(this).parent().find("span.point").remove();
					 $(this).removeClass("point");
				});
		 });
	 }); 
	
	
	
	
	
	
	//船舱定价弹出框提交按钮
	$(document).on('click',"#promptBox > .btn .cabin_pricing_confirm_but",function(){
		
		var cabin_type_id = $(".cabin_type_tmp_id[name='cabin_type_id']").val();
		//alert(cabin_type_id);return false;
		//var check_num = $("select[name='check_num']").val();
		var bed_price = $("input[name='bed_price']").val();
		var last_bed_price = $("input[name='last_bed_price']").val();
		if(last_bed_price==''){last_bed_price='0';}
		var t_2_sates = $("input[name='t_2_sates']").val();
		var t_3_sates = $("input[name='t_3_sates']").val();
		if(t_3_sates==''){t_3_sates='0';}
		var voyage_code = $(this).attr('voyage_code');
		var sub_id = $(this).attr('id');
		
		var data = "<span class='point' >Required fields cannot be empty</span>";
		var price_data = "<span class='point' >The price is within 1000000</span>";
		var t_data = "<span class='point' >Can only enter an integer between 0 and 100</span>";
			
		if(bed_price==''){
			$("input[name='bed_price']").parent().append(data);
			$("input[name='bed_price']").addClass("point");
			return false;
		}
		if(bed_price>1000000){
			$("input[name='bed_price']").parent().append(price_data);
			$("input[name='bed_price']").addClass("point");
			return false;
		}
		if(last_bed_price==''){
			$("input[name='last_bed_price']").parent().append(data);
			$("input[name='last_bed_price']").addClass("point");
			return false;
		}
		if(last_bed_price>1000000){
			$("input[name='last_bed_price']").parent().append(price_data);
			$("input[name='last_bed_price']").addClass("point");
			return false;
		}
		if(t_2_sates==''){
			$("input[name='t_2_sates']").parent().append(data);
			$("input[name='t_2_sates']").addClass("point");
			return false;
		}
		if(t_2_sates>100){
			$("input[name='t_2_sates']").parent().append(t_data);
			$("input[name='t_2_sates']").addClass("point");
			return false;
		}
		if(t_3_sates==''){
			$("input[name='t_3_sates']").parent().append(data);
			$("input[name='t_3_sates']").addClass("point");
			return false;
		}
		if(t_3_sates>100){
			$("input[name='t_3_sates']").parent().append(t_data);
			$("input[name='t_3_sates']").addClass("point");
			return false;
		}
		$.ajax({
	        url:cabin_pricing_submit_ajax_url,
	        type:'get',
	        async:false,
	        data:'sub_id='+sub_id+'&voyage_code='+voyage_code+'&cabin_type_id='+cabin_type_id+'&bed_price='+bed_price+'&last_bed_price='+last_bed_price+'&t_2_sates='+t_2_sates+'&t_3_sates='+t_3_sates,
	     	dataType:'json',
	    	success:function(data){
	    		$(".ui-widget-overlay").remove();
	    		$("#promptBox").remove();
	    		if(data!=0){
	    			Alert('Save success');
	    			location.reload();
	    		}else{
	    			Alert('Save failed');
	    		}
	    	}      
	    });
		
	});
	
	
	
	//船舱定价弹出框入住人数选择判断：
	//大于2人禁用3/4号优惠
	$(document).on('change',"#promptBox select[name='check_num']",function(){
		var this_val = $(this).val();
		if(this_val<=2){
			$("#promptBox input[name='last_bed_price']").val('');
			$("#promptBox input[name='last_bed_price']").attr("disabled","disabled");
			$("#promptBox input[name='t_3_sates']").val('');
			$("#promptBox input[name='t_3_sates']").attr("disabled","disabled");
		}else{
			$("#promptBox input[name='last_bed_price']").removeAttr("disabled");
			$("#promptBox input[name='t_3_sates']").removeAttr("disabled");
		}
	});
	
	
	
	//船舱定价-》优惠政策弹框
	$(document).on('click',".btn > input#preferential_policies_add,.preferential_policies_edit",function(){
		
		//判断用户点击按钮是添加操作还是编辑操作
		var act = $(this).attr('value');
		var voyage_code = $("select#policies_vayage").val();
		
		//定义变量
		var strategy_data = '';
		var no_strategy_result = '';
		var policies_data = '';
		
		if(act == 'edit'){
			var id = $(this).attr('id');
			
			//获取编辑记录数据
			$.ajax({
		        url:get_preferential_policies_data_ajax_url,
		        type:'get',
		        data:'id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		policies_data = data;
		    	}      
		    });
		}
		
		//获取政策
		$.ajax({
	        url:get_strategy_data_ajax_url,
	        type:'get',
	        data:'voyage_code='+voyage_code,
	        async:false,
	     	dataType:'json',
	    	success:function(data){
	    		if(data!=0){
	    			//strategy_data = data['strategy_result'];
	    			no_strategy_result = data['no_strategy_result'];
	    		}
	    	}      
	    });
		
		 $voyage = $("select#policies_vayage").val();
		 $(".ui-widget-overlay").remove();
		 $("#promptBox").remove();
		 var str = "<div class='ui-widget-overlay ui-front'></div>";
		 var str_con = '<div id="promptBox" class="check_save_div pop-ups write ui-dialog" style="width:450px;" >';
			str_con += '<h3>Cabin Pricing</h3>';
			str_con += '<span class="op"><a class="close r"></a></span>';
			str_con += '<p style="height:30px;"><label><span style="width:200px;margin-top:4px;float:left;display:block;text-align:right;">Strategy:</span>';
			
			
			if(act == 'edit'){
				/*if(strategy_data!=''){
					$.each(strategy_data,function(key){
						var strategy_id = act == 'edit'?(strategy_data[key]['id']==policies_data['p_w_id']?"selected='selected'":''):'';
						str_con += '<option '+strategy_id+'  value="'+strategy_data[key]['id']+'">'+strategy_data[key]['strategy_name']+'</option>';
					});
				}*/
				
				str_con += '<input class="strategy_tmp_id" type="hidden" name="strategy" value="'+policies_data['p_w_id']+'" /><input readonly="readonly" style="float:left;width:130px" type="text" value="'+policies_data['strategy_name']+'" />';
				
			}else{
				str_con += '<select class="strategy_tmp_id" style="float:left;width:200px" id="strategy" name="strategy">';
				if(no_strategy_result!=''){
					$.each(no_strategy_result,function(key){
						str_con += '<option  value="'+no_strategy_result[key]['id']+'">'+no_strategy_result[key]['strategy_name']+'</option>';
						
					});
				}
				str_con += '</select>';
			}
			str_con += '</label></p>';
			
			str_con += '<p style="height:30px;"><label><span style="margin-top:4px;width:200px;display:block;float:left;text-align:right;">1/2 Preferential(%):</span>';
			var price = act=='edit'?policies_data['p_price']:'';
			str_con += '<input maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" style="float:left;width:130px" type="text" value="'+price+'" id="price" name="price" /></label></p>';
			
			str_con += '<p style="height:30px;"><label><span style="margin-top:4px;width:200px;display:block;float:left;text-align:right;">3/4 Preferential(%):</span>';
			var s_price = act=='edit'?policies_data['s_p_price']:'';
			str_con += '<input maxlength="3" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" style="float:left;width:130px" type="text" value="'+s_price+'" id="s_price" name="s_price" /></label></p>';
			
			str_con += '<span style="clear:both;display:block;"></span>';
			
			str_con += '<p class="btn">';
			var sub_id = act=='edit'?id:0;
			str_con += '<input type="button" id="'+sub_id+'" class="preferential_policies_confirm_but" value="submit"></input>';
			str_con += '<input type="button" style="margin-left:10px;" class="cancel_but" value="cancel"></input>';
			str_con += '</p></div>';
			
		 //$("#promptBox").before(str); 
		 $(document.body).append(str);
		 $(document.body).append(str_con);
		 //$("#promptBox").removeClass('hide');
		 $(".btn > .preferential_policies_confirm_but").attr('voyage_code',$voyage);
		 $("#promptBox input[type=text]").each(function(){//聚焦是清除
				$(this).focus(function(){
					 $(this).parent().find("span.point").remove();
					 $(this).removeClass("point");
				});
			});
	})
	
	
	//船舱定价->优惠政策弹出框提交按钮
	$(document).on('click',"#promptBox > .btn .preferential_policies_confirm_but",function(){
		
		
		var strategy = $(".strategy_tmp_id[name='strategy']").val();
		//alert(strategy);return false;
		var price = $("input[name='price']").val();
		var s_price = $("input[name='s_price']").val();
		var voyage_code = $(this).attr('voyage_code');
		var sub_id = $(this).attr('id');
		
		var data = "<span class='point' >Required fields cannot be empty</span>";
		var t_data = "<span class='point' >Can only enter an integer between 0 and 100</span>";
		
		if(price==''){
			$("input[name='price']").parent().append(data);
			$("input[name='price']").addClass("point");
			return false;
		}
		if(price>100){
			$("input[name='price']").parent().append(t_data);
			$("input[name='price']").addClass("point");
			return false;
		}
		if(s_price==''){
			$("input[name='s_price']").parent().append(data);
			$("input[name='s_price']").addClass("point");
			return false;
		}
		if(s_price>100){
			$("input[name='s_price']").parent().append(t_data);
			$("input[name='s_price']").addClass("point");
			return false;
		}
		
		$.ajax({
	        url:preferential_policies_submit_ajax_url,
	        type:'get',
	        async:false,
	        data:'sub_id='+sub_id+'&voyage_code='+voyage_code+'&strategy='+strategy+'&price='+price+'&s_price='+s_price,
	     	dataType:'json',
	    	success:function(data){
	    		$(".ui-widget-overlay").remove();
	    		$("#promptBox").remove();
	    		if(data!=0){
	    			Alert('Save success');
	    			location.reload();
	    		}else{
	    			Alert('Save failed');
	    		}
	    	}      
	    });
		
		
		
	});
	
	
	
	//船舱定价-》观光路线添加页面航线改变
	$(document).on('change',"#tour_add_voyage  #vayage",function(){
		var voyage = $(this).val();
		$.ajax({
	        url:get_tour_data_ajax_url,
	        type:'get',
	        async:false,
	        data:'voyage='+voyage,
	     	dataType:'json',
	    	success:function(data){
	    		if(data!=0){
	    			var reallt_result = data['really'];
	    			var tour_result = data['result'];
	    			var really_arr = new Array();
	    			$.each(reallt_result,function(key){
	    				really_arr.push(reallt_result[key]['sh_id']);
	    			});
	    			var str = '';
	    			$.each(tour_result,function(k){
	    				if($.inArray(tour_result[k]['id'], really_arr)==-1){
		    				str += '<span style="display: block;height:30px;text-align:left;width:200px;">';
		    				str += '<input style="margin-right:10px;" type="checkbox" name="tour[]" value="'+tour_result[k]['id']+'" />';
		    				str += tour_result[k]['se_name'];
		    				str += '</span>';
	    				}
	    			});
	    			$("#tour_add_voyage #tour_data_list").html(str);
	    			
	    		}else{
	    			$("#tour_add_voyage #tour_data_list").html('');
	    		}
	    	}      
	    });
	});
	
	
	

	
	//船舱定价-》附加费添加页面航线改变
	$(document).on('change',"#surcharge_add_voyage  #vayage",function(){
		var voyage = $(this).val();
		$.ajax({
	        url:get_surcharge_data_ajax_url,
	        type:'get',
	        async:false,
	        data:'voyage='+voyage,
	     	dataType:'json',
	    	success:function(data){
	    		if(data!=0){
	    			var reallt_result = data['really'];
	    			var surcharge_result = data['result'];
	    			var really_arr = new Array();
	    			$.each(reallt_result,function(key){
	    				really_arr.push(reallt_result[key]['cost_id']);
	    			});
	    			var str = '';
	    			$.each(surcharge_result,function(k){
	    				if($.inArray(surcharge_result[k]['id'], really_arr)==-1){
		    				str += '<span style="display: block;height:30px;text-align:left;width:200px;">';
		    				str += '<input style="margin-right:10px;" type="checkbox" name="su[]" value="'+surcharge_result[k]['id']+'" />';
		    				str += surcharge_result[k]['cost_name'];
		    				str += '</span>';
	    				}
	    			});
	    			$("#surcharge_add_voyage #surcharge_data_list").html(str);
	    			
	    		}else{
	    			$("#surcharge_add_voyage #surcharge_data_list").html('');
	    		}
	    	}      
	    });
	});
	
	
	
	//active-config detail
	
	$("form#active_config_detail_val").submit(function(){
		var op = $(this).attr('class');
		var detail_title = $("input[name='detail_title']").val();
		var detail_desc = UE.getEditor('detail_desc').getContentTxt();
		var file = $("input[type='file']").val();
		var data = "<span class='point' >Required fields cannot be empty</span>";
       
		if(detail_title==''){
			$("input[name='detail_title']").parent().append(data);
			$("input[name='detail_title']").addClass("point");
			return false;
		}
		if(op == 'active_config_detail_add'){
			if(file == ''){
				Alert("Please choose to upload pictures");
		   	   	return false;
			}
		}
		if(detail_desc ==''){
			Alert("Description cannot be empty");
			return false;
		}
	});
	
	
	
	//航线-》船舱
	$(document).on('click','#cabin_right_but',function(){
		var str = '';
		//alert('right');
		//获取左边选中值
		$("#cabin_left_ul li").find("input[type='checkbox']:checked").each(function(e){
			var id = $(this).val();
			var text = $(this).parent().parent().find("span.text").text();
			var max = $(this).attr('c_max');
			var last = $(this).attr('c_last');
			
			str += '<li><span><input value="'+id+'" name="cabin_right_ids[]" type="checkbox"><input type="hidden" name="c_id[]" value="'+id+'" /><input type="hidden" name="c_name[]" value="'+text+'" /><input type="hidden" name="c_max[]" value="'+max+'" /><input type="hidden" name="c_last[]" value="'+last+'"></span><span class="text">'+text+'</span></li>';
			$(this).parent().parent().remove();
		});
		
		$("#cabin_right_ul").append(str);
	});

	$(document).on('click','#cabin_left_but',function(){

		//alert('left');
		var str = '';
		//获取左边选中值
		$("#cabin_right_ul li").find("input[type='checkbox']:checked").each(function(e){
			var id = $(this).val();
			var max = $(this).parent().find("input[name='c_max']").val();
			var last = $(this).parent().find("input[name='c_last']").val();
			var text = $(this).parent().parent().find("span.text").text();
			
			
			str += '<li><span><input value="'+id+'" c_max="'+max+'" c_last="'+last+'" type="checkbox"></span><span class="text">'+text+'</span></li>';
			$(this).parent().parent().remove();
		});
		
		$("#cabin_left_ul").append(str);

			
	});
	
	
	
	
	
	
	
	
	
	
	//表格全选反选功能
	$('table th input:checkbox').on('click' , function(){
        var that = this;
        $(this).closest('table').find('tr > td:first-child input:checkbox')
        .each(function(){
            this.checked = that.checked;
            $(this).closest('tr').toggleClass('selected');
        });
    });
	
	
	//添加编辑页面取消填写按钮
	$(".btn > .cancle").on('click',function(){
		$("form input#code").val('');
		$("form input#code_chara").val('');
		$("form input#name").val('');
		$("form textarea#desc").val('');
		$("form input#detail_title").val('');
		$("form textarea#detail_desc").val('');
		$("form input#voyage_name").val('');
		$("form input#voyage_num").val('');
		$("form textarea#desc").val('');
		$("form input#ticket_price").val('');
		$("form input#ticket_taxes").val('');
		$("form input#harbour_taxes").val('');
		$("form input#deposit_ratio").val('');
	});
	
	

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
		$(".tab_title > .active").removeClass("active");
		$(".tab_content > .active").removeClass("active");
		$(this).addClass("active");
		$($(".tab_content > div")[index]).addClass("active");
	});
	
	
	/*
	//价格小数点限制
	$(".price_data").on('keyup', function (event) {
	    var $amountInput = $(this);
	    //响应鼠标事件，允许左右方向键移动 
	    event = window.event || event;
	    if (event.keyCode == 37 | event.keyCode == 39) {
	        return;
	    }
	    //先把非数字的都替换掉，除了数字和. 
	    $amountInput.val($amountInput.val().replace(/[^\d.]/g, "").
	        //只允许一个小数点              
	        replace(/^\./g, "").replace(/\.{2,}/g, ".").
	        //只能输入小数点后两位
	        replace(".", "$#$").replace(/\./g, "").replace("$#$", ".").replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3'));
	            });
	$(".price_data").on('blur', function () {
	    var $amountInput = $(this);
	    //最后一位是小数点的话，移除
	    $amountInput.val(($amountInput.val().replace(/\.$/g, "")));
	});*/
	
	
	
	
	
	
	
});

// 动态改变右边部分宽度
function changeMainRWith() {
	$("#main > .r").css("width",($("#main").width() - 44 - $("#asideNav").width())+"px");
}


//封装alert
function Alert(info){
	$(".ui-widget-overlay").remove();
	 $("#promptBox").remove();
	 var str = "<div class='ui-widget-overlay ui-front'></div>";
	 var str_con = '<div id="promptBox" class="pop-ups write ui-dialog" >';
		str_con += '<h3>Prompt</h3>';
		str_con += '<span class="op"><a class="close r"></a></span>';
		str_con += '<p>'+info+'</p>';
		str_con += '<p class="btn">';
		str_con += '<input type="button" class="cancel_but" value="OK"></input>';
		str_con += '</p></div>';
		
	 //$("#promptBox").before(str); 
	 $(document.body).append(str);
	 $(document.body).append(str_con);
}


//09/05/2016 12:12:23
function createDate(time){
	var date = time.substr(0,10);
	var year = date.split('-');
	date = year[2]+'/'+year[1]+'/'+year[0]+' '+time.substr(11,8);
	return date;
}