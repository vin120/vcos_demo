<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<script type="text/javascript">
var cabin_type_ajax_url = "<?php echo Url::toRoute(['cabintypecodecheck']);?>";
</script>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabintype']);?>"><?php echo yii::t('app','Cabin Type')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Cabin_type_add')?></a></div>
    
    <div class="tab">
		<ul class="tab_title">
			<li class="active"><?php echo yii::t('app','Basic')?></li>
			<li><?php echo yii::t('app','Graphic')?></li>
		</ul>
		<div class="tab_content">
			<div class="active">
				<div class="searchResult">
					<div id="service_write" class="write">

					<?php
						$form = ActiveForm::begin([
								'action' => ['cabintypeadd'],
								'method'=>'post',
								'id'=>'cabin_type_val',
								'options' => ['class' => 'cabin_type_add'],
								'enableClientValidation'=>false,
								'enableClientScript'=>false
						]); 
					?>
					<div class="check_save_div">
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Cabin Type Code')?>:</span>
								<input type="text" maxlength="16" id='code' name='code'></input>
								
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Cabin Type Name')?>:</span>
								<input type="text" maxlength="16" id="name" name="name"></input>
								
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Live Number')?>:</span>
								<select name='live_number' id="live_number" class='input_select'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Beds')?>:</span>
								<select name='beds' id="beds" class='input_select'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
								</select>
							</label>
						</p>
						
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Room Area')?>:</span>
								<input type="text" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="3" id="room_min" name="room_min" style="width:35px" /> -
								<input type="text" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="3" id="room_max"  name="room_max" style="width:35px" /><font style="margin-left: 5px;" class='cabin_type_room_span'><?php echo yii::t('app','㎡')?></font>
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Floor')?>:</span>
								<input type="text" maxlength="16" id='floor' name='floor'></input>
								
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','location')?>:</span>
								<select name="location" id="location" class='input_select'>
									<option value="0"><?php echo yii::t('app','Port Side')?></option>
									<option value="1"><?php echo yii::t('app','Starboard Side')?></option>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
								<select name="state" id="state" class='input_select'>
									<option value='1'><?php echo yii::t('app','Avaliable')?></option>
									<option value='0'><?php echo yii::t('app','Unavaliable')?></option>
								</select>
							</label>
						</p>
						<?php foreach($type_attr as $k=>$val){?>
						<p>
							<label>
								<span class='max_l'><?php echo $val['att_name']?>:</span>
								<input type="radio" name="att[<?php echo $k;?>]" id="att[<?php echo $k;?>]" value="<?php echo $val['id']?>" /> <?php echo yii::t('app','Y')?>
								<input checked="checked" type="radio" name="att[<?php echo $k;?>]" id="att[<?php echo $k;?>]" value="0" /> <?php echo yii::t('app','N')?>
							</label>
						</p>
						<?php }?>
					</div>
					<div class="btn">
							<input style="cursor:pointer" type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
							<input class="cancel" type="button" value="<?php echo yii::t('app','CANCEL')?>"></input>
						</div>
					<?php 
					ActiveForm::end(); 
					?>
			
				</div>
				</div>
			</div>
			<div>
				<div>
					<table>
						<thead>
							<tr>
								<th><?php echo yii::t('app','No.')?></th>
								<th><?php echo yii::t('app','Cabin Type Desc')?></th>
								<th><?php echo yii::t('app','Cabin Type Img')?></th>
								<th><?php echo yii::t('app','Operate')?></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span>0</span></p>
					<div class="btn">
						<input type="button" value="<?php echo yii::t('app','Add')?>" style="background:#ccc;cursor:not-allowed"></input>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- content end -->


