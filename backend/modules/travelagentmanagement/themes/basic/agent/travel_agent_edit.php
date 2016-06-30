<?php
$this->title = 'Travelagent Management';


use app\modules\travelagentmanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.2.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl?>js/My97DatePicker/WdatePicker.js"></script>
<head>
	<title><?php echo yii::t('app', '代理商编辑')?></title>
	<meta charset="utf-8">
	<style type="text/css">
		.write p { overflow: hidden; }
		.write label { width: 324px; }
		.write label:first-child { float: left; margin-left: 10%; }
		.write label + label { float: right; margin-right: 20%; }
		.write label span { width: 140px; }
		#form input.point { outline-color: red; border: 2px solid red; }
		#form span.point { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    	#form span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
	 	#form .selectWidth { width: 164px; }
	</style>
</head>

		<div class="r content">
			<div class="topNav"><?php echo yii::t('app', 'Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app', 'Travel Agent')?></a></div>
			<div class="write">
			<form method="post" id="form">
			<input name="agid" type="hidden" value="<?php echo isset($_GET['id'])?$_GET['id']:0?>">
				<div>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Numbering')?>:</span>
							<input type="text" name="travel_agent_code" style="background-color:#E5E5E5;border:#B9B9B9 1px solid" readonly="true" value="<?php echo  $ageninfo[0]['travel_agent_code']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Grade')?>:</span>
							<select name="travel_agent_level" onchange="GetPara();" id="gradevalue" class="selectWidth statuscheck1">
							<?php foreach ($gradeinfo as $k=>$v):?>
								<option value="<?php echo  $v['id']?>" <?php echo $v['id']==$ageninfo[0]['travel_agent_level']?"selected='selected'":''?>><?php echo $v['travel_agent_level']?></option>
								<?php endforeach;?>
							</select>
						
						</label>
						
					</p>
					<p>
						<label>
						
							<span><?php echo yii::t('app', 'Sequence')?>:</span>
							<input type="text" name="sort_order" value="<?php echo  $ageninfo[0]['sort_order']?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Contract Start Time')?>:</span>
							<input type="text" onfocus="WdatePicker({dateFmt:'dd-MM-yyyy HH:mm:ss'})"  class="Wdate" name="contract_start_time"   value="<?php 	echo date("d/m/Y H:i:s",strtotime($ageninfo[0]['contract_start_time']));?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app','Status')?>:</span>
							<select name="travel_agent_status" class="selectWidth statuscheck">
								<option value="1" <?php echo $ageninfo[0]['travel_agent_status']==1?"selected='selected'":''?>><?php echo yii::t('app', 'Avaliable')?></option>
								<option value="0" <?php echo $ageninfo[0]['travel_agent_status']==0?"selected='selected'":''?>><?php echo yii::t('app', 'Unavaliable')?></option>
							</select>
							<span id="parantstatus" class="point"  style="display:none"  style="display:none"><?php echo yii::t('app','Superior Agent is Unavaliable,the child must be Unavaliable')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Contract End Time')?>:</span>
							<input type="text" onfocus="WdatePicker({dateFmt:'dd-MM-yyyy HH:mm:ss'})" class="Wdate" name="contract_end_time" value="<?php echo date("d/m/Y H:i:s",strtotime($ageninfo[0]['contract_end_time'])); ?>"></input>
						<span class="point"  style="display:none"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						<span id="contract_end_time1"  style="display:none" class="point"><?php echo yii::t('app', 'Start is not greater than End')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app','Agent Name')?>:</span>
							<input type="text" name="travel_agent_name" value="<?php echo $ageninfo[0]['travel_agent_name']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Account Holder')?>:</span>
							<input type="text" name="travel_agent_bank_holder" value="<?php echo $ageninfo[0]['travel_agent_bank_holder']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Agents Type')?>:</span>
							<select name="is_online_booking" class="selectWidth">
								<option value="0" <?php echo $ageninfo[0]['is_online_booking']==0?"selected='selected'":''?>><?php echo yii::t('app', 'Normal Agents')?></option>
									<option value="1"  <?php echo $ageninfo[0]['is_online_booking']==1?"selected='selected'":''?>><?php echo yii::t('app', 'Inside Agents')?></option>
							</select>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Bank')?>:</span>
							<input type="text" name="travel_agent_account_bank" value="<?php echo  $ageninfo[0]['travel_agent_account_bank']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Company Phone')?>:</span>
							<input type="text" name="travel_agent_phone" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo  $ageninfo[0]['travel_agent_phone']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Bank Account')?>:</span>
							<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="travel_agent_account" value="<?php echo $ageninfo[0]['travel_agent_account']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Fax')?>:</span>
							<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" id="travel_agent_fax" name="travel_agent_fax" value="<?php echo  $ageninfo[0]['travel_agent_fax']?>"></input>
						<span class="point"  style="display:none" ><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'System Account')?>:</span>
							<input type="text"  name="travel_agent_admin" value="<?php echo  $ageninfo[0]['travel_agent_admin']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
							<span class="point"  style="display:none" id="systemcount"><?php echo yii::t('app', 'System Account  already exists ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Contacts')?>:</span>
							<input type="text" name="travel_agent_contact_name"  value="<?php echo  $ageninfo[0]['travel_agent_contact_name']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						
						<label>
							<span><?php echo yii::t('app', 'Commission')?>:</span>
							<input type="text" name="commission_percent" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo $ageninfo[0]['commission_percent']?>"></input>%
							<span id="commissionvalidate"  style="display:none" class="point"><?php echo yii::t('app', 'Commission between 0 and 100..')?></span>
							<span id="commissionvalidate1" style="display:none"  class="point"><?php echo yii::t('app', 'Commission can not be empty')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Contact Number')?>:</span>
							<input type="text" name="travel_agent_contact_phone" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  value="<?php echo  $ageninfo[0]['travel_agent_contact_phone']?>"></input>
						<span id="contactvalidate"  style="display:none" class="point"><?php echo yii::t('app', 'Contact Number is error')?></span>
						<span class="point"  style="display:none" id="contactvalidate1"><?php echo yii::t('app', 'Contact Number  can not be empty ')?></span>
						</label>
					
						<label>
							<span><?php echo yii::t('app', 'Superior Agent')?>:</span>
							<select name="superior_travel_agent_code" id="superior" class="selectWidth statuscheck">
							<?php if (!empty($superinfo)){?>
						<?php foreach ($superinfo as $k=>$v):?>
							<option value="<?php echo $v['travel_agent_id']?>"><?php echo $v['travel_agent_name']?></option>
							<?php endforeach;?>
							<?php }else{?>
							<option value=""><?php echo yii::t('app', 'no')?></option>
							<?php }?>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Zip Code')?>:</span>
							<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="travel_agent_post_code" value="<?php echo  $ageninfo[0]['travel_agent_post_code']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Account Password')?>:</span>
							<input type="password" name="travel_agent_password" value="<?php echo  $ageninfo[0]['travel_agent_password']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Region')?>:</span>
							<select name="country_code" id="country_code" onchange="contrycity();">
							<?php foreach ($contryinfo as $k=>$v):?>
								<option value="<?php echo $v['country_code']?>" <?php echo $v['country_code']==$ageninfo[0]['country_code']?"selected='selected'":''?>><?php echo  $v['country_name']?></option>
								<?php endforeach;?>
							</select>
							<select name="city_code" id="city_code">
							
							<?php foreach ($cityinfo as $k=>$v):?>
								<option value="<?php echo $v['city_code']?>" <?php echo $v['city_code']==$ageninfo[0]['city_code']?"selected='selected'":''?>><?php echo  $v['city_name']?></option>
							<?php endforeach;?>
							</select>
						</label>
							<label>
							<span><?php echo yii::t('app', 'Payment Password')?>:</span>
							<input type="password" name="pay_password" value="<?php echo  $ageninfo[0]['pay_password']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Address')?>:</span>
							<input type="text" name="travel_agent_address" value="<?php echo  $ageninfo[0]['travel_agent_address']?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('app','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Email')?>:</span>
							<input type="text" name="travel_agent_email" value="<?php echo $ageninfo[0]['travel_agent_email']?>"></input>
							<span class="point"  style="display:none" id="emailvalidate"><?php echo yii::t('app','Email format is not correct')?></span>
							<span class="point"  style="display:none" id="emailvalidate1"><?php echo yii::t('app','Email can not be empty')?></span>
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="submit" id="submit" style="cursor:pointer;" value="<?php echo yii::t('app', 'SAVE')?>"></input>
					<input type="button" id="redictagent" value="<?php echo yii::t('app', 'CANCLE')?>"></input>
				</div>
				</form>
			</div>

		</div>
		<script type="text/javascript">
		 $(function(){
			 $("input[type=text]").each(function(){
				 $(this).prop('maxLength', 25);	//控制输入框的最大值
				 });
			 $("input[type=password]").each(function(){
				 $(this).prop('maxLength', 25);	//控制输入框的最大值
				 });

			 $("input[name=travel_agent_admin]").blur(function(){//系统账号查重
				
				// $("#submit").attr("type","submit");
				  var admin_count = $(this).val(); 
				 var agid=$("input[name=agid]").val();
		             $.ajax({  
		                 url: '<?php echo Url::toRoute(['checkadmincount']);?>',
		                 data:{admin_count:admin_count,agid:agid},
		                 type: 'POST',  
		                 dataType: 'json',  
		                 timeout: 3000,  
		                 cache: false,  
		                 beforeSend: LoadFunction, //加载执行方法      
		                 error: erryFunction,  //错误执行方法      
		                 success: succFunction //成功执行方法      
		             })  
		             function LoadFunction() {  
		                 $("#list").html('加载中...');  
		             }  
		             function erryFunction() {  
		                 alert("error");  
		             }  
		             function succFunction(tt) {  
		            	  var json = eval(tt); //数组 
			                 $.each(json, function (index, item) {
				                 if(json[index]==0){
									$("#systemcount").css("display","");
									 $("input[name=travel_agent_admin]").addClass("point");
					                 }
				                 else{
				                	 $("#submit").prop("type","submit");
					                 }
			                 });
						//alert(tt);
		                   
		             }  
				 }).focus(function(){
					 $("#submit").prop("type","button");
					 $("#systemcount").css("display","none");
					 $("#contactvalidate").css("display","none");
					 $("input[name=travel_agent_admin]").removeClass("point");
					 });
			// $("#contactvalidate").css("display","none");
			  
			       $("input[name=contract_end_time]").focus(function(){
							 $("#contract_end_time1").css("display","none");
							 $(this).removeClass("point");
							 });
			 $("input[name=travel_agent_contact_phone]").blur(function(){//电话号码判断
				 var regp= new RegExp("^[1][358][0-9]{9}$");//电话号码验证
 				 var travel_agent_contact_phone= $("input[name=travel_agent_contact_phone]").val();//电话号码验证
 				if((!regp.test(travel_agent_contact_phone))&&(travel_agent_contact_phone!='')){
 					$("#contactvalidate").css("display","");
 					$(this).addClass("point");
	 				 }				
				 }).focus(function(){
					 $("#contactvalidate1").css("display","none");
					 $("#contactvalidate").css("display","none");
					 $(this).removeClass("point");
					 });
			 $("input[name=commission_percent]").blur(function(){//佣金判断
				 var commission= $("input[name=commission_percent]").val();
				 var regcom= new RegExp("^[0-9]*$");
				if((commission<0||commission>100)||(!regcom.test(commission))){//佣金
				$("#commissionvalidate").css("display","");
				$(this).addClass("point");				
					 }
				 }).focus(function(){
					 $("#commissionvalidate").css("display","none");
					 $("#commissionvalidate1").css("display","none");
					 $(this).removeClass("point");
					
					 });
			 $("input[name=travel_agent_email]").blur(function(){//邮箱判断
				 var reg= new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$");
 				 var email= $("input[name=travel_agent_email]").val();//邮箱验证
 				 if((!reg.test(email))&&(email!='')){
 					$("#emailvalidate").css("display","");
 					$(this).addClass("point");
	 				 }
				 }).focus(function(){
					  $("#emailvalidate1").css("display","none");
					 $("#emailvalidate").css("display","none");
					 $(this).removeClass("point");
					 });
			 $("input[type=text]").each(function(){//聚焦是清除
				$(this).focus(function(){
					 $(this).next().css("display","none");
					 $(this).removeClass("point");
					});
				 });
			 $("input[type=password]").each(function(){
					$(this).focus(function(){
						 $(this).next().css("display","none");
						 $(this).removeClass("point");
						});
					 });
		 $("#redictagent").click(function(){
		 window.location = "<?php echo Url::toRoute(['travel_agent']);?>";
		 });
			  //数据校验
				
	 			$("input[type=submit]").click(function(){
		 			if($("#parantstatus").css("display")==''){
						return false;
			 			}
	 				var t=0;
		 			var p=0;
		 			 $("input[type=text]").each(function(){	//如果文本框为空值			
							if($(this).val()==''){
								$(this).next().css("display","");
								$(this).addClass("point");
								t=1;
								}
				       			}); 
		 			 var contract_start_time= $("input[name=contract_start_time]").val();//日期判断
	 				 var contract_end_time= $("input[name=contract_end_time]").val();//日期判断
	 				if(contract_start_time>contract_end_time){
	 					$("#contract_end_time1").css("display","");
	 					$("input[name=contract_end_time]").addClass("point");
	 					t=1;
		 				 }	
		       			if($("input[name=travel_agent_contact_phone]").val()==''){//电话为空时       			
							$("#contactvalidate").css("display","none");
							$("#contactvalidate1").css("display","");
							t=1;
			       			}
		       			if($("input[name=commission_percent]").val()==''){//Commission为空时   			
							$("#commissionvalidate").css("display","none");
							$("#commissionvalidate1").css("display","");
							t=1;
			       			}
		       			if($("input[name=travel_agent_email]").val()==''){//邮箱为空时   			
							$("#emailvalidate").css("display","none");
							$("#emailvalidate1").css("display","");
							t=1;
			       			}
		 			 $("input[type=password]").each(function(){	//如果文本框为空值			
							if($(this).val()==''){
								$(this).next().css("display","");
								$(this).addClass("point");
								t=1;
								}
				       			}); 
		 		if($("select[name=travel_agent_status]").prop("class")=="selectWidth statuscheck point"){//状态判断
					t=1;
			 		}
	    		$("input[type=text]").each(function (index){
					if($(this).prop("class")=="point"){
						t=1;
						}
		    		}); 
	    		$("input[type=password]").each(function (){
					if($(this).prop("class")=="point"){
						p=1;
						}
		    		});   
	    		if(t==1){
	    			return false;
		    		} 
	    		if(p==1){
	    			return false;
		    		}       		
	 	 			});

 	 			/* 页面加载时发送一次验证 */
	 			 $("#parantstatus").css("display","none");
	 			$("select[name=travel_agent_status]").removeClass("point");//初始化
	             var status = $('select[name=travel_agent_status]').val();  
	             var agid = $('select[name=superior_travel_agent_code]').val(); 
	             $.ajax({  
	                 url: '<?php echo Url::toRoute(['agentstatus']);?>',
	                 data:{agent_status:status,code:agid},
	                 type: 'POST',  
	                 dataType: 'json',  
	                 timeout: 3000,  
	                 cache: false,  
	                 beforeSend: LoadFunction, //加载执行方法      
	                 error: erryFunction,  //错误执行方法      
	                 success: succFunction //成功执行方法      
	             })  
	             function LoadFunction() {  
	                 $("#list").html('加载中...');  
	             }  
	             function erryFunction() {  
	                 alert("error");  
	             }  
	             function succFunction(tt) {  
	            	  var json = eval(tt); //数组 
		                 $.each(json, function (index, item) {
			                 if(json[index]==0){
								$("#parantstatus").css("display","");
								$("select[name=travel_agent_status]").addClass("point");
				                 }
		                 });
					//alert(tt);
	                   
	             }  
	 		$(".statuscheck").change(function() { //代理商状态校验
	 			 $("#parantstatus").css("display","none");
	 			$("select[name=travel_agent_status]").removeClass("point");//初始化
	             var status = $('select[name=travel_agent_status]').val();  
	             var agid = $('select[name=superior_travel_agent_code]').val(); 
	             $.ajax({  
	                 url: '<?php echo Url::toRoute(['agentstatus']);?>',
	                 data:{agent_status:status,code:agid},
	                 type: 'POST',  
	                 dataType: 'json',  
	                 timeout: 3000,  
	                 cache: false,  
	                 beforeSend: LoadFunction, //加载执行方法      
	                 error: erryFunction,  //错误执行方法      
	                 success: succFunction //成功执行方法      
	             })  
	             function LoadFunction() {  
	                 $("#list").html('加载中...');  
	             }  
	             function erryFunction() {  
	                 alert("error");  
	             }  
	             function succFunction(tt) {  
	            	  var json = eval(tt); //数组 
		                 $.each(json, function (index, item) {
			                 if(json[index]==0){
								$("#parantstatus").css("display","");
								$("select[name=travel_agent_status]").addClass("point");
				                 }
		                 });
					//alert(tt);
	                   
	             }  
	 		 });
	             $(".statuscheck1").change(function() { //代理商状态校验
		 			 $("#parantstatus").css("display","none");
		 			$("select[name=travel_agent_status]").removeClass("point");//初始化
		             var status = $('select[name=travel_agent_status]').val();  
		             var agid = $('select[name=travel_agent_level]').val(); 
		             $.ajax({  
		                 url: '<?php echo Url::toRoute(['agentstatus1']);?>',
		                 data:{agent_status:status,code:agid},
		                 type: 'POST',  
		                 dataType: 'json',  
		                 timeout: 3000,  
		                 cache: false,  
		                 beforeSend: LoadFunction, //加载执行方法      
		                 error: erryFunction,  //错误执行方法      
		                 success: succFunction //成功执行方法      
		             })  
		             function LoadFunction() {  
		                 $("#list").html('加载中...');  
		             }  
		             function erryFunction() {  
		                 alert("error");  
		             }  
		             function succFunction(tt) {  
		            	  var json = eval(tt); //数组 
			                 $.each(json, function (index, item) {
				                 if(json[index]==0){
									$("#parantstatus").css("display","");
									$("select[name=travel_agent_status]").addClass("point");
					                 }
			                 });
						//alert(tt);
		                   
		             }  
	         });
			    });
	    	 function GetPara() { //父级代理商
		    	 
	             var sortid = $('#gradevalue').val();  
	             var agent_id=$('input[name=agid]').val();
	           
	             $.ajax({  
	                 url: '<?php echo Url::toRoute(['travel_grade']);?>',
	                 type: 'POST', 
	                 data:{sortid:sortid,agent_id:agent_id}, 
	                 dataType: 'json',  
	                 timeout: 3000,  
	                 cache: false,  
	                 beforeSend: LoadFunction, //加载执行方法      
	                 error: erryFunction,  //错误执行方法      
	                 success: succFunction //成功执行方法      
	             })  
	             function LoadFunction() {  
	                 $("#list").html('加载中...');  
	             }  
	             function erryFunction() {  
	                 alert("error");  
	             }  
	             function succFunction(tt) {  

		             
	                 //$("#gradevalue").html('');  
	                 var json = eval(tt); //数组 
	                 $("#superior").empty(); 
	                 $.each(json, function (index, item) { 
		             if(json[index]=="no"){
		            	 $("#superior").append($("<option/>").text(json[index]).attr("value",''));
			             }
		             else{
	                	 $("#superior").append($("<option/>").text(json[index].travel_agent_name).attr("value",json[index].travel_agent_id));
		             }//循环获取数据      
// 	                     var Id = json[index].id;  
// 	                     var Name = json[index].name;  
// 	                     $("#gradevalue").html($("#list").html() + "<br>" + Name + "<input type='text' id='" + Id + "' /><br/>");  
	                 });

	                   
	             }  
	         };  
	  
	     	 function contrycity() { //国家，城市
	             var sortid = $('#country_code').val();  
	             $.ajax({  
	                 url: '<?php echo Url::toRoute(['travel_contrycity']);?>'+'&sortid=' + sortid,
	                 type: 'GET',  
	                 dataType: 'json',  
	                 timeout: 3000,  
	                 cache: false,  
	                 beforeSend: LoadFunction, //加载执行方法      
	                 error: erryFunction,  //错误执行方法      
	                 success: succFunction //成功执行方法      
	             })  
	             function LoadFunction() {  
	                 $("#list").html('加载中...');  
	             }  
	             function erryFunction() {  
	                 alert("error");  
	             }  
	             function succFunction(tt) {  
	                 //$("#gradevalue").html('');  
	                 var json = eval(tt); //数组 
	                 $("#city_code").empty(); 
	                 $.each(json, function (index, item) { 
	                 $("#city_code").append($("<option/>").text(json[index].city_name).attr("value",json[index].city_code));
		           //循环获取数据      
// 	                     var Id = json[index].id;  
// 	                     var Name = json[index].name;  
// 	                     $("#gradevalue").html($("#list").html() + "<br>" + Name + "<input type='text' id='" + Id + "' /><br/>");  
	                 });  
	             }  
	         };
 			
	  

</script>
