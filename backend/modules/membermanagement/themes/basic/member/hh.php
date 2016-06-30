


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

<script type="text/javascript">
	

 	$(function() {
    $( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  });
</script>

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
	<div class="topNav">Route Manage&nbsp;&gt;&gt;&nbsp;<a href="#">Scenic Route</a></div>
		<form  method="post" id="member_edit_form">
			<div id="memberInfo">
				<h3>Booking person</h3>
				<div class="form">
					<p>
						<label>
							<span>ID Card</span>
							<input type="text" value="<?php
							echo $member['resident_id_card'];
							?>"  name="resident_id_card"  id="resident_id_card" ></input>
						</label>
					

						
						<label>
							<span>MemeberCard No.:</span>
							<input type="text" value="<?php
							echo $member['smart_card_number'];
							?>" name="smart_card_number" id="smart_card_number" ></input>
						</label>
						<label>
							<span>Membership Grade:</span>
							<select name="vip_grade" id="vip_grade">
							    <option></option>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								
							</select>
						</label>
					</p>
					<p>
							<label>
							<span>Memeber Code</span>
							<input type="text" name="m_code" id="m_code" value="<?php
							echo $member['m_code'];
							?>" ></input>
						</label>
						<label>
							<span>Country</span>
							<select name="country_code" id="country_code">
							<option></option>
								<?php  

                            foreach ($country as $row) {

							?>

							<!-- 国家编号 -->

							<!-- 国家名字 -->
								<option value="<?php echo $row['country_code']; ?>"><?php echo $row['country_name']; ?></option>
							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span>Membership Status:</span>
							<select>
								<option>未激活</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Chinese Name:</span>
							<input type="text" name="m_name" value="<?php
							echo $member['m_name'];
							?>" id="m_name"></input>
						</label>
						<label>
							<span>Nation:</span>
							<select >
								<option>汉族</option>
							</select>
						</label>
						<label>
							<span>Balance:</span>
							<input type="text" name="balance" value="<?php
							echo $member['balance'];
							?>" id="balance"></input>
						</label>
					</p>
					<p>
						<label>
							<span>First Name:</span>
							<input type="text" name="first_name"value="<?php
							echo $member['first_name'];
							?>" id="first_name"></input>	
						</label>
						<label>
							<span>Landline Telephone:</span>
							<input type="text" name="fixed_telephone" value="<?php
							echo $member['fixed_telephone'];
							?>" id="fixed_telephone"></input>
						</label>
						<label>
							<span>Integral:</span>
							<!-- 积分 -->
							<input type="text" name="points" value="<?php
							echo $member['points'];
							?>" id="points" ></input>
						</label>
					</p>
					<p>
						<label>
							<span>Last Name:</span>
							<input type="text" name="last_name"value="<?php
							echo $member['last_name'];
							?>" id="last_name"></input>

						
						</label>
						<label>
							<span>Phone No.:</span>
							<input type="text" name="mobile_number" value="<?php
							echo $member['mobile_number'];
							?>" id="mobile_number"></input>
						</label>
						<label>
							<span>Verify Phone No.:</span>
							<select>
								<option>未验证</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Birthday:</span>
							<input type="text" class="datepicker"  value="<?php
							echo $member['birthday'];
							?>"  name="birthday" id="birthday"></input>
						</label>
						<label>
							<span>E-mail:</span>
							<input type="email" name="email" value="<?php
							echo $member['email'];
							?>" id="email"></input>
						</label>
						<label>
							<span>Verity E-mail:</span>
							<select>
								<option>未验证</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Gender:</span>
							<select name="gender" id="gender">
								<option value="M">male</option>
								<option value="F">female</option>
							</select>
						</label>
						<label>
							<span>Login Name:</span>
							<input type="text" disabled="disabled"></input>
						</label>
						<label>
							<span>Registration IP:</span>
							<input type="text" disabled="disabled"></input>
						</label>
					</p>
					<p>
						<label>
							<span>Birthplace:</span>
							<input type="text" name="birth_place" value="<?php
							echo $member['birth_place'];
							?>" id="birth_place"></input>
						</label>
						<label>
							<span>Password:</span>
							<input type="password" name="m_password" value="<?php
							echo $member['m_password'];
							?>" id="m_password"></input>
						</label>
						<label>
							<span>Registration Date:</span>
							<input type="text" class="datepicker" value="<?php
							echo $member['create_time'];
							?>" name="create_time" id="create_time"></input>
						</label>
					</p>
				</div>
				<h3>Passport</h3>
				<div class="form">


	
					<p>
						<label>
							<span>Passport No:</span>
							<input type="text" name="passport_number" value="<?php
							echo $member['passport_number'];
							?>" id="passport_number">
						</label>
						<label>
							<span>Issuing Country:</span>
							<select name="post_country_code" id="post_country_code">
							<option></option>

							<?php  

                            foreach ($country as $row) {
                            
                            

							?>
      
								<option value="<?php echo $row['country_code']; ?>"><?php echo $row['country_name']; ?></option>

							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span>Issue Place:</span>
							<input type="text" name="place_issue" value="<?php
							echo $member['place_issue'];?>" id="place_issue" >
						</label>
					</p>
					<p>
						<label>
							<span>Issue Date:</span>
							<input type="text" class="datepicker" value="<?php
							echo $member['date_issue'];?>" name="date_issue" >
						</label>
						<label>
							<span>Closing Date:</span>
							<input type="text"  class="datepicker" value="<?php
							echo $member['date_expire'];?>"   name="date_expire" >
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

			 jQuery.validator.addMethod("shuzi", function(value, element) {
	       return this.optional(element) || /^[0-9]*$/.test(value);
             }, "please input number");


  jQuery.validator.addMethod("fixnumber", function(value, element) {
	return this.optional(element) || /^([0-9]{3,4}-)?[0-9]{7,8}$/.test(value);
}, "A positive or negative non-decimal number please");

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
                alert('请求错误');
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
                alert('请求错误');
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
                alert('请求错误');
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
                alert('请求错误');
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
                alert('请求错误');
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
                alert('请求错误');
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
			date_expire: { required : true,date:true},
			date_issue: { required : true},
			place_issue: { required : true},
			post_country_code: { required : true},
			
		  },
		messages: {
			resident_id_card:{required:'ID card不能为空'},
			smart_card_number:{required:'smart_card_number不能为空'},
            vip_grade: { required : '请选择Membership Grade'},
            m_code:{required:'m_code不能为空'},
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

           //  submitHandler:function(form)
           //   { 

           //   	 $.ajax({
	          //   type: "post",
	          //   url: "<?= Url::to(['member/passport_number_validate']);?>",
	               
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




        
            onfocusout:false,
             onkeyup:false,
             focusCleanup:true,
              onclick:false,


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





