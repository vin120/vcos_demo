
<?php 

use yii\helpers\Html;
use yii\helpers\Url;

use travelagent\views\myasset\PublicAsset;
use travelagent\views\myasset\AgentinfoAsset;

PublicAsset::register($this);
AgentinfoAsset::register($this);
?>

<!-- main content start -->
<div id="personalCenter" class="mainContent">
    <div id="topNav">
       <?php echo \Yii::t('app','Agent Ticketing')?> 
        <span>>></span>
        <a href="#"><?php echo \Yii::t('app','Travel Agent')?></a>
    </div>
    <div id="mainContent_content" class="pBox">
        <h2><?php echo \Yii::t('app','Basic information')?></h2>
        <div class="pBox" id="info">
            <ul>
                <li>
                    <span><?php echo \Yii::t('app','Account')?>:</span>
                    <span><?php echo $data['travel_agent_account']?></span>
                </li>
                <li>
                    <span><?php echo \Yii::t('app','Agent Name')?>:</span>
                    <span><?php echo $data['travel_agent_name']?></span>
                </li>
                <li>
                    <span><?php echo \Yii::t('app','Contacts')?>:</span>
                    <span><?php echo $data['travel_agent_contact_name']?></span>
                </li>
                <li>
                    <span><?php echo \Yii::t('app','Telephone')?>:</span>
                    <span><?php echo $data['travel_agent_contact_phone']?></span>
                </li>
                <li>
                    <span><?php echo \Yii::t('app','E-mail')?>:</span>
                    <span><?php echo $data['travel_agent_email']?></span>
                </li>
                <li>
                    <span><?php echo \Yii::t('app','Address')?>:</span>
                    <span><?php echo $data['travel_agent_address']?></span>
                </li>
                <li>
                    <span><?php echo \Yii::t('app','Account Balance')?>:</span>
                    <span class="point">￥<?php echo $data['current_amount']?></span>
                </li>
            </ul>
        </div>
        <div class="btnBox2">
            <input type="button" value="<?php echo \Yii::t('app','Change Login Password')?>" id="login_passwordclick" class="btn2"></input>
            <input type="button" value="<?php echo \Yii::t('app','Change Payment Password')?>" class="btn2" id="paymentpassword"></input>
        </div>
    </div>
    <!-- 修改支付密码弹出框  -->
    <div class="shadow"></div>
	<div class="popups" id="alertpaymentpassword">
		<h3><?php echo \Yii::t('app','Payment Password')?><a href="#" class="close r">&#10006;</a></h3>
		<div class="pBox">
			<input type="hidden" id="url" value="<?php echo Url::toRoute(['checkpassword']);?>"></input>
			<div>
				<label class="pay wrongBox" id="pay_password">
					<span><?php echo \Yii::t('app','Old Password')?>:</span>
					<span>
					<input type="password" name="pay_password"></input>
					<em></em>
					</span>
					
				</label>
			</div>
			<div>
				<label class="pay wrongBox">
					<span><?php echo \Yii::t('app','New Password')?>:</span>
					<span>
						<input type="password" name="newpay_password"></input>
						<em></em>
					</span>
					
				</label>
			</div>
			<div>
				<label class="pay wrongBox"  id="renewpay_passwordlabel">
					<span><?php echo \Yii::t('app','RePassword')?>:</span>
					<span>
						<input type="password" name="renewpay_password"></input>
						<em></em>
					</span>
					
				</label>
			</div>
			<div class="btnBox2">
			   <input type='hidden' value="<?php echo Url::toRoute(['submitpaypassword']);?>" id="paysubmiturl">
				<input type="button" value="<?php echo \Yii::t('app','SUBMIT')?>" id="pay_passwordsubmit" class="btn1"></input>
				<input type="button" value="<?php echo \Yii::t('app','CANCEL')?>" class="btn2 close"></input>
			</div>
		</div>
	</div>
	<!-- 修改登陆密码弹出框 -->
	<div class="popups" id="alertloginpassword">
		<h3><?php echo \Yii::t('app','Login Password')?><a href="#" class="close r">&#10006;</a></h3>
		<div class="pBox">
			<input type="hidden" id="loginurl" value="<?php echo Url::toRoute(['checkloginpassword']);?>"></input>
			<div>
				<label class="login wrongBox" id="login_password">
					<span><?php echo \Yii::t('app','Old Password')?>:</span>
					<span>
					<input type="password" name="login_password"></input>
					<em></em>
					</span>
					
				</label>
			</div>
			<div>
				<label class="login wrongBox">
					<span><?php echo \Yii::t('app','New Password')?>:</span>
					<span>
						<input type="password" name="newlogin_password"></input>
						<em></em>
					</span>
				</label>
			</div>
			<div>
				<label class="login wrongBox" id="renewlogin_passwordlabel">
					<span><?php echo \Yii::t('app','RePassword')?>:</span>
					<span>
						<input type="password" name="renewlogin_password"></input>
						<em></em>
					</span>
					
				</label>
			</div>
			<div class="btnBox2">
			   <input type='hidden' value="<?php echo Url::toRoute(['submitloginpassword']);?>" id="loginsubmiturl">
				<input type="button" value="<?php echo \Yii::t('app','SUBMIT')?>" id="login_passwordsubmit" class="btn1 close"></input>
				<input type="button" value="<?php echo \Yii::t('app','CANCEL')?>" class="btn2 close"></input>
			</div>
		</div>
	</div>
</div>
 <input type='hidden' value="<?php echo Url::toRoute(['agentinfo']);?>" id="locationurl">
<!-- main content end -->
