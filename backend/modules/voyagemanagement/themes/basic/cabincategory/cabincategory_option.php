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
<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.2.min.js"></script>
<script type="text/javascript">
var shore_excursion_ajax_url = "<?php echo Url::toRoute(['shoreexcursioncodecheck']);?>";
</script>
<style>
	#form input.point { outline-color: red; border: 2px solid red; }
	#form span.point { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #form span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
</style>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo \Yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabincategory']);?>"><?php echo \Yii::t('app','Cabin  Category')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<form method="post" id="form">
		<input type="hidden" name="class_id" value="<?php echo  isset($_GET['class_id'])?$_GET['class_id']:''?>">
				<div>
				<p>
				<label>
				<span class='max_l'><?php echo \Yii::t('app','Cabin Name:')?></span>
				<input type="text" id='class_name' name='class_name' value="<?php echo isset($data[0]['class_name'])?$data[0]['class_name']:''?>"></input>		
					<span class="point" style="display: none"><?php echo yii::t('app','Cabin Name cannot be empty ')?></span>
				</label>
				<span class='tips'></span>
				</p>
				<p>
				<label>
					<span class='max_l'><?php echo \Yii::t('app','Reference Price:')?></span>
					<input type="text" id="price"  name="price" value="<?php echo isset($data[0]['price'])?$data[0]['price']:''?>"></input>
					<span class="point" style="display: none"><?php echo yii::t('vcos','Cabin Price  cannot be empty ')?></span>
					<span class="point" id="spanprice" style="display: none"><?php echo yii::t('app','Cabin Price   must be Num or only two decimal ')?></span>
				</label>
				<span class='tips'></span>
			</p>
			<p>
				<label>
				<?php $data[0]['status']=isset($data[0]['status'])?$data[0]['status']:'2'?>
					<span class='max_l'><?php echo \Yii::t('app','Status:')?></span>
					<select name="status">
					<option value="1" <?php echo $data[0]['status']==1?"selected='selected'":''?>><?php echo \Yii::t('app','Avaliable')?></option>
					<option value="0" <?php echo $data[0]['status']==0?"selected='selected'":''?>><?php echo \Yii::t('app','Unavaliable')?></option>
					</select>
				</label>
				<span class='tips'></span>
			</p>		
		</div>
		<div class="btn">
				<input type="submit" style="cursor:pointer" value="<?php echo \Yii::t('app','SAVE')?>"></input>
				<input class="cancel" type="button" value="<?php echo \Yii::t('app','CANCEL')?>"></input>
			</div>
	</form>
	</div>  
    </div>
</div>
<!-- content end -->
<script type="text/javascript">
$(function(){
	$("input.cancel").click(function(){
		 location.href="<?php echo Url::toRoute(['cabincategory']);?>";
		});
	  $("input[type=text]").each(function(){//聚焦是清除
			$(this).focus(function(){
				 $(this).next().css("display","none");
				 $(this).removeClass("point");
				 $("#spanprice").css("display","none");//聚焦时隐藏
				});
			 });
	  $("span[class=point]").each(function (index){
			$(this).css("display","none");
			 }); 
	  $("input[type=submit]").click(function(){//价格校验
		  var t=0;
		  var reg=/^\d+(\.\d{2})?$/;
			var price=$("#price").val();
			if(!reg.test(price)){
				$("#spanprice").css("display","");
				$("input#price").addClass("point");
				t=1;
				}
		  $("input[type=text]").each(function(){	//如果文本框为空值			
				if($(this).val()==''){
					$(this).next().css("display","");
					$(this).addClass("point");
					}
				if($("input#price").val()==''){
				$("#spanprice").css("display","none");//为空时就不用提示数字错误
				}
	       			}); 
			$("input[type=text]").each(function (index){
				if($(this).prop("class")=="point"){
					t=1;
					}
	    		}); 
			if(t==1){
    			return false;
	    		} 
		  }); 
});
</script>
