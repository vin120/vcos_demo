<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use  yii\web\Session;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>

<!-- main content start -->
<div id="addGuestInfo" class="mainContent">
	<div id="topNav">
		<?php echo yii::t('app','Agent Ticketing')?>
		<span>>></span>
		<a href="<?php echo Url::toRoute(['bookingticket','code'=>$code])?>"><?php echo yii::t('app','Reservation')?></a>
		<span>>></span>
		<a href="<?php echo Url::toRoute(['inputmode','code'=>$code])?>"><?php echo yii::t('app','Input mode')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Add Guest Infomation')?></a>
	</div>
	<div id="mainContent_content" class="pBox">
		<div class="btnBox1">
			<input type="button" value="<?php echo yii::t('app','Add')?>" class="btn1" id="add"></input>
			<input type="button" value="<?php echo yii::t('app','Edit')?>" class="btn1" id="edit"></input>
			<input type="button" value="<?php echo yii::t('app','Del')?>" class="btn2" id="del_data"></input>
			<!-- <input type="button" value="<?php //echo yii::t('app','Deail')?>" class="btn1" id="deail"></input> -->
		</div>
		<table id="add_uest_info_table">
			<thead>
				<tr>
					<th><input type="checkbox"></input></th>
					<th><?php echo yii::t('app','Last Name')?></th>
					<th><?php echo yii::t('app','First Name')?></th>
					<th><?php echo yii::t('app','Sex')?></th>
					<th><?php echo yii::t('app','Date Of Birth')?></th>
					<th><?php echo yii::t('app','Passport Number')?></th>
					<th><?php echo yii::t('app','Date Of Issue')?></th>
					<th><?php echo yii::t('app','Date Of Expiry')?></th>
					<th><?php echo yii::t('app','Deail')?></th>
				</tr>
			</thead>
			<tbody>
				<!-- <tr>
					<td><input type="checkbox"></input></td>
					<td>ZHAN</td>
					<td>SAN</td>
					<td>Male</td>
					<td>30/01/1990</td>
					<td>G1234567</td>
					<td>21/03/2013</td>
					<td>21/03/2013</td>
					<td>....</td>
				</tr> -->
			</tbody>
		</table>
		<div class="btnBox2">
			<a href="javascript:history.go(-1)"><input type="button" id="add_uest_info_previous" value="PREVIOUS" class="btn2"></input></a>
			<input id="add_uest_info_next_but" type="button" value="NEXT" class="btn1"></input>
		</div>
	</div>
	<!-- popups start -->
	<div class="shadow"></div>
	<div class="popups" id="addPopups">
	<form id="add_uest_info_form">
		<h3><span>Add</span><a href="#" class="close r">&#10006;</a></h3>
		
		<div class="pBox">
			<div>
				<label class="wrongBox">
					<span>Passport No.:</span>
					<span>
						<input type="text" name="passport" id="passport"></input>
						<em></em>
					</span>
				</label>
				
				<label class="wrongBox">
					<span>Full Name:</span>
					<span>
						<input type="text" name="full_name" id="full_name"></input>
						<em></em>
					</span>
				</label>
				
			</div>
			<div>
				<label class="wrongBox">
					<span>Last Name:</span>
					<span>
						<input type="text" name="last_name" id="last_name"></input>
						<em></em>
					</span>
					
				</label>
				<label class="wrongBox">
					<span>First Name:</span>
					<span>
						<input type="text" name="first_name" id="first_name"></input>
						<em></em>
					</span>
				</label>
			</div>
			
			<div>
				<label class="wrongBox">
					<span>Gender:</span>
					<span>
						<select name="gender" id="gender">
							<option value="M">M</option>
							<option value="F">F</option>
						</select>
						<em></em>
					</span>
				</label>
				<label class="wrongBox">
					<span>Nationalify:</span>
					<span>
						<select name="nationalify" id="nationalify">
						<?php foreach ($country_result as $v){?>
						<option value="<?php echo $v['country_code']?>"><?php echo $v['country_name']?></option>
						<?php }?>
						</select>
						<em></em>
					</span>
				</label>
			</div>
			
			<div>
				<label class="wrongBox">
					<span>Email:</span>
					<span>
						<input type="text"  name="email" id="email"></input>
						<em></em>
					</span>
				</label>
				<label class="wrongBox">
					<span>Phone:</span>
					<span>
						<input type="text"  name="phone" id="phone"></input>
						<em></em>
					</span>
				</label>
			</div>
			<div>
				<label class="wrongBox">
					<span>Date Of Birth:</span>
					<span>
						<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en',maxDate:'%y-%M-%d'})" name="birth" id="birth"></input>
						<em></em>
					</span>
				</label>
				<label class="wrongBox">
					<span>Birth Place:</span>
					<span>
						<input type="text" name="birth_place" id="birth_place" ></input>
						<em></em>
					</span>
				</label>
			</div>
			<div>
				<label class="wrongBox">
					<span>Date Of Issue:</span>
					<span>
						<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en',maxDate:'#F{$dp.$D(\'expiry\')}'})" name="issue" id="issue"></input>
						<em></em>
					</span>
				</label>
				<label class="wrongBox">
					<span>Date Of Expiry:</span>
					<span>
						<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en',minDate:'#F{$dp.$D(\'issue\')}',startDate:'#F{$dp.$D(\'issue\',{d:+1})}'})" name="expiry" id="expiry"></input>
						<em></em>
					</span>
				</label>
			</div>
			
			
			<div class="btnBox2">
				<input type="button" id="add_uest_info_check" value="VERIFY" class="btn2"></input>
				<input type="button" id="add_uest_info_save" value="SUBMIT" class="btn1" disabled="disabled"></input>
				<input type="button" value="CANCEL" class="btn2 close"></input>
			</div>
		</div>
		</form>
	</div>
	<div class="popups" id="deailPopups" >
		<h3>Deail<a href="#" class="close r">&#10006;</a></h3>
		<div class="pBox">
			<div>
				<label>
					<span>Last Name:</span>
					<span name="last_name">
					aaa
					</span>
				</label>
				<label>
					<span>First Name:</span>
					<span name="first_name">
					</span>
				</label>
			</div>
			<div>
				<label>
					<span>Full Name:</span>
					<span name="full_name">
						
					</span>
				</label>
				<label>
					<span>Passport No.:</span>
					<span name="passport">
					</span>
				</label>
				
			</div>
			<div>
				<label>
					<span>Gender:</span>
					<span name="gender">
					</span>
				</label>
				<label>
					<span>Nationalify:</span>
					<span name="nationalify">
					</span>
				</label>
			</div>
			
			<div>
				<label>
					<span>Email:</span>
					<span name="email">
					</span>
				</label>
				<label>
					<span>Phone:</span>
					<span name="phone">
					</span>
				</label>
			</div>
			<div>
				<label>
					<span>Date Of Birth:</span>
					<span name="birth">
					</span>
				</label>
				<label>
					<span>Birth Place:</span>
					<span name="birth_place">
						
					</span>
				</label>
			</div>
			<div>
				<label>
					<span>Date Of Issue:</span>
					<span name="issue">
					</span>
				</label>
				<label>
					<span>Date Of Expiry:</span>
					<span name="expiry">
						
					</span>
				</label>
			</div>
		</div>
		
	</div>
	<div class="popups prompt">
		<h3>Prompt<a href="#" class="r close">&#10006;</a></h3>
		<div class="pBox">
			<p>Sure to delete?</p>
			<p class="btnBox">
				<input type="button" value="YES" class="btn1" id="query_del"></input>
				<input type="button" value="NO" class="btn2 close"></input>
			</p>
		</div>
	</div>
	<!-- popups end -->
</div>
<!-- main content end -->

<script type="text/javascript">
window.onload = function(){

	//定义全局变量存在编辑时数据
	temporary_var = '';

	//获取session数据判断是否存在，存在则遍历显示
	var data = $.session.get('membership');
	var user_tr_data = '';
	
	//人数
	if(data != undefined){
		data = data.replace(/\+/g," "); 
		data_ex = data.split('-');
		
		$.each(data_ex,function(e){
			if(data_ex[e]!=''){
				user_tr_data += "<tr><td><input type='checkbox'></input></td>";
				var val = data_ex[e].split('&');
				var u_passport = '';
				var u_full_name = ''
				var last_name = '';
				var first_name = '';
				var gender = '';
				var birth = '';
				var passport = '';
				var issue = '';
				var expiry = '';
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
				    if(name == 'last_name'){last_name = val;}
				    if(name == 'first_name'){first_name = val;}
					if(name == 'gender'){gender = val;}
					if(name == 'birth'){birth = val.replace(/%2F/g,"/");}
					if(name == 'passport'){passport = val;}
					if(name == 'issue'){issue = val.replace(/%2F/g,"/");}
					if(name == 'expiry'){expiry = val.replace(/%2F/g,"/");}
				});
				
				user_tr_data += "<td>"+last_name+"</td>";
				user_tr_data += "<td>"+first_name+"</td>";
				user_tr_data += "<td>"+gender+"</td>";
				user_tr_data += "<td>"+birth+"</td>";
				user_tr_data += "<td>"+passport+"</td>";
				user_tr_data += "<td>"+issue+"</td>";
				user_tr_data += "<td>"+expiry+"</td>";
				user_tr_data += "<td><button class='btn1 detail'><img src='<?=$baseUrl ?>images/text.png'></button></td>";
				user_tr_data += "<tr>";
			}
			
		});
		$("table#add_uest_info_table tbody").html(user_tr_data);

	}
	

	field_name = new Array();
	field_name['last_name'] =  "last_name";
	field_name['first_name'] = "first_name";
	field_name['full_name'] = "full_name";
	field_name['passport'] = "passport_number";
	field_name['gender'] = "gender";
	field_name['nationalify'] = "country_code";
	field_name['email'] = "email";
	field_name['phone'] = "mobile_number";
	field_name['birth'] = "birthday";
	field_name['birth_place'] = "birth_place";
	field_name['issue'] = "date_issue";
	field_name['expiry'] = "date_expire";


	//add时填入护照号失去焦点判断该护照号是否存在，存在则获取数据显示
	$("#addPopups .pBox input[name='passport']").blur(function (){
		var a = 0;
		//判断是否是添加页面
		var act =$("#addPopups h3 > span").html();
		var passport = $(this).val();
		if(act == 'Add'){
			//判断该乘客是否重复购票
			a = Check_buy_ticket(passport);
			if(a == 1){Alert("You have bought the current route, can't repeat purchase ");return false;}

			
			//判断护照号是否 存在会员表
			$.ajax({
		        url:"<?php echo Url::toRoute(['passportcheckmembership']);?>",
		        type:'post',
		        async:false,
		        data:'passport='+passport,
		     	dataType:'json',
		    	success:function(data){
		    		if(data != 0){
		    			for (key in field_name){
		        			if(key != 'gender' && key != 'nationalify'){
			        			//文本框
		        				if(key == 'birth' || key == 'issue' || key == 'expiry'){
		            				$("#addPopups input[name='"+key+"']").val(createDate(data[field_name[key]]));
		                		}else{
			        				$("#addPopups input[name='"+key+"']").val(data[field_name[key]]);
		                		}
		        			}else{
			        			//下拉框
		        				$("#addPopups select[name='"+key+"'] option[value='"+data[field_name[key]]+"']").prop("selected","selected");
		        	           
		            		}
		    	        }

		    		}

		    		
		        		
		    	}      
		    });
		}

	});

	
	//check
	$(document).on('click','#addPopups .btnBox2 input#add_uest_info_check',function(){
		var act = $("#addPopups h3 > span").html();
		var a = 0;
		var passport = $("#addPopups input[name='passport']").val();
		var full_name = $("#addPopups input[name='full_name']").val();
		var gender = $("#addPopups select[name='gender']").val();
		var birth = $("#addPopups input[name='birth']").val();
		var issue = $("#addPopups input[name='issue']").val();
		var expiry = $("#addPopups input[name='expiry']").val();
		var voyage_code = "<?php echo $code;?>";
		
		//文本框验证
		a = checkInput();
		if(a==1){return false;}
		
		if(act == 'Add'){
			//判断该乘客是否重复购票
			a = Check_buy_ticket(passport);
			if(a == 1){Alert("You have bought the current route, can't repeat purchase ");return false;}

			
			//session验证:护照号
			a = checkSessionPassport(passport);
			if(a==1){Alert("Passport number already exists, can only modify the record");return false;}
			
			//session验证，full_name+gender+birth
			a = checkSessionNameSexBirth(full_name,gender,birth);
			if(a==1){Alert("The information already exists, can only modify the record");return false;}
			
		}
		//护照验证
		a = checkPassPort(passport);
		if(a==1){return false;}
		
		//全名+性别+出生日期验证
		a = checkNameSexBirth(full_name,gender,birth);
		if(a==1){return false;}

		//护照有效期验证
		a = checkPassPortDate(issue,expiry,voyage_code);
		if(a==1){Alert("Passport validity must be within the scope of the course date ");return false;}
		else if(a==2){Alert("Date must be in 3 to 10 years ");return false;}
		
		$("#addPopups").find("em").html('');

		$("#addPopups .btnBox2 input#add_uest_info_save").removeAttr("disabled");
		$("#addPopups .btnBox2 input#add_uest_info_save").css("background","#01b9b0");
		
	});


	//如果验证完成后，再次修改文本数据，需再次把提交按钮置灰
	$(".popups input[type='text'],.popups select").blur(function(){
		$("#addPopups .btnBox2 input#add_uest_info_save").attr("disabled","disabled");
		$("#addPopups .btnBox2 input#add_uest_info_save").css("background","#ccc");
	});

	//save
	$(document).on('click','#addPopups .btnBox2 input#add_uest_info_save',function(){

		if($("#addPopups .btnBox2 input#add_uest_info_save").prop("disabled")){return false;}

		//var m_id = $("#addPopups input[name='m_id']").val();
		
		var act = $("#addPopups h3 > span").html();
		
		var p_no = $("#addPopups input[name='passport']").val();

			var key = $("#addPopups input[name='passport']").val();
			
			var data = $.session.get("membership");
			if(data == undefined){
				data = '';
				}
			//编辑保存时先将旧数据清除，再保存新数据
			if(act == 'Edit'){
				data = data.replace('-'+temporary_var+'-', "-");
				}
			data += $("form#add_uest_info_form").serialize()+'-';
			//设置session
			$.session.set("membership", data);
			

			if(act == 'Add'){
				var str = '';
				str += "<tr>";
				str += '<td><input type="checkbox" value=""></input></td>';
				str += '<td>'+$("#addPopups input[name='last_name']").val()+'</td>';
				str += '<td>'+$("#addPopups input[name='first_name']").val()+'</td>';
				str += '<td>'+$("#addPopups select[name='gender']").val()+'</td>';
				str += '<td>'+$("#addPopups input[name='birth']").val()+'</td>';
				str += '<td>'+$("#addPopups input[name='passport']").val()+'</td>';
				str += '<td>'+$("#addPopups input[name='issue']").val()+'</td>';
				str += '<td>'+$("#addPopups input[name='expiry']").val()+'</td>';
				str += "<td><button class='btn1 detail'><img src='<?=$baseUrl ?>images/text.png'></button></td>";
				str += "</tr>";

				Alert("Add a success");
	            $("table#add_uest_info_table > tbody").append(str);

			}else if(act == 'Edit'){

				var tr  = $("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent();
				tr.find("td").eq(1).html($("#addPopups input[name='last_name']").val());
				tr.find("td").eq(2).html($("#addPopups input[name='first_name']").val());
				tr.find("td").eq(3).html($("#addPopups select[name='gender']").val());
				tr.find("td").eq(4).html($("#addPopups input[name='birth']").val());
				tr.find("td").eq(5).html($("#addPopups input[name='passport']").val());
				tr.find("td").eq(6).html($("#addPopups input[name='issue']").val());
				tr.find("td").eq(7).html($("#addPopups input[name='expiry']").val());

				
				Alert("Modify the success");
			}

            //获取
           // var v = $("#addPopups input[name='passport_num']").val();
            //var data = $.session.get("membership");
            //alert(data);
            //删除
            //$.session.remove(key);
            //清除数据
            //$.session.clear();
	

		$(".shadow").hide();
        $(".popups").hide();
	});

	

	//add
	$("#mainContent_content .btnBox1 input#add").click(function(){
		$("#addPopups h3 > span").html('Add');
		//清空文本
		$("#addPopups .pBox input[type=text]").each(function(e){	//如果文本框为空值			
    		$(this).val('');
       	}); 
		$("#addPopups .pBox select").each(function(){
			$(this).find("option:selected").removeAttr("selected");
		});
		
		$("#addPopups .btnBox2 input#add_uest_info_save").attr("disabled","disabled");
		$("#addPopups .btnBox2 input#add_uest_info_save").css("background","#ccc");
		
	});


	//edit
	$("#mainContent_content .btnBox1 input#edit").click(function(){

		$("#addPopups h3 > span").html('Edit');

		var length = $("table#add_uest_info_table tbody input[type='checkbox']:checked").length;
		if(length == 0 ){
			Alert("Please select a query item in detail");return false;
			}
		if(length > 1){
			Alert("Every time can only query a detailed information");return false;
			}

		//显示弹窗
		new PopUps($("#addPopups"));

		
		//清空文本
		$("#addPopups .pBox input[type=text]").each(function(e){	//如果文本框为空值			
    		$(this).val('');
       	}); 
		$("#addPopups .pBox select").each(function(){
			$(this).find("option:selected").removeAttr("selected");
		});
		$("#addPopups .btnBox2 input#add_uest_info_save").attr("disabled","disabled");
		$("#addPopups .btnBox2 input#add_uest_info_save").css("background","#ccc");


		var p_no = $("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent().find("td").eq(5).html();

		var data = $.session.get('membership');
		var str = '';	//	存放其他
		var curr_str = ''; //存放当前
		data_ex = data.split('-');
		$.each(data_ex,function(e){
			if(data_ex[e]!=''){
				var val = data_ex[e].split('&');
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
			      	  if(name == 'passport' && val == p_no){
				      	 
			      			curr_str = data_ex[e];
				      	  }
				});
				
			}
			
		});

		temporary_var = curr_str ; 
		

		curr_str.split('&').forEach(function(param){
		  param = param.split('=');
		  var name = param[0],
		      val = param[1];
	      	  if(name == 'birth' || name == 'issue' || name == 'expiry'){
	      		val = val.replace(/%2F/g,"/");
		      }
	      	if(name == 'email'){
	      		val = val.replace(/%40/g,"@");
		      }
		      if(name == 'gender' || name == 'nationalify'){
			  
		    	  $("#addPopups select[name='"+name+"']").find("option").each(function(){
						if($(this).val() ==  val){
							//alert(val);
								$(this).prop("selected","selected");
							}
			   		});
			 
			  }else{
		      	$("#addPopups span").find("input[name='"+name+"']").val(val);
			  }
		});
		

	});

	
	//deail
	$(document).on('click','table#add_uest_info_table .detail',function(){

		var p_no = $(this).parent().parent().find("td").eq(5).html();

		var data = $.session.get('membership');
		
		var str = '';	//	存放其他
		var curr_str = ''; //存放当前
		data_ex = data.split('-');
		$.each(data_ex,function(e){
			if(data_ex[e]!=''){
				var val = data_ex[e].split('&');
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
			      	  if(name == 'passport' && val == p_no){
			      			curr_str = data_ex[e];
				      	  }
				});
				
			}
			
			});
		
		//data = data.replace('-'+curr_str+'-', "-");

		//设置session
		//$.session.set("membership", data);

		
		//var data = $.session.get(p_no);

		curr_str.split('&').forEach(function(param){
		  param = param.split('=');
		  var name = param[0],
		      val = param[1];
	      	  if(name == 'birth' || name == 'issue' || name == 'expiry'){
	      		val = val.replace(/%2F/g,"/");
	      		
		      	  }
	      	if(name == 'email'){
	      		val = val.replace(/%40/g,"@");
		      	  }
	      	  if(name == 'gender' || name == 'nationalify'){
	      		val = $("#addPopups select[name='"+name+"'] option[value='"+val+"']").text();
	      		//alert(val);
	      	  }
		      $("#deailPopups span[name='"+name+"']").html(val);
		 
		});

		new PopUps($("#deailPopups"));
	});




	//del
	$("#mainContent_content .btnBox1 input#del_data").click(function(){

		var length = $("table#add_uest_info_table tbody input[type='checkbox']:checked").length;
		if(length == 0 ){
			Alert("Please select delete items");return false;
			}
		if(length > 1){
			Alert("Can only choose a deleted items");return false;
			}
		
		new PopUps($(".prompt"));

	});


	$(document).on('click',".popups .btnBox #query_del",function(){
		var p_no = $("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent().find("td").eq(5).html();

		var data = $.session.get('membership');
		var str = '';	//	存放其他
		var curr_str = ''; //存放当前
		data_ex = data.split('-');
		$.each(data_ex,function(e){
			if(data_ex[e]!=''){
				var val = data_ex[e].split('&');
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
			      	  if(name == 'passport' && val == p_no){
			      			curr_str = data_ex[e];
				      	  }
				});
				
			}
			
			});
		//alert(curr_str);
		data = data.replace(curr_str+'-', "");
		//alert(data);
		//设置session
		$.session.set("membership", data);

		//$.session.remove(p_no);
		$("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent().remove();

		$(".shadow").hide();
        $(".popups").hide();
	});


	//next
	$("#add_uest_info_next_but").on('click',function(){
		var length = $("table#add_uest_info_table tbody").find("tr").length;
		if(length>0){
			location.href= "<?php echo Url::toRoute(['chooseandreservation','code'=>$code]);?>";
		}else{
			Alert("To add members");
		}
		
	});


	
}

//文本框为空验证
function checkInput(){
var a = 0;
	var data = "Required fields cannot be empty";
	var email_data = "Please fill in the correct email address";
	var phone_data = "Please fill in the correct phone number";
	$("#addPopups .pBox input[type=text]").each(function(e){	//如果文本框为空值			
		if($(this).val()==''){
			$(this).parent().find("em").html(data);
			$(this).parent().find("em").css("visibility","visible");
			a=1;
			return a;
		}
   	}); 
	var email = $("#addPopups .pBox input[type=text][name='email']").val();
	if(!isEmail(email)){
		$("#addPopups .pBox input[type=text][name='email']").parent().find("em").html(email_data);
		$("#addPopups .pBox input[type=text][name='email']").parent().find("em").css("visibility","visible");
		a=1;
		return a;
	}

	var phone = $("#addPopups .pBox input[type=text][name='phone']").val();
	if(!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/i.test(phone))
	{
		$("#addPopups .pBox input[type=text][name='phone']").parent().find("em").html(phone_data);
		$("#addPopups .pBox input[type=text][name='phone']").parent().find("em").css("visibility","visible");
		a=1;
		return a;
	}
	return a;
}

//邮箱验证
function isEmail(str){
	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
	return reg.test(str);
} 

//session验证护照号
function checkSessionPassport(passport){
	var a = 0;
	var data = $.session.get('membership');
	if(data != undefined){
		data_ex = data.split('-');
		$.each(data_ex,function(e){
			if(data_ex[e]!=''){
				var val = data_ex[e].split('&');
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
			      	  if(name == 'passport' && val == passport){
			      			a=1;
				      }
				});
			}
		});
	}

	return a;
}


//session验证 full_name+gender+birth
function checkSessionNameSexBirth(full_name,gender,birth){
	var a = 0;
	var data = $.session.get('membership');
	
	if(data != undefined){
		var str = '';	//	存放其他
		var curr_str = ''; //存放当前
		data_ex = data.split('-');
		$.each(data_ex,function(e){
			var s_full_name = 0;
			var s_gender = 0;
			var s_birth = 0;
			if(data_ex[e]!=''){
				var val = data_ex[e].split('&');
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
					  if(name == 'full_name' && val == full_name){
				    	  s_full_name = 1;
				      }
				      if(name == 'gender' && val == gender){
				    	  s_gender = 1;
					  }
					  if(name == 'birth' && val == birth){
						  s_birth = 1;
					  }
				});
				
			}
			if(s_full_name == 1 && s_gender == 1 && s_birth == 1){a=1;return false;}
			
		});
	}
	return a;
	
}

//护照验证
function checkPassPort(passport){
	var a =0;
	$.ajax({
        url:"<?php echo Url::toRoute(['passportcheckmembership']);?>",
        type:'post',
        async:false,
        data:'passport='+passport,
     	dataType:'json',
    	success:function(data){
    		if(data != 0){
    			for (key in field_name){
        			if(key != 'gender' && key != 'nationalify'){
        				if(key == 'birth' || key == 'issue' || key == 'expiry'){
            				var key_value = $("#addPopups input[name='"+key+"']").val();
	        	            if(key_value != createDate(data[field_name[key]])){
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html('');
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","hidden");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","visible");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html(createDate(data[field_name[key]]));
	    						a = 1;//return false;
	    					}
                		}else{
                    		if(key != 'email' && key != 'phone'){
	        				var key_value = $("#addPopups input[name='"+key+"']").val();
	        	            if(key_value != data[field_name[key]]){
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html('');
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","hidden");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","visible");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html(data[field_name[key]]);
	    						a = 1;//return false;
	    					}
                    		}
                		}
        			}else{
        				var key_value = $("#addPopups select[name='"+key+"']").val();
        	            if(key_value != data[field_name[key]]){
        	            	var text = $("#addPopups select[name='"+key+"'] option[value='"+data[field_name[key]]+"']").text();
        	            	$("#addPopups select[name='"+key+"']").parent().find("em").html('');
    						$("#addPopups select[name='"+key+"']").parent().find("em").css("visibility","hidden");
    						$("#addPopups select[name='"+key+"']").parent().find("em").css("visibility","visible");
    						$("#addPopups select[name='"+key+"']").parent().find("em").html(text);
    						a = 1;//return false;
    					}
            		}
    	        }


    	       // $("#addPopups input[name='m_id']").val(data['m_id']);
    		}

    		
        		
    	}      
    });

	return a;
	
}


//全名+性别+生日验证
function checkNameSexBirth(full_name,gender,birth){
var a = 0;
	$.ajax({
        url:"<?php echo Url::toRoute(['namegenderbirthcheckmembership']);?>",
        type:'post',
        data:'full_name='+full_name+'&gender='+gender+'&birth='+birth,
     	dataType:'json',
    	success:function(data){
    		if(data != 0){
    			for (key in field_name){
        			if(key != 'gender' && key != 'nationalify'){
            			if(key == 'birth' || key == 'issue' || key == 'expiry'){
            				var key_value = $("#addPopups input[name='"+key+"']").val();
	        	            if(key_value != createDate(data[field_name[key]])){
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html('');
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","hidden");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","visible");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html(createDate(data[field_name[key]]));
	    						a = 1;//return false;
	    					}
                		}else{
                			if(key != 'email' && key != 'phone'){
	        				var key_value = $("#addPopups input[name='"+key+"']").val();
	        	            if(key_value != data[field_name[key]]){
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html('');
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","hidden");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").css("visibility","visible");
	    						$("#addPopups input[name='"+key+"']").parent().find("em").html(data[field_name[key]]);
	    						a = 1;//return false;
	    					}
                			}
                		}
        			}else{
        				var key_value = $("#addPopups select[name='"+key+"']").val();
        	            if(key_value != data[field_name[key]]){
        	            	var text = $("#addPopups select[name='"+key+"'] option[value='"+data[field_name[key]]+"']").text();
    						$("#addPopups select[name='"+key+"']").parent().find("em").html('');
    						$("#addPopups select[name='"+key+"']").parent().find("em").css("visibility","hidden");
    						$("#addPopups select[name='"+key+"']").parent().find("em").css("visibility","visible");
    						$("#addPopups select[name='"+key+"']").parent().find("em").html(text);
    						a = 1;//return false;
    					}
            		}
    	        }

    			//$("#addPopups input[name='m_id']").val(data['m_id']);
    		}

    		
        		
    	}      
    });
	return a;
}

//判断该乘客是否重复购票
function Check_buy_ticket(passport){
	var a = 0;	
	$.ajax({
	    url:"<?php echo Url::toRoute(['checkrepeatbuyticket']);?>",
	    type:'post',
	    async:false,
	    data:'passport='+passport+'&code='+<?php echo $code;?>,
	 	dataType:'json',
		success:function(data){	
	    	if(data != 0){a=1;}
		}
	});
	return a;
}


//验证护照有效期
function checkPassPortDate(issue,expiry,voyage_code){

	var a=0;
	//护照开始时间和结束时间必须在5-10年内
	issue = createTime(issue);
	expiry = createTime(expiry);
	
	var d1=new Date(issue);
	var d2=new Date(d1);
	d2.setFullYear(d2.getFullYear()+3);
	d2.setDate(d2.getDate()-1);
	var s_min = d2.toLocaleString().split(' ');
	s_min = createTimeSecond(s_min[0]);

	var d3=new Date(issue);
	var d4=new Date(d3);
	d4.setFullYear(d4.getFullYear()+10);
	d4.setDate(d4.getDate()-1);
	var s_max = d4.toLocaleString().split(' ');
	s_max = createTimeSecond(s_max[0]);
	//alert(s_min);alert(expiry);
	
	var d_expiry = Date.parse(new Date(expiry.replace(/-/g, "/")));
	d_expiry = d_expiry / 1000;
	var d_min = Date.parse(new Date(s_min.replace(/-/g, "/")));
	d_min = d_min / 1000;
	var d_max = Date.parse(new Date(s_max.replace(/-/g, "/")));
	d_max = d_max / 1000;
	

	if(!(d_expiry >= d_min && d_expiry <= d_max)){
		a=2;return a;
	}

	$.ajax({
	    url:"<?php echo Url::toRoute(['getpassportdate']);?>",
	    type:'post',
	    async:false,
	    data:'code='+voyage_code,
	 	dataType:'json',
		success:function(data){	
	    	if(data != 0){
				var s_time = data['start_time'].substr(0,10);
				var e_time = data['end_time'].substr(0,10);
				if(!(s_time >= issue && e_time <= expiry)){
					a=1;return a;
					}
		    	
			}
		}
	});

	return a;
	
}

</script>


