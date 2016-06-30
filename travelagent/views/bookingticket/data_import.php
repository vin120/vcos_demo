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
<!-- main content start -->
<div id="dataImport" class="mainContent">
	<div id="topNav">
		<?php echo yii::t('app','Agent Ticketing')?>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Reservation')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Input mode')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Data Import')?></a>
	</div>
	<div id="mainContent_content" class="pBox">
		<!-- 请用ajax提交 -->
		<div id="uploadFile">
			<label>
				<span><?php echo yii::t('app','Filename')?>:</span>
				<span id="uploadBox">
					<label>
						<input type="file"></input>
						<input type="text" disabled="disabled"></input>
						<input type="button" value="Browse" class="btn1"></input>
					</label>
				</span>
			</label>
		</div>
		<div class="btnBox2">
			<input type="button" value="PREVIOUS" class="btn2"></input>
			<input type="button" value="NEXT" class="btn1"></input>
		</div>
	</div>
</div>
<!-- main content end -->





