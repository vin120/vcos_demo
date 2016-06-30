<?php
$this->title = 'Voyage Management';

use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

?>

<!-- content start -->
<div class="r content">
	<div class="topNav"><?php echo yii::t('app','Voyage Manage') ?>&nbsp;&gt;&gt;&nbsp;
	<a href="<?php echo Url::toRoute(['activeconfig']);?>"><?php echo yii::t('app','Active Config') ?></a>&nbsp;&gt;&gt;&nbsp;
	<a href="#"><?php echo yii::t('app','Active Config Add')?></a></div>
	<div class="tab">
		<ul class="tab_title">
			<li class="active">Active</li>
			<li>Detail</li>
		</ul>
		<div class="tab_content">
			<div class="active">
				<div class="write">
				<?php
					$form = ActiveForm::begin([
						'action' => ['activeconfigadd'],
						'method'=>'post',
						'id'=>'active_config_add',
						'options' => ['class' => 'active_config_add'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false
					]); 
				?>
					<div class="check_save_div">
						<p>
							<label>
								<span> <?php echo yii::t('app','Name')?>:</span>
								<input maxlength="16" type="text" id="name"  name="name"></input>
							</label>
						</p>
						<p>
							<label>
								<span><?php echo yii::t('app','Status')?>:</span>
								<select id="active_select" name="active_select">
									<option value="1"><?php echo yii::t('app','Avaliable') ?></option>
									<option value="0"><?php echo yii::t('app','Unavaliabled') ?></option>
								</select>
							</label>
						</p>
					</div>
					<div class="btn">
						<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','SAVE')?>" ></input>
						<input type="button" class="<?php echo yii::t('app','CANCEL') ?>" value="CLEAN" ></input>
					</div>
				<?php 
					ActiveForm::end(); 
				?>
				</div>
			</div>
			<div>
				<div>
					<table>
						<thead>
							<tr>
								<th><input type="checkbox"></input></th>
								<th><?php echo yii::t('app','Day')?></th>
								<th><?php echo yii::t('app','Title')?></th>
								<th><?php echo yii::t('app','Desc')?></th>
								<th><?php echo yii::t('app','Operate')?></th>
							</tr>
						</thead>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span>0</span></p>
					<div class="btn">
						<input type="button" value="<?php echo yii::t('app','Add')?>" style="background: #ccc;cursor:not-allowed" ></input>
						<input type="button" value="<?php echo yii::t('app','Del Selected')?>" style="background: #ccc;cursor:not-allowed" ></input>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- content end -->

<script type="text/javascript">
window.onload = function(){ 
	$("form#active_config_add").submit(function(){
		var name = $("input[name='name']").val();
		var data = "<span class='point' >Required fields cannot be empty</span>";
        
		if(name==''){
			$("input[name='name']").parent().append(data);
			$("input[name='name']").addClass("point");
			return false;
		}
	});
	
}
</script>