


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
    $( ".datepicker" ).datepicker();
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
							echo $member['date_issue'];?>" name="date_issue" id="date_issue">
						</label>
						<label>
							<span>Closing Date:</span>
							<input type="text"  class="datepicker" value="<?php
							echo $member['date_expire'];?>"   name="date_expire" >
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="button" value="Back" id="back" style="width: 80px;text-align: center;cursor:pointer;">
				



				</div>
			</div>
			</form>
		</div>
		<!-- content end -->


	
		<script type="text/javascript">
		$(document).ready(function($) {

		

			$('input').prop('readonly', true);
			$('select').prop('readonly', true);

			$('#back').click(function(event) {

	var url="<?= Url::to(['member/index']);?>";	
    location.href=url;
    return false;
				



			});

  



	
		

			
		});



	</script>





