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
	<title>代理商编辑</title>
	<meta charset="utf-8">
	<style type="text/css">
		.write p { overflow: hidden; }
		.write label { width: 324px; }
		.write label:first-child { float: left; margin-left: 10%; }
		.write label + label { float: right; margin-right: 20%; }
		.write label span { width: 140px; }
		.shortLabel { margin-right: 84px; }
		#form input.point { outline-color: red; border: 2px solid red; }
		#form span.point { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    	#form span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
	</style>
</head>

		<div class="r content">
			<div class="topNav"><?php echo yii::t('vcos', 'Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('vcos', 'Travel Agent')?></a></div>
			<div class="write">
			<form method="post" id="form">
				<div>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Numbering:')?></span>
							<input type="text" name="travel_agent_code" readonly="true" style="background-color:#F6F6F6"></input>
				
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Grade:')?></span>
							<select name="travel_agent_level" onchange="GetPara();" id="gradevalue">
							<?php foreach ($gradeinfo as $k=>$v):?>
								<option value="<?php echo  $v['travel_agent_higher_level_id']?>"><?php echo  $v['travel_agent_level']?></option>
								<?php endforeach;?>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Sequence:')?></span>
							<input type="text" name="sort_order" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Contract Start Time:')?></span>
							<input  type="text" name="contract_start_time"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" /> 
							<span class="point"  style="display:none" ><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label class="shortLabel">
							<span><?php echo yii::t('vcos', 'Status:')?></span>
							<select name="travel_agent_status">
								<option value="1"><?php echo yii::t('vcos', 'Usable')?></option>
								<option value="0"><?php echo yii::t('vcos', 'Disable')?></option>
							</select>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Contract End Time:')?></span>
							<input type="text" name="contract_end_time"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate"></input>
						<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Agent Name:')?></span>
							<input type="text" name="travel_agent_name" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Account Holder:')?></span>
							<input type="text" name="travel_agent_bank_holder" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label class="shortLabel">
							<span><?php echo yii::t('vcos', 'Agents Type:')?></span>
							<select name="is_online_booking">
								<option value="0"><?php echo yii::t('vcos', 'Normal Agents')?></option>
									<option value="1"><?php echo yii::t('vcos', 'Inside Agents')?></option>
							</select>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Bank:')?></span>
							<input type="text" name="travel_agent_account_bank"  ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Company Phone:')?></span>
							<input type="text" name="travel_agent_phone" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>
							<span class="point"  style="display:none" ><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Bank Account:')?></span>
							<input type="text" name="travel_agent_account" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Fax:')?></span>
							<input type="text" name="travel_agent_fax" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'System Account:')?></span>
							<input type="text" name="travel_agent_admin" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Contacts:')?></span>
							<input type="text" name="travel_agent_contact_name"  ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Account Password:')?></span>
							<input type="password"  autocomplete="off" name="travel_agent_password" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Contact Number:')?></span>
							<input type="text"  name="travel_agent_contact_phone" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>
								<span id="contactvalidate" class="point"  style="display:none"><?php echo yii::t('vcos', 'Contact Number is error')?></span>
								<span class="point"  style="display:none" id="contactvalidate1"><?php echo yii::t('vcos', 'Contact Number  can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Payment Password:')?></span>
							<input type="password"  autocomplete="off" name="pay_password"  ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Zip Code:')?></span>
							<input type="text" name="travel_agent_post_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos', 'Commission:')?></span>
							<input type="text"  name="commission_percent" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" ></input>%
							<span id="commissionvalidate"  style="display:none" class="point"><?php echo yii::t('vcos', 'Commission between 0 and 100..')?></span>
							<span id="commissionvalidate1"  style="display:none" class="point"><?php echo yii::t('vcos', 'Commission can not be empty')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Region:')?></span>
							<select name="country_code" id="country_code" onchange="contrycity();">
							<?php foreach ($contryinfo as $k=>$v):?>
								<option value="<?php echo $v['country_code']?>"><?php echo yii::t('vcos', $v['country_name'])?></option>
								<?php endforeach;?>
							</select>
							<?php 
							$ccode=$contryinfo[0]['country_code'];
							$sql="select * from v_c_city where country_code='$ccode'";
							$cityinfo = Yii::$app->db->createCommand($sql)->queryAll();
							?>
							<select name="city_code" id="city_code">
							<?php if (empty($cityinfo)){?>
							<option value=""></option>
							<?php }else{?>
							<?php foreach ($cityinfo as $k=>$v):?>
								<option value="<?php echo $v['city_code']?>"><?php echo yii::t('vcos', $v['city_name'])?></option>
								<?php endforeach;}?>
							</select>
						</label>
						<label>
							<span><?php echo yii::t('vcos','Superior Agent:')?></span>
							<select name="superior_travel_agent_code" id="superior">
								<option value=''></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos','Address:')?></span>
							<input type="text" name="travel_agent_address" ></input>
							<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('vcos','Email:')?></span>
							<input type="text"  name="travel_agent_email" ></input>
								<span class="point"  style="display:none" id="emailvalidate"><?php echo yii::t('vcos','Email format is not correct')?></span>
								<span class="point"  style="display:none" id="emailvalidate1"><?php echo yii::t('vcos','Email can not be empty')?></span>
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="submit" value="<?php echo yii::t('vcos','SAVE')?>"></input>
				    <input type="button" id="redictagent" value="<?php echo yii::t('vcos','CANCLE')?>"></input>
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
			
			// $("#contactvalidate").css("display","none");
			
			     
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
			 $("input[type=text]").each(function(){
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
	 				var t=0;
		 			var p=0;
		 			 $("input[type=text]").each(function(index){	//如果文本框为空值			
							if($(this).val()==''&&index!=0){
								$(this).next().css("display","");
								$(this).addClass("point");
								t=1;
								}
				       			}); 
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
			    });
	    	 function GetPara() { //父级代理商
	             var sortid = $('#gradevalue').val();  
	          
	             $.ajax({  
	                 url: '<?php echo Url::toRoute(['travel_grade']);?>'+'&sortid=' + sortid,  
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
	                 $("#superior").empty(); 
	                 $.each(json, function (index, item) { 
		             if(json[index]=="no"){
		            	 $("#superior").append($("<option/>").text(json[index]).attr("value",''));
			             }
		             else{
	                	 $("#superior").append($("<option/>").text(json[index].travel_agent_name).attr("value",json[index].travel_agent_code));
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
