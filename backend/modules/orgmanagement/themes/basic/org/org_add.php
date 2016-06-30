<?php
$this->title = 'Org Management';


use app\modules\orgmanagement\themes\basic\myasset\ThemeAsset;
use app\modules\orgmanagement\themes\basic\myasset\ThemeAssetOrgWrite;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


ThemeAsset::register($this);
ThemeAssetOrgWrite::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$baseUrl = $this->assetBundles[ThemeAssetOrgWrite::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);
?>
<style type="text/css">
	.formBox p > label > span:first-child { display: inline-block; width: 20%; min-width: 200px; text-align: right; }
	.formBox select { width: 150px; }
	.formBox textarea { width: 300px; height: 100px; vertical-align: top; resize:none}
	
	#org_val span.point {margin-left:5px; width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #org_val span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
	#org_val label.error { width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #org_val label.error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
    #org_val input.point { outline-color: #fe5d5d; border: 2px solid #fe5d5d; }
	
</style>
<script type="text/javascript">
var org_add_ajax_url = "<?php echo Url::toRoute(['getorgdata']);?>";
</script>
	
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app', 'Org Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="<?php echo Url::toRoute(['org']);?>"><?php echo yii::t('app', 'Org')?></a>&nbsp;&gt;&gt;&nbsp;<a><?php echo yii::t('app', 'Org_edit')?></a></div>
    
    	<?php
			$form = ActiveForm::begin([
					'action' => ['orgadd'],
					'method'=>'post',
					'id'=>'org_val',
					'options' => ['class' => 'org_add'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		<div class="formBox">
		<input type='hidden' name="dep_id" id="dep_id" value="<?php echo empty($result)?'':$result['department_id'];?>">
		<input type='hidden' name="parent_id" id="parent_id" value="<?php echo empty($result)?'':$result['parent_department_id'];?>">
			<p>
				<label>
					<span><?php echo yii::t('app','Department Name')?>:</span>
					<input type="text" name="name" id="name" value="<?php echo empty($result)?'':$result['department_name'];?>"></input>
				</label>
			</p>
			<p>
				<label id="org_add_radio">
					<span><?php echo yii::t('app','Is parent department')?>:</span>
					<label>
						<input type="radio" name="dep" value="1" <?php echo empty($result)?'':($result['parent_department_id']==0?"checked='checked'":'');?>></input>
						<span>YES</span>
					</label>
					<label>
						<input type="radio" name="dep" value="0" <?php echo empty($result)?"checked='checked'":($result['parent_department_id']!=0?"checked='checked'":'');?>></input>
						<span>NO</span>
					</label>
				</label>
			</p>
			<p>
				<label id="org_add_select">
					<span><?php echo yii::t('app','Higher Office')?>:</span>
					<span>
						<select id="selectDpm">
						</select>
					</span>
				</label>
			</p>
			<p>
				<label>
					<span><?php echo yii::t('app','Remark')?>:</span>
					<textarea name="desc" id="desc"><?php echo empty($result)?'':$result['remark'];?></textarea>
				</label>
			</p>
			<p class="btn">
				<input type="submit" value="<?php echo yii::t('app','SAVE')?>" id="save"></input>
				<a href="<?php echo Url::toRoute(['org']);?>"><input type="button" value="<?php echo yii::t('app','CANCLE')?>"></input></a>
			</p>
		</div>
		<?php 
		ActiveForm::end(); 
		?>
		 
    <!--  <div class="center" id="travel_agent_page_div"> </div> -->
    </div>

<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 

	
	<?php if(!empty($result)){
		if($result['parent_department_id']==0){?>
		$("#selectDpm option:first").prop("selected", 'selected'); 
		$("#org_add_select").find("select").css("display","none");
		$("#org_add_select select").eq(0).css("display","inline-block");
		$("#org_add_select select ").eq(0).attr("disabled","disabled");
	<?php 	}
	}?>


	//聚焦是清除
	$("input[name='name']").focus(function(){
		$(this).parent().find("span.point").remove();
		$(this).removeClass("point");
	});
	$("textarea[name='desc']").focus(function(){
		$(this).parent().find("span.point").remove();
		$(this).removeClass("point");
	});
	
	
	$("form").submit(function(){
		var is_parent = $("input[name='dep']:checked").val();
		var name = $("input[name='name']").val();
		var desc = $.trim($("textarea[name='desc']").val());
		var data = "<span class='point' ><?php echo yii::t('app','Required fields cannot be empty ')?></span>";
		if(name==''){
	    	$("input[name='name']").parent().append(data);
	    	$("input[name='name']").addClass("point");
			return false;
		}
		if(desc==''){
			$("textarea[name='desc']").parent().append(data);
	    	$("textarea[name='desc']").addClass("point");
			return false;
		}
		
		$("#org_add_select select[name='parent_id']").each(function(){
			$(this).removeAttr("name");
			});
		if(is_parent == 0){
			var parent_id = '';
			$("#org_add_select select[class='LinkageSel']").each(function(){
				var val  = $(this).val();
				if(val == null){
					return true;
					}
				if(val == undefined){
					return true;
					}
				if(val==''){
					return true;
					}
				parent_id = val;
			});
			
			if(parent_id==''){alert("Please select a parent");return false;}
			$("input[name='parent_id']").val(parent_id);
		}
		//alert(parent_id);
		//return false;
	});
	
	$("#org_add_radio").find("input[type='radio']").on('click',function(){
		var  is_parent = $(this).val();
		if(is_parent == 1){
			$("#selectDpm option:first").prop("selected", 'selected'); 
			$("#org_add_select").find("select").css("display","none");
			$("#org_add_select select").eq(0).css("display","inline-block");
			$("#org_add_select select ").eq(0).attr("disabled","disabled");
		}else if(is_parent == 0){
			$("#org_add_select").find('select').removeAttr("disabled");
		}
		
	});
	

}
</script>

