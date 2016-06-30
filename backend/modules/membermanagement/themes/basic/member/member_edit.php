


<style type="text/css">

		#issueTicket_info .form { padding: 1em; border: 1px solid #e0e9f4; background: #fff; }
		#issueTicket_info label span { display: inline-block; width: 100px; text-align: right; }
		#issueTicket_info select { width: 184px; height: 24px; }
		#issueTicket_info .lineSelect select { width: 478px; }
		#issueTicket_info .table { width: 48%; margin-bottom: 1em; }
		#issueTicket_info .btn { margin-top: 1em; }
		#memberInfo label span { width: 140px; }
	</style>


<?php
$this->title = 'Add Membership';


use app\modules\membermanagement\themes\basic\myasset\ThemeAsset;

use yii\helpers\Url;

ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';


//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>

 <script type="text/javascript" src="<?php echo $baseUrl;?>js/jquery-ui.min.js"></script>

 <script type="text/javascript" src="<?php echo $baseUrl;?>js/jquery.validate.js"></script>

 <script type="text/javascript" src="<?php echo $baseUrl;?>js/My97DatePicker/WdatePicker.js"></script>

<style>
	#member_edit_form input.point { outline-color: red; border: 2px solid red; }
	#member_edit_form label.error { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #member_edit_form label.error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
</style>

	<script type="text/javascript">
	$(document).ready(function() {
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



		
	});
		
	</script>

<!-- content start -->
<div id="country" style="display: none;"><?php echo $member['country_code']?></div>

<div id="vipgrade" style="display: none;"><?php echo $member['vip_grade']?></div>

<div id="gender_sex" style="display: none;"><?php echo $member['gender']?></div>

<div id="passport_country" style="display: none;"><?php echo $passport_country['country_code'];?></div>


<div id="m_id" style="display: none;"><?php echo $member['m_id']?></div>



		<div class="r content" id="issueTicket_info">
	<div class="topNav"><?= \Yii::t('app', 'Membership Manage') ?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?= \Yii::t('app', 'Membership') ?></a></div>
		<form  method="post" id="member_edit_form" onkeydown="if(event.keyCode==13)return false;">
			<div id="memberInfo">
				<h3>Booking person</h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'ID Card') ?>:</span>
							<input type="text" value="<?php
							echo $member['resident_id_card'];
							?>"  name="resident_id_card"  id="resident_id_card" ></input>
						</label>
					

						
						<label>
							<span><?= \Yii::t('app', 'MemeberCard No.') ?>:</span>
							<input type="text" value="<?php
							echo $member['smart_card_number'];
							?>" name="smart_card_number" id="smart_card_number" ></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Membership Grade') ?>:</span>
							<select name="vip_grade" id="vip_grade">
							    <option  value="0" <?php echo $member['vip_grade']==0?"selected='selected'":''?>>0</option>
								<option value="1" <?php echo $member['vip_grade']==1?"selected='selected'":''?>>1</option>
								<option value="2" <?php echo $member['vip_grade']==2?"selected='selected'":''?>>2</option>
								<option value="3" <?php echo $member['vip_grade']==3?"selected='selected'":''?>>3</option>
								
							</select>
						</label>
					</p>
					<p>
							<label>
							<span><?= \Yii::t('app', 'Memeber Code') ?>:</span>
							<input readonly="true" style="background-color:#E5E5E5;border:#B9B9B9 1px solid" type="text" name="m_code" id="m_code" value="<?php
							echo $member['m_code'];
							?>" ></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Country') ?>:</span>
							<select name="country_code" id="country_code">
								<?php  

                            foreach ($country as $row) {

							?>

							<!-- 国家编号 -->

							<!-- 国家名字 -->
								<option value="<?php echo $row['country_code']; ?>" <?php echo $member['country_code']==$row['country_code']?"selected='selected'":'' ?>><?php echo $row['country_name']; ?></option>
							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Membership Status') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'inactive') ?></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Chinese Name') ?>:</span>
							<input type="text" name="m_name" value="<?php
							echo $member['m_name'];
							?>" id="m_name"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Nation') ?>:</span>
							<select >
								<option><?= \Yii::t('app', 'The han nationality') ?> </option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Balance') ?>:</span>
							<input type="text" name="balance" value="<?php
							echo $member['balance'];
							?>" id="balance"></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'First Name') ?>:</span>
							<input type="text" name="first_name"value="<?php
							echo $member['first_name'];
							?>" id="first_name"></input>	
						</label>
						<label>
							<span><?= \Yii::t('app', 'Landline Telephone') ?>:</span>
							<input type="text" name="fixed_telephone" value="<?php
							echo $member['fixed_telephone'];
							?>" id="fixed_telephone"></input>
						</label>
						<!-- <label class="error" id="mylinephone">手机格式不正确</label> -->
						<label>
							<span><?= \Yii::t('app', 'Integral') ?>:</span>
							<!-- 积分 -->
							<input type="text" name="points" value="<?php
							echo $member['points'];
							?>" id="points" ></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Last Name') ?>:</span>
							<input type="text" name="last_name"value="<?php
							echo $member['last_name'];
							?>" id="last_name"></input>

						
						</label>
						<label>
							<span><?= \Yii::t('app', 'Phone No.') ?>:</span>
							<input type="text" name="mobile_number" value="<?php
							echo $member['mobile_number'];
							?>" id="mobile_number"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verify Phone No.') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'ID Card') ?><?= \Yii::t('app', 'No validation') ?> </option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthday') ?>:</span>

							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($member['birthday']));
							?>"  name="birthday" id="birthday"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'E-mail') ?>:</span>
							<input type="email" style="width: 184px;height:24px" name="email" value="<?php
							echo $member['email'];
							?>" id="email"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verity E-mail') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'No validation') ?> </option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Gender') ?>:</span>
							<select name="gender" id="gender">
								<option value="M" <?php echo $member['gender']=='M'?"selected='selected'":'' ?>>M</option>
								<option value="F" <?php echo $member['gender']=='F'?"selected='selected'":'' ?>>F</option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Login Name') ?>:</span>
							<input type="text" disabled="disabled"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Registration IP') ?>:</span>
							<input type="text" disabled="disabled"></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthplace') ?>:</span>
							<input type="text" name="birth_place" value="<?php
							echo $member['birth_place'];
							?>" id="birth_place"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Password') ?>:</span>
							<input type="password" style="width: 184px;height:24px" name="m_password" value="<?php
							echo $member['m_password'];
							?>" id="m_password"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Registration Date') ?>:</span>
							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss',lang:'en'})" class="Wdate" value="<?php
							echo date('d/m/Y H:i:s',strtotime($member['create_time']));?>"
							 name="create_time" id="create_time"></input>
						</label>
					</p>
				</div>
				<h3><?= \Yii::t('app', 'Passport') ?></h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'Passport No') ?>:</span>
							<input type="text" name="passport_number" value="<?php
							echo $member['passport_number'];
							?>" id="passport_number">
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issuing Country') ?>:</span>
							<select name="post_country_code" id="post_country_code">
							<?php  

                            foreach ($country as $row) {
                            
                            

							?>
      
								<option value="<?php echo $row['country_code']; ?>" <?php echo $member['passport_country_code']==$row['country_code']?"selected='selected'":''?>><?php echo $row['country_name']; ?></option>

							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issue Place') ?>:</span>
							<input type="text" name="place_issue" value="<?php
							echo $member['place_issue'];?>" id="place_issue" >
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Issue Date') ?>:</span>


							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($member['date_issue']));?>" name="date_issue" >
						</label>
						<label>
							<span><?= \Yii::t('app', 'Closing Date') ?>:</span>

							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($member['date_expire']));?>"   name="date_expire" >
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="button" value="Save" id="member_edit_save" style="width: 80px;text-align: center;cursor:pointer;">
					<input type="submit" value="Back" id="back" >

					

					
				</div>
			</div>
			</form>

		
		</div>
		<!-- content end -->


	
		<script type="text/javascript">
		$(document).ready(function($) {
			 $("input[type=text]").each(function(){
					$(this).focus(function(){
						 $(this).next().css("display","none");
						
						});
					 });/* 聚焦 */
					/*  $("#mylinephone").css("display","none");
					 $("input[name=fixed_telephone]").blur(function(){//电话号码判断
						 var regp= new RegExp("^[1][358][0-9]{9}$");//电话号码验证
		 				 var fixed_telephone= $("input[name=fixed_telephone]").val();//电话号码验证
		 				if(!regp.test(fixed_telephone)){
		 					 $("#mylinephone").css("display","");
		 					$(this).addClass("mypoint");
			 				 }				
						 }).focus(function(){
							 $("#mylinephone").css("display","none");
							 $(this).removeClass("mypoint");
							 });
					 $("#member_edit_save").click(function(){
					
						  var regp= new RegExp("^[1][358][0-9]{9}$");//电话号码验证
		 				 var fixed_telephone= $("input[name=fixed_telephone]").val();//电话号码验证
		 				if(!regp.test(fixed_telephone)){
		 					 $("#mylinephone").css("display","");
		 					$(this).addClass("mypoint");
			 				 }				
							if($("input[name=fixed_telephone]").prop("class")=="mypoint"){
								$(this).type("button");
								}
							else{
								$(this).type("submit");
								} 
						 }); */
			 jQuery.validator.addMethod("shuzi", function(value, element) {
	       return this.optional(element) || /^[0-9]*$/.test(value);
             }, "please input number");


  jQuery.validator.addMethod("fixnumber", function(value, element) {
	return this.optional(element) || /^[1][358][0-9]{9}$/.test(value);
}, "the phone is error"); 

  //手机号码
  jQuery.validator.addMethod("mobile", function(value, element) {
 
		return this.optional(element) || /^((\+?86)|(\(\+86\)))?(13[012356789][0-9]{8}|15[012356789][0-9]{8}|18[02356789][0-9]{8}|147[0-9]{8}|1349[0-9]{7})$/.test(value);
	}, "A positive or negative non-decimal number please");


  jQuery.validator.addMethod("emailsame", function(value, element) {
  	   var flag=1;
         $.ajax({
            type: "post",
            url: "<?= Url::to(['member/member_email_validate']);?>", 
            async:false,  
            data: {'email':$.trim($('#email').val()),'id':$.trim($('#m_id').text())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    flag=0;
                  }
                
            },
            error: function(data) {
                alert('Request error ');
             return false;
            }
        });

         if(flag==0)
         {
         	return false;
         }
         else {
         	return true;
         }



  
 }, " email  have been exist");



    jQuery.validator.addMethod("mobliesame", function(value, element) {
         var flag=1;
         $.ajax({
            type: "post",
            url: "<?= Url::to(['member/member_mobile_validate']);?>",
            async:false,      
            data: {'mobile_number':$.trim($('#mobile_number').val()),
                 'id':$.trim($('#m_id').text())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    flag=0;
                  }
               	 
             
            },
            error: function(data) {
                alert('Request error ');
             return false;


            }
        });


         if(flag==0)
         {
         	return false;
         }
         else {
         	return true;
         }

  
 }, " moblie number have been exist");


        jQuery.validator.addMethod("IDCardsame", function(value, element) {
         var flag=1;
         $.ajax({
            type: "post",
            url: "<?= Url::to(['member/resident_id_card_validate']);?>",
            async:false,      
            data: {'id_card':$.trim($('#resident_id_card').val()),
                 'id':$.trim($('#m_id').text())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    flag=0;
                  }
               	 
             
            },
            error: function(data) {
                alert('Request error ');
             return false;


            }
        });


         if(flag==0)
         {
         	return false;
         }
         else {
         	return true;
         }

  
 }, " Id Card have been exist");


            //passport_number 护照编号   ajax验证
    jQuery.validator.addMethod("passport_numbernsame", function(value, element) {
         var flag=1;
         $.ajax({
            type: "post",
            url: "<?= Url::to(['member/passport_number_validate']);?>",
            async:false,      
            data: {'passport_number':$.trim($('#passport_number').val()),
                 'id':$.trim($('#m_id').text())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    flag=0;
                  }
               	 
             
            },
            error: function(data) {
                alert('Request error ');
             return false;


            }
        });


         if(flag==0)
         {
         	return false;
         }
         else {
         	return true;
         }

  
 }, " Passport No: have been exist");



            //smart_card_number  会员卡号  ajax验证

    jQuery.validator.addMethod("smart_card_number_same", function(value, element) {
         var flag=1;
         $.ajax({
            type: "post",
            url: "<?= Url::to(['member/member_card_validate']);?>",
            async:false,      
            data: {'smart_card_number':$.trim($('#smart_card_number').val()),
                 'id':$.trim($('#m_id').text())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    flag=0;
                  }
               	 
             
            },
            error: function(data) {
                alert('Request error ');
             return false;


            }
        });


         if(flag==0)
         {
         	return false;
         }
         else {
         	return true;
         }

  
 }, " MemeberCard No  have been exist");

               //Memeber Code  会员编号  ajax验证

    jQuery.validator.addMethod("m_codesame", function(value, element) {
         var flag=1;
         $.ajax({
            type: "post",
            url: "<?= Url::to(['member/member_code_validate']);?>",
            async:false,      
            data: {'m_code':$.trim($('#m_code').val()),
                 'id':$.trim($('#m_id').text())},    
            success: function(data) {
            	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
            	  if(data=='yes')
            	  {
                    flag=0;
                  }
               	 
             
            },
            error: function(data) {
                alert('Request error ');
             return false;


            }
        });


         if(flag==0)
         {
         	return false;
         }
         else {
         	return true;
         }

  
 }, " Memeber Code  have been exist");







  

		$("#member_edit_form").validate({
		   rules: {
            resident_id_card:{required:true},
            smart_card_number:{required:true},
		   	vip_grade: { required : true},
		   m_code:{required:true,m_codesame:true},
		    country_code: { required : true},
		   	m_name: { required : true},
            balance:{required:true,digits:true},
		   	first_name: { required : true},
		   	fixed_telephone: { required : true,fixnumber:true},
		   	points: { required : true,digits:true},
		   	last_name: { required : true},
		   	mobile_number: { required : true},
		   	birthday: { required : true},			
            email:{required:true,email:true,emailsame:true},
	        gender: { required : true},
		    birth_place: { required : true},
			create_time: { required : true},
			passport_number: { required : true,passport_numbernsame:true},
			m_password: { required : true,rangelength:[6,30]},
			date_expire: { required : true},
			date_issue: { required : true},
			place_issue: { required : true},
			post_country_code: { required : true},
			
		  },
		messages: {
			resident_id_card:{required:'ID card can not be empty '},
			smart_card_number:{required:'smart_card_number can not be empty'},
            vip_grade: { required : 'Please Select Membership Grade'},
            m_code:{required:'m_code can not be empty'},
		    country_code: { required : 'Please Select Country'},
		   	m_name: { required : 'Chinese Name can not be empty'},
		   	balance:{required:'Balance can not be empty',digits:'balance Only fill in the integer '},
		   	first_name: { /* required : 'first_name不能为空' */},
		   	fixed_telephone: {/*  required : 'Landline Telephone不能为空',
			   	fixnumber:'Landline Telephone格式不对' */


			   	},
		   	points: { required : 'Integral can not be empty',digits:'Integral Only fill in the integer '},
		   	last_name: { required : 'last_name can not be empty'},
		   	mobile_number: { required : 'mobile_number can not be empty',mobile:'mobile_number Format is wrong '},
		   	birthday: { required : 'birthday can not be empty'},			
            email:{required:'email can not be empty',email:"E-mail Format is wrong " },
	         gender: { required : 'Please Select Sex'},
		    birth_place: { required : 'birth_place can not be empty'},
			create_time: { required : 'create_time can not be empty'},
			passport_number: { required : 'passport_number can not be empty'},
			m_password: { required : 'password can not be empty',rangelength:'Password length of 6-30 '},
			date_expire: { required : 'date_expire can not be empty'},
			date_issue: { required : 'date_issue can not be empty'},
			place_issue: { required : 'place_issue can not be empty'},
			post_country_code: { required : '请选择post_country_code'},
		
		
			
		},


		
           //  submitHandler:function(form)
           //   { 

           //   	 $.ajax({
	          //   type: "post",
	          //   url: "<= Url::to(['member/passport_number_validate']);?>",
	               
	          //   data: {'passport_number':$.trim($('#passport_number').val()),
	          //        'id':$.trim($('#m_id').text())},    
	          //   success: function(data) {
	          //   	 // var jsonObj = eval("("+data+")");  将json字符串转为json对象
	          //   	  if(data=='yes')
	          //   	  {
	          //           alert("Passport No: have been exist");
	          //         }
	          //         else {
	          //         	form.submit();
	          //         }
	               	 
	             
	          //   },
	          //   error: function(data) {
	          //     alert('请求错误');
	          //    return false;
	          //   }
	          // });

           //     },




        
         


	 });



		$('#member_edit_save').click(function(event) {

			
			var url="<?= Url::to(['member/member_edit_save']);?>"+'&id='+$.trim($('#m_id').text());

			
        	      	
			$('#member_edit_form').attr('action', url);
			$('#member_edit_form').submit();
			return false;

			
		});


					$('#back').click(function(event) {

	var url="<?= Url::to(['member/index']);?>";	
    location.href=url;
    return false;
				



			});
		

			
		});



		</script>





