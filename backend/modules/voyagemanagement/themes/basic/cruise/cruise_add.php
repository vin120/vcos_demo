<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUpload;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUeditor;

ThemeAsset::register($this);
ThemeAssetUpload::register($this);
ThemeAssetUeditor::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$baseUrl_upload = $this->assetBundles[ThemeAssetUpload::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style>
	.write label span.btn_img{width:95px;}
	.write label span.btn_img > span{width:90px;}
</style>
<script type="text/javascript">
var cruise_ajax_url = "<?php echo Url::toRoute(['cruisecodecheck']);?>";
</script>
<style>
	#cruise_val span.point {margin-left:5px; width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #cruise_val span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
	#cruise_val label.error { width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #cruise_val label.error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
    #cruise_val input.point { outline-color: #fe5d5d; border: 2px solid #fe5d5d; }
    #cruise_val textarea.point { outline-color: #fe5d5d; border: 2px solid #fe5d5d; }
    #desc { display: inline-block; width: 50%; vertical-align: top; }
</style>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cruise']);?>"><?php echo yii::t('app','Cruise')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Cruise_add')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<?php
			$form = ActiveForm::begin([
				'action' => ['cruiseadd'],
				'method'=>'post',
				'id'=>'cruise_val',
				'options' => ['class' => 'cruise_add','enctype'=>'multipart/form-data'],
				'enableClientValidation'=>false,
				'enableClientScript'=>false
			]); 
		?>
		<div>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Cruise Code')?>:</span>
					<input type="text" id='code' name='code' maxlength="16"/>
					</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Cruise Name')?>:</span>
					<input type="text" id="name" name="name" maxlength="16"/>
					
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Deck Number')?>:</span>
					<input type="text" maxlength="2"  id='number' name='number'  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />
					
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
			<p>
				<label>
					<span class='max_l' style="float: left;"><?php echo yii::t('app','Cruise Img')?>:</span>
					<span id="img_back" style="width:120px;height:120px;float:left;margin-left:5px;margin-bottom:30px;display:none">
					<img id="ImgPr" width="120" height="120" src=""/>
					</span>
					<span id="up_btn" class="btn_img" style="display:inline-block;margin-left:5px;">
						<span><?php echo yii::t('app','choose image')?></span>
						<input id="photoimg" type="file" name="photoimg" style="width:60px;">
					</span>
					
				 </label>
			</p>
			
			<p style="clear: both;min-height:90px;">
				<label>
					<span class='max_l'><?php echo yii::t('app','Cruise Desc')?>:</span>
					<textarea id='desc' name='desc'></textarea>
				</label>
			</p>
			
			
		</div>
		<div class="btn">
				<input style="cursor:pointer" type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
				
			</div>
		<?php 
		ActiveForm::end(); 
		?>

	</div>
        
    </div>
</div>
<!-- content end -->

<script>
window.onload = function(){
	UE.getEditor('desc');
	

$("#photoimg").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });

$("input[type=text]").each(function(){//聚焦是清除
	$(this).focus(function(){
		 $(this).parent().find("span.point").remove();
		 $(this).removeClass("point");
	});
 });
 $("textarea").focus(function(){
	 $(this).parent().find("span.point").remove();
	 $(this).removeClass("point");
});

//邮轮添加编辑页面判断邮轮code是否唯一
$('form#cruise_val').submit(function(){
    var a=0;
    var op = $(this).attr('class');
    var code = $("input#code").val();
    var name = $("input#name").val();
    var desc = $.trim($("textarea#desc").val());
    var file = $("input[type='file']").val();
    var number = $("input#number").val();
    var data = "<span class='point' ><?php echo yii::t('app','Required fields cannot be empty ')?></span>";
    var deck_data = "<span class='point' ><?php echo yii::t('app','Only the value of the input 1-20 ')?></span>";
    var desc = UE.getEditor('desc').getContentTxt();

    
    $("input[type=text]").each(function(e){	//如果文本框为空值			
		if($(this).val()==''){
			$(this).parent().append(data);
			$(this).addClass("point");
			a=1;
			return false;
		}
   	}); 
    if(a==1){return false;}
    if(number>20 || number<=0){
    	$("input#number").parent().append(deck_data);
    	$("input#number").addClass("point");
		return false;
        }
   	if(desc == ''){
   		Alert("<?php echo yii::t('app','Description cannot be empty')?>");
		return false;
   	}
   	if(file==''){
   	   	Alert("<?php echo yii::t('app','Please choose to upload pictures')?>");
   	   	return false;}

    if(code!='' && number!='' && name!='' && desc!=''){
    		var id = '';
    	
    	 $.ajax({
		        url:cruise_ajax_url,
		        type:'get',
		        data:'code='+code+'&act=2&id='+id,
		        async:false,
		     	dataType:'json',
		    	success:function(data){
		    		if(data==0) a=0;
		    		else{Alert("<?php echo yii::t('app','Code can\'t repeat!')?>");a=1;}
		    	}      
		    });
    }
   if(a == 1){
       return false;
   }
});

}
</script>