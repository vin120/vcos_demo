<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUeditor;
ThemeAsset::register($this);
ThemeAssetUeditor::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.2.min.js"></script>
<script type="text/javascript">
var shore_excursion_ajax_url = "<?php echo Url::toRoute(['shoreexcursioncodecheck']);?>";
</script>
<<style>
	#form input.point { outline-color: red; border: 2px solid red; }
	#form span.point { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #form span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
	#cost_desc { display: inline-block; width: 50%; vertical-align: top; }
</style>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo \Yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['surchargeconfig']);?>"><?php echo \Yii::t('app','Surcharge Config')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<form method="post" id="form">
		<input type="hidden" name="sid" value="<?php echo isset($surchargeinfo[0]['id'])?$surchargeinfo[0]['id']:''?>">
		<div>
				<p>
				<label>
				<span class='max_l'><?php echo \Yii::t('app','Surcharge Name:')?></span>
				<input type="text" id='cost_name' name='cost_name' value="<?php echo isset($surchargeinfo[0]['cost_name'])?$surchargeinfo[0]['cost_name']:''?>"></input>		
					<span class="point" style="display: none"><?php echo yii::t('app','Surcharge Name cannot be empty ')?></span>
				</label>
				<span class='tips'></span>
				</p>
				<p>
				<label>
					<span class='max_l'><?php echo \Yii::t('app','Surcharge Price:')?></span>
					<input type="text" id="cost_price" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="cost_price" value="<?php echo isset($surchargeinfo[0]['cost_price'])?$surchargeinfo[0]['cost_price']:''?>"></input>
					<span class="point" style="display: none"><?php echo yii::t('app','Surcharge Price must be number ')?></span>
				</label>
				<span class='tips'></span>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo \Yii::t('app','Surcharge Describe:')?></span>
					<textarea id="cost_desc" name="cost_desc" value="<?php echo isset($surchargeinfo[0]['cost_desc'])?$surchargeinfo[0]['cost_desc']:''?>">
					</textarea>
					<input type="hidden" id="cost_desc_text" value="<?php echo isset($surchargeinfo[0]['cost_desc'])?$surchargeinfo[0]['cost_desc']:''?>">
				</label>
				<span class='tips'></span>
			</p>		
		</div>
		<div class="btn">
				<input type="submit"  style="cursor:pointer" value="<?php echo \Yii::t('app','SAVE')?>"></input>
				<input class="cancel"  type="button" value="<?php echo \Yii::t('app','CANCEL')?>"></input>
			</div>
	</form>
	</div>  
    </div>
</div>
<!-- content end -->
<script type="text/javascript">
$(function(){
	UE.getEditor('cost_desc');
	
	var sur=$("input#cost_desc_text").val();
	$("textarea#cost_desc").html(sur);
	$("input[type=text]").each(function(){//聚焦是清除
		$(this).focus(function(){
			$(this).next().css("display","none");
			$(this).removeClass("point");
		});
	});
	$("span[class=point]").each(function (index){
		$(this).css("display","none");
	}); 
	
	$("input[type=submit]").click(function(){
		var t=0;
		
		$("input[type=text]").each(function(){	//如果文本框为空值			
			if($(this).val()==''){
				$(this).next().css("display","");
				$(this).addClass("point");
			}
	 	}); 
		$("input[type=text]").each(function (index){
			if($(this).prop("class")=="point"){
				t=1;
			}
	    });
	    
		var cost_desc = UE.getEditor('cost_desc').getContentTxt();
	    if(cost_desc == '') {
	    	Alert("<?php echo yii::t('app','Description cannot be empty')?>");
			return false;
		}
		
		if(t==1){
    		return false;
	    } 
	});

});
</script>
