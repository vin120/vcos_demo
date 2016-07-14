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
			<?php if(!empty($uset_info_result)){
			foreach ($uset_info_result as $row){
			?>
				<tr>
					<td><input type="checkbox" value=""></input></td>
					<td><?php echo $row['last_name']?></td>
					<td><?php echo $row['first_name']?></td>
					<td><?php echo $row['gender']?></td>
					<td><?php echo $row['birth']?></td>
					<td><?php echo $row['passport']?></td>
					<td><?php echo $row['issue']?></td>
					<td><?php echo $row['expiry']?></td>
					<td><button class='btn1 detail'><img src='<?=$baseUrl ?>images/text.png'></button></td>
				</tr>
			<?php }}?>
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
		var p_no = $("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent().find("td").eq(5).html();
		
		var act = $("#addPopups h3 > span").html();
		var passport = $("#addPopups input[name='passport']").val();
		var full_name = $("#addPopups input[name='full_name']").val();
		var last_name = $("#addPopups input[name='last_name']").val()
		var first_name = $("#addPopups input[name='first_name']").val();
		var gender = $("#addPopups select[name='gender']").val();
		var nationalify = $("#addPopups select[name='nationalify']").val();
		var email = $("#addPopups input[name='email']").val();
		var phone = $("#addPopups input[name='phone']").val();
		var birth = $("#addPopups input[name='birth']").val();
		var birth_place = $("#addPopups input[name='birth_place']").val();
		var issue = $("#addPopups input[name='issue']").val();
		var expiry = $("#addPopups input[name='expiry']").val();

		//封装json
		var json_str = '';
		json_str += '{"passport":"'+passport+'","full_name":"'+full_name+'","last_name":"'+last_name+'",';
		json_str += '"first_name":"'+first_name+'","gender":"'+gender+'","nationalify":"'+nationalify+'","email":"'+email+'",';
		json_str += '"phone":"'+phone+'","birth":"'+birth+'","birth_place":"'+birth_place+'","issue":"'+issue+'","expiry":"'+expiry+'"}';


		//act_op :1:编辑，2：添加
		if(act == 'Edit'){
			var act_op = 1;
		}else{
			var act_op = 2;
		}
		
		$.ajax({
	        url:"<?php echo Url::toRoute(['savesessionadduestinfo']);?>",
	        type:'post',
	        async:false,
	        data:'json_str='+json_str+'&passport='+p_no+'&act_op='+act_op,
	     	dataType:'json',    
	    });

			if(act == 'Add'){
				var str = '';
				str += "<tr>";
				str += '<td><input type="checkbox" value=""></input></td>';
				str += '<td>'+last_name+'</td>';
				str += '<td>'+first_name+'</td>';
				str += '<td>'+gender+'</td>';
				str += '<td>'+birth+'</td>';
				str += '<td>'+passport+'</td>';
				str += '<td>'+issue+'</td>';
				str += '<td>'+expiry+'</td>';
				str += "<td><button class='btn1 detail'><img src='<?=$baseUrl ?>images/text.png'></button></td>";
				str += "</tr>";

				Alert("Add a success");
	            $("table#add_uest_info_table > tbody").append(str);

			}else if(act == 'Edit'){

				var tr  = $("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent();
				tr.find("td").eq(1).html(last_name);
				tr.find("td").eq(2).html(first_name);
				tr.find("td").eq(3).html(gender);
				tr.find("td").eq(4).html(birth);
				tr.find("td").eq(5).html(passport);
				tr.find("td").eq(6).html(issue);
				tr.find("td").eq(7).html(expiry);

				
				Alert("Modify the success");
			}
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

		//获取需编辑的乘客sesseion信息
		$.ajax({
	        url:"<?php echo Url::toRoute(['getsessionpersoninfo']);?>",
	        type:'get',
	        async:false,
	        data:'passport='+p_no,
	     	dataType:'json',    
	     	success:function(data){
				if(data!=0){
					$("#addPopups span").find("input[name='passport']").val(data['passport']);
					$("#addPopups span").find("input[name='full_name']").val(data['full_name']);
					$("#addPopups span").find("input[name='last_name']").val(data['last_name']);
					$("#addPopups span").find("input[name='first_name']").val(data['first_name']);
					$("#addPopups select[name='gender']").find("option[value='"+data['gender']+"']").prop('checked','checked');
					$("#addPopups select[name='nationalify']").find("option[value='"+data['nationalify']+"']").prop('checked','checked');
					$("#addPopups span").find("input[name='email']").val(data['email']);
					$("#addPopups span").find("input[name='phone']").val(data['phone']);
					$("#addPopups span").find("input[name='birth']").val(data['birth']);
					$("#addPopups span").find("input[name='birth_place']").val(data['birth_place']);
					$("#addPopups span").find("input[name='issue']").val(data['issue']);
					$("#addPopups span").find("input[name='expiry']").val(data['expiry']);
				}
		    }
	    });
	
	});

	
	//deail
	$(document).on('click','table#add_uest_info_table .detail',function(){

		var p_no = $(this).parent().parent().find("td").eq(5).html();

		$.ajax({
	        url:"<?php echo Url::toRoute(['getsessionpersoninfo']);?>",
	        type:'get',
	        async:false,
	        data:'passport='+p_no,
	     	dataType:'json',    
	     	success:function(data){
				if(data!=0){
					$("#deailPopups span[name='passport']").html(data['passport']);
					$("#deailPopups span[name='full_name']").html(data['full_name']);
					$("#deailPopups span[name='last_name']").html(data['last_name']);
					$("#deailPopups span[name='first_name']").html(data['first_name']);
					var val = $("#addPopups select[name='gender'] option[value='"+data['gender']+"']").text();
					$("#deailPopups span[name='gender']").html(val);
					var val = $("#addPopups select[name='nationalify'] option[value='"+data['nationalify']+"']").text();
					$("#deailPopups span[name='nationalify']").html(val);
					$("#deailPopups span[name='email']").html(data['email']);
					$("#deailPopups span[name='phone']").html(data['phone']);
					$("#deailPopups span[name='birth']").html(data['birth']);
					$("#deailPopups span[name='birth_place']").html(data['birth_place']);
					$("#deailPopups span[name='issue']").html(data['issue']);
					$("#deailPopups span[name='expiry']").html(data['expiry']);
				
				}
		    }
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
	
		$.ajax({
	        url:"<?php echo Url::toRoute(['delsessionpersoninfo']);?>",
	        type:'get',
	        async:false,
	        data:'passport='+p_no,
	     	dataType:'json',    
	     	success:function(data){
				if(data == 1){
					$("table#add_uest_info_table tbody input[type='checkbox']:checked").parent().parent().remove();

					$(".shadow").hide();
			        $(".popups").hide();
					
				}
		     	
	     	}
		});

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
	$.ajax({
        url:"<?php echo Url::toRoute(['checksessionpassport']);?>",
        type:'get',
        async:false,
        data:'passport='+passport,
     	dataType:'json',   
     	success:function(data){
     		if(data == 0){
     			a=1;
         	}
        } 
    });
    
	return a;
}


//session验证 full_name+gender+birth
function checkSessionNameSexBirth(full_name,gender,birth){
	var a = 0;
	$.ajax({
        url:"<?php echo Url::toRoute(['checksessionnamegenderbirth']);?>",
        type:'post',
        async:false,
        data:'full_name='+full_name+'&gender='+gender+'&birth='+birth,
     	dataType:'json',
    	success:function(data){
			if(data == 0){
				a = 1;
				}
        	
        }
	});

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


