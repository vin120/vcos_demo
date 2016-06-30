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
		<div class="r content">
			<div class="topNav"><?php echo yii::t('vcos', 'Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('vcos', 'Scenic Route')?></a></div>
		<form method="post" id="form">
		<input name="id" type="hidden" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>">
			<div class="write">
				<div>
						<p>
						<label>
						<span><?php echo yii::t('vcos', 'Grade:')?></span>
						<input type="text" name="travel_agent_level" value="<?php echo yii::t('vcos', $travelinfo[0]['travel_agent_level'])?>"></input>
						<span class="point"  style="display:none"><?php echo yii::t('vcos','Required fields can not be empty ')?></span>
						</label>
						</p>
						<p>
						<label>
							<span><?php echo yii::t('vcos', 'Superior Agent:')?></span>
							<select name="travel_agent_higher_level_id">
							<?php if ($travelinfo[0]['travel_agent_higher_level_id']==0){?>
							<option value="0" selected="selected"><?php echo yii::t('vcos', 'no')?></option>
							<?php }
							else{?>
							<option value="0"><?php echo yii::t('vcos', 'no')?></option>
							<?php }?>
							<?php foreach ($travel_agent_typeinfo as $k=>$v):?>
								<?php if ($travelinfo[0]['id']!=$v['id']){?>
								<option value="<?php echo $v['id']?>" <?php echo ($travelinfo[0]['travel_agent_higher_level_id'])==$v['id']?"selected='selected'":''?>><?php echo yii::t('vcos', $v['travel_agent_level'])?></option>	
								<?php }?>
								<?php endforeach;?>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('vcos', 'Status:')?></span>
							<select name="status">
								<option value="1" <?php echo $travelinfo[0]['status']==1?"selected='selected'":''?>><?php echo yii::t('vcos', 'Usable')?></option>
								<option value="0" <?php echo $travelinfo[0]['status']==0?"selected='selected'":''?>><?php echo yii::t('vcos', 'Disable')?></option>
							</select>
						</label>
					</p>
				</div>
				<div class="btn">
				
					<input type="submit" value="<?php echo yii::t('vcos', 'SAVE')?>"></input>
					<input type="button" id="redictconfig" value="<?php echo yii::t('vcos', 'CANCLE')?>"></input>
				</div>
			</div>
		</form>
		</div>
		<script type="text/javascript">
	    $(function(){
	    	$("#redictconfig").click(function(){//返回页面
				window.location = "<?php echo Url::toRoute(['type_config']);?>";
					});
	    	$("input[type=text]").each(function(){
				$(this).focus(function(){
					 $(this).next().css("display","none");
					 $(this).removeClass("point");
					});
				 });
			$("input[type=submit]").click(function(){
	 			var t=0;
	 			 $("input[type=text]").each(function(index){	//如果文本框为空值			
					if($(this).val()==''){
						$(this).next().css("display","");
						$(this).addClass("point");
						t=1;
						}
		       			}); 
			 if(t==1){
				return false;
			}
	 			});
	    });
</script>
