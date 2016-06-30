<?php
$this->title = 'Org Management';


use app\modules\orgmanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);
?>
<style type="text/css">
	#departmentList ul { padding-left: 14px; list-style: none; font-size: 14px; }
	#departmentList li { padding: 4px 0; }
	#departmentList li.no-child { padding-left: 14px; }
	#departmentList input[type="checkbox"] { vertical-align: middle; }
	#departmentList .close, #departmentList .open { padding-left: 0px; }
	#departmentList .close:before, #departmentList .open:before { display: inline-block; width: 14px; line-height: 14px;  text-align: center; font-size: 12px; color: #fff; cursor: pointer; vertical-align: middle; }
	#departmentList .open:before { content: "-"; }
	#departmentList .close:before { content: "+"; }
	#departmentList .btn { text-align: left; }
</style>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app', 'Org Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app', 'Org')?></a></div>
		<div id="departmentList">
			<!-- <ul>
				<li class="open"><input type="checkbox"></input>泰山邮轮公司</li>
				<ul>
					<li class="open"><input type="checkbox"></input>泰山邮轮1号</li>
					<ul>
						<li><input type="checkbox"></input>行政部</li>
					</ul>
					<li><input type="checkbox"></input>泰山邮轮1号</li>
					<li><input type="checkbox"></input>泰山邮轮1号</li>
				</ul>
			</ul> -->
			<?php echo $data;?>
			<div class="btn">
				<a href="<?php echo Url::toRoute(['orgadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
				<input type="button" id="org_edit_but" value="<?php echo yii::t('app','Edit')?>" class="btn1 "></input>
				<input type="button" id="org_del_but" value="<?php echo yii::t('app','Del')?>"></input>
			</div>
		</div> 
		 
		 
    <!--  <div class="center" id="travel_agent_page_div"> </div> -->
    </div>
</div>
<!-- content end -->


<script>
window.onload = function(){ 
	$("#org_edit_but").on('click',function(){
		var length = $("#departmentList").find("input[type='checkbox']:checked").length;
		if(length>1){
			Alert("Can only edit a record at a time");
		}else if(length==0){
			Alert("Did not need to edit selected records");
		}else if(length ==1){
			var id = $("#departmentList").find("input[type='checkbox']:checked").val();
			location.href = "<?php echo Url::toRoute(['orgadd']);?>&id="+id;
		}
		
	});

	$("#org_del_but").on('click',function(){
		
		var length = $("#departmentList").find("input[type='checkbox']:checked").length;
		if(length==0){
			Alert("Delete selected items");return false;
		}
		
		Confirm("Confirm to delete the selected item");
	});


	$(document).on('click',".btn .confirm_but",function(){
		var data = '';
		$("#departmentList").find("input[type='checkbox']:checked").each(function(e){
			data += $(this).val()+',';
		});
		
		$.ajax({
	        url:"<?php echo Url::toRoute(['orgdelete']);?>",
	        type:'get',
	        data:'data='+data,
	        dataType:'json',
	    	success:function(data){
	    		if(data==1){
	    			Alert("Save success");
	    		}else{
	    			Alert("Save failed");
	    		}
	    		location.reload();
	    	}      
	    });
	});
}
</script>

