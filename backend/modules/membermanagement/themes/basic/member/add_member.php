

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
	#member_add_form input.point { outline-color: red; border: 2px solid red; }
	#member_add_form label.error { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #member_add_form label.error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
</style>
	

<!-- content start -->
		<div class="r content" id="issueTicket_info">
			<div class="topNav"><?= \Yii::t('app', 'Membership Manage') ?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?= \Yii::t('app', 'Membership') ?></a></div>
			<form action="<?= Url::to(['member/member_add']);?>" method="post" id="member_add_form">
			
			<div id="memberInfo">
				<h3><?= \Yii::t('app', 'Booking person') ?></h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'ID Card') ?>:</span>
							<input type="text"   name="resident_id_card"  id="resident_id_card" ></input>
						</label>
					

						
						<label>
							<span><?= \Yii::t('app', 'MemeberCard No.') ?>:</span>
							<input type="text"  name="smart_card_number" id="smart_card_number" ></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Membership Grade') ?>:</span>
							<select name="vip_grade" id="vip_grade">
							    <option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								
							</select>
						</label>
					</p>
					<p>
							<label>
							<span><?= \Yii::t('app', 'Memeber Code') ?>:</span>
							<input type="text" name="m_code" id="m_code" readonly="true" style="background-color:#E5E5E5;border:#B9B9B9 1px solid"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Country') ?>:</span>
							<select name="country_code" id="country_code">
							
								<?php  

                            foreach ($country as $key=>$row) {

							?>

							<!-- 国家编号 -->

							<!-- 国家名字 -->
								<option value="<?php echo $row['country_code']; ?>" ><?php echo $row['country_name']; ?></option>
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
							<input type="text" name="m_name"  id="m_name"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Nation') ?>:</span>
							<select >
								<option><?= \Yii::t('app', 'The han nationality') ?></option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Balance') ?>:</span>
							<input type="text" name="balance"  id="balance"></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'First Name') ?>:</span>
							<input type="text" name="first_name" id="first_name"></input>	
						</label>
						<label>
							<span><?= \Yii::t('app', 'Landline Telephone') ?>:</span>
							<input type="text" name="fixed_telephone"  id="fixed_telephone"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Integral') ?>:</span>
							<!-- 积分 -->
							<input type="text" name="points"  id="points" ></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Last Name') ?>:</span>
							<input type="text" name="last_name" id="last_name"></input>

						
						</label>
						<label>
							<span><?= \Yii::t('app', 'Phone No.') ?>:</span>
							<input type="text" name="mobile_number"  id="mobile_number"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verify Phone No.') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'No validation') ?></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthday') ?>:</span>
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en'})" class="Wdate"   name="birthday" id="birthday"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'E-mail') ?>:</span>
							<input type="email" style="width: 184px;height:24px" name="email"  id="email"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verity E-mail') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'No validation') ?></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Gender') ?>:</span>
							<select name="gender" id="gender">
								<option value="M">M</option>
								<option value="F">F</option>
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
							<input type="text" name="birth_place"  id="birth_place"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Password') ?>:</span>
							<input type="text" style="width: 184px;height:24px" onfocus="this.type='password'" autocomplete="off" name="m_password"  id="m_password"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Registration Date') ?>:</span>
						<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en'})" class="Wdate"  name="create_time" id="create_time"></input>
						</label>
					</p>
				</div>
				<h3><?= \Yii::t('app', 'Passport') ?></h3>
				<div class="form">


	
					<p>
						<label>
							<span><?= \Yii::t('app', 'Passport No') ?>:</span>
							<input type="text" name="passport_number"  id="passport_number">
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issuing Country') ?>:</span>
							<select name="post_country_code" id="post_country_code">
							<?php  

                            foreach ($country as $key=> $row) {
                            

							?>
      
							<option value="<?php echo $row['country_code']; ?>"> <?php echo $row['country_name']; ?></option>

							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issue Place') ?>:</span>
							<input type="text" name="place_issue"  id="place_issue" >
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Issue Date') ?>:</span>
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  name="date_issue" id="date_issue" >
						</label>
						<label>
							<span><?= \Yii::t('app', 'Closing Date') ?>:</span>
							<input type="text"  onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  name="date_expire"  id="date_issue">


						</label>
					</p>
				</div>
				<div class="btn">
					<input type="submit" value="<?= \Yii::t('app', 'Add') ?>" id="member_add" style="width: 80px;text-align: center;cursor:pointer;">
					<input type="button" value="<?= \Yii::t('app', 'Back') ?>" id="back" >
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

				 
			$('#m_password').val('');
			


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
            data: {'email':$.trim($('#email').val())},    
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
            data: {'mobile_number':$.trim($('#mobile_number').val())},    
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
            data: {'id_card':$.trim($('#resident_id_card').val())},    
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
            data: {'passport_number':$.trim($('#passport_number').val())},    
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
            data: {'smart_card_number':$.trim($('#smart_card_number').val())},    
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
            data: {'m_code':$.trim($('#m_code').val())},    
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


      // 清空表单所有内容，很好用，很强大
        	 $(':input','#member_add_form')
             .not(':button, :submit, :reset, :hidden')
             .val('')
             .removeAttr('checked')
             .removeAttr('selected');

            







  

		$("#member_add_form").validate({
		   rules: {
            resident_id_card:{required:true},
            smart_card_number:{required:true},
		   	vip_grade: { required : true},
		  
		    country_code: { required : true},
		   	m_name: { required : true},
            balance:{required:true,digits:true},
		   	first_name: { required : true},
		   	fixed_telephone: { required : true,fixnumber:true},
		   	points: { required : true,digits:true},
		   	last_name: { required : true},
		   	mobile_number: { required : true,mobile:true},
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
			resident_id_card:{required:'ID card can not be empty'},
			smart_card_number:{required:'smart_card_number can not be empty'},
            vip_grade: { required : 'Please Select Membership Grade'},
          
		    country_code: { required : 'Please Select Country'},
		   	m_name: { required : 'Chinese Name can not be empty'},
		   	balance:{required:'Balance can not be empty',digits:'balance Only fill in the integer '},
		   	first_name: { required : 'first_name can not be empty'},
		   	fixed_telephone: { required : 'Landline Telephone can not be empty',
			   	fixnumber:'Landline Telephone Format is wrong '


			   	},
		   	points: { required : 'Integral can not be empty',digits:'Integral Only fill in the integer'},
		   	last_name: { required : 'last_name can not be empty'},
		   	mobile_number: { required : 'mobile_number can not be empty',mobile:'mobile_number Format is wrong  '},
		   	birthday: { required : 'birthday can not be empty'},			
            email:{required:'email can not be empty',email:"E-mail Format is wrong" },
	         gender: { required : 'Please Select Sex'},
		    birth_place: { required : 'birth_place can not be empty'},
			create_time: { required : 'create_time can not be empty'},
			passport_number: { required : 'passport_number can not be empty'},
			m_password: { required : 'password can not be empty',rangelength:'Password length of 6-30 '},
			date_expire: { required : 'date_expire can not be empty'},
			date_issue: { required : 'date_issue can not be empty'},
			place_issue: { required : 'place_issue can not be empty'},
			post_country_code: { required : 'Please Select post_country_code'},
		
		
			
		},
	
        
      


	 });


			$('#back').click(function(event) {

       

	var url="<?= Url::to(['member/index']);?>";	
    location.href=url;
    return false;
				



			});






			
		});



		</script>

	


