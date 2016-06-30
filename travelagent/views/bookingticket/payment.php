<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style>
.balance_pay_div{border:1px solid #e0e9f4;margin-top: 20px;padding:50px 20px;}
.balance_pay_div p {line-height:35px;}
.balance_pay_div p span.left_text{display:inline-block;width:150px;text-align:right;}
.balance_pay_div .btnBox{text-align:center;}
.balance_pay_div input[type='password']{height: 30px; padding: 0 6px; width: 180px;}
</style>
<!-- main content start -->
<div id="payment" class="mainContent">
	<div id="topNav">
		<?php echo yii::t('app','Agent Ticketing')?>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Reservation')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Input mode')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Data Import')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Data Verification')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Confirm the Order Information')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Payment')?></a>
	</div>
	<div id="mainContent_content" class="pBox">
		<div class="infoBox">
			<div class="pBox">
				<span><?php echo yii::t('app','Order Number')?>:</span>
				<span><?php echo $order_number;?></span>
			</div>
			<div class="pBox">
				<span><?php echo yii::t('app','Payment Amount')?>:</span>
				<span class="point">￥<?php echo sprintf("%.2f",$total_pay_price)?></span>
			</div>
		</div>
		<div class="pBox pay_way_but">
			<p style="line-height: 25px;"><input type="radio" checked="checked" name="pay_way" value='0' /><span style="vertical-align:sub;"><?php echo yii::t('app','Balance Paid')?></span></p>
			<p style="line-height: 25px;"><input type="radio" name="pay_way" value='1' /><span style="vertical-align:sub;"><?php echo yii::t('app','Other Payment Methods')?></span></p>
		</div>
		
		<div class="tab other_pay_way" style="display: none;">
			<ul class="tabNav">
				<li><?php echo yii::t('app','UnionPay Card')?></li>
				<li class="active"><?php echo yii::t('app','Online Banking')?></li>
				
			</ul>
			<div class="tabContent">
				<div>1</div>
				<div class="active pBox" id="olineBank">
					<div>
						<label>
							<input type="radio"></input>
							<span><img src="<?=$baseUrl ?>images/1.png"></span>
						</label>
						<label>
							<input type="radio"></input>
							<span><img src="<?=$baseUrl ?>images/2.png"></span>
						</label>
					</div>
					<div class="btnBox">
						<input type="button" value="To Pay Online Banking" class="btn1"></input>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="balance_pay_div">
			<p>
				<span class="left_text"><?php echo yii::t('app','Your balance')?>:</span>
				<span class='point'>￥<?php echo sprintf("%.2f",$user_balance_price)?></span>
			</p>
			<p>
				<span class="left_text"><?php echo yii::t('app','Pay the amount')?>:</span>
				<span class='point'>￥<?php echo sprintf("%.2f",$total_pay_price)?></span>
			</p>
			<p>
				<span class="left_text"><?php echo yii::t('app','Pay the password')?>:</span>
				<span><input type='password' name="pay_price" /></span>
			</p>
			
			<div class="btnBox">
				<input type="button" id="balance_pay_submit_but" value="pay" class="btn1"></input>
			</div>
		</div>
	</div>
</div>
<!-- main content end -->
<script type="text/javascript">
window.onload = function(){
	$(".pay_way_but input[type='radio']").on('change',function(){
		var this_val = $(this).val();
		if(this_val == 0){
			$(".balance_pay_div").css('display','block');
			$(".other_pay_way").css('display','none');
		}else if(this_val == 1){
			$(".balance_pay_div").css('display','none');
			$(".other_pay_way").css('display','block');
		}
	});


	$(document).on('click','.balance_pay_div #balance_pay_submit_but',function(){
		var a = 0;
		var this_pass = $(".balance_pay_div input[name='pay_price']").val();
		var this_price = "<?php echo $user_balance_price?>";
		var this_pay_price = "<?php echo $total_pay_price?>";
		if(this_pass == ''){
			Alert("Enter the password for payment ");return false;
		}
		if(parseFloat(this_price) < parseFloat(this_pay_price)){
			Alert("Insufficient to pay the balance ");return false;
		}
		//判断密码
		$.ajax({
	        url:"<?php echo Url::toRoute(['checkagentpaypass']);?>",
	        type:'post',
	        async:false,
	        data:'password='+this_pass,
	     	dataType:'json',
	    	success:function(data){
	    		if(data != 0){
	    			if(data !== 0){
		    			//支付密码有误
		    			Alert("Pay the password is wrong");
		    			a = 1;return false;
	    			}
	    		}
	        		
	    	}      
	    });

	    if(a==1){return false;}

	    
	  //数据保存，支付状态改变，余额扣除
	  var order_num = "<?php echo $order_number;?>";
	    $.ajax({
	        url:"<?php echo Url::toRoute(['paymentgopay']);?>",
	        type:'post',
	        async:false,
	        data:'password='+this_pass+'&order_num='+order_num+'&pay_price='+this_pay_price,
	     	dataType:'json',
	    	success:function(data){
    			if(data !== 0){
	    			//支付成功
	    			Alert("Pay for success ");
	    			location.href="<?php echo Url::toRoute(['ticketcenter/ticketcenter'])?>";
    			}else{
    				Alert("Pay for failure ");
	    			
    			}
	    	}      
	    });
		
	});
}
</script>



