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
	.write label span { width: 160px; }
	.write select.input_select{ width: 165px; height: 26px; }
	
	/* cabin */
	.selectBox { float: left; width: 100%; overflow: hidden; box-sizing: border-box; }
	.selectList { border: 1px solid #e0e9f4; }
	.selectList ul { width: 200px; margin: 0; padding: 0; list-style: none; }
	/*.selectList ul:first-child { background-color: #99bfee; }*/
	.selectList ul:last-child { max-height: 500px; overflow-y: scroll;min-height:300px; }
	.selectList li { display: table-row; }
	.selectList li > span { display: table-cell; padding: 10px; }
	.selectBox .btn input { display: block; margin: 20px; }
	
	#roles_input span.point {margin-left:5px; width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #roles_input span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
	#roles_input label.error { width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #roles_input label.error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
    #roles_input input.point { outline-color: #fe5d5d; border: 2px solid #fe5d5d; }
</style>
<script type="text/javascript">
var check_roles_name_ajax_url = "<?php echo Url::toRoute(['checkrolesname']);?>";
</script>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Org Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['roles']);?>"><?php echo yii::t('app','Roles')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#">Roles_add</a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class=" write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['rolesadd'],
					'method'=>'post',
					'id'=>'roles_val',
					'options' => ['class' => 'roles_add'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
		
				<div>
				<input type="hidden" id="item_list" name="item_list" value="" /> 
				<p>
						<label id="roles_input">
							<span><?php echo yii::t('app','Name')?>:</span>
							<input type="text" id="name" name="name"></input>
						</label>
					</p>
					
						<div class="searchResult selectBox" style="margin-top:20px;margin-left:120px;margin-bottom:20px;">
							<div class="l selectList">
								<ul >
									<li><span><input type="checkbox" id="check_left"></span></input><span><?php echo yii::t('app','No Selected')?></span></li>
								</ul>
								<ul  id="cabin_left_ul">
								<?php foreach ($result  as $k=>$v){?>
								<li><span><input type="checkbox"  value="<?php echo $v['name']?>"></span><span class="text"><?php echo $v['description']?></span></li>
								<?php }?>
								</ul>
							</div>
							<div class="btn l">
								<input id="cabin_right_but" type="button" value=" >> "></input>
								<input id="cabin_left_but" type="button" value=" << "></input>
							</div>
							<div class="l selectList">
							
								<ul>
									<li><span><input type="checkbox" id="check_right"></span></input><span><?php echo yii::t('app','Selected')?></span></li>
								</ul>
								<ul id="cabin_right_ul">
								
								
								</ul>
							</div>
						</div>
						
				</div>
				<div class="btn" style="margin-top:20px;">
					<input type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
					<a href="<?php echo Url::toRoute(['roles']);?>"><input class="cancle" type="button" value="<?php echo yii::t('app','CANCLE')?>"></input></a>
				</div>
		<?php 
		ActiveForm::end(); 
		?>

	</div>
        
    </div>
</div>
<!-- content end -->
<script type="text/javascript">
window.onload = function(){ 

	$(document).on('click','#cabin_right_but',function(){
		var str = '';
		//alert('right');
		//获取左边选中值
		$("#cabin_left_ul li").find("input[type='checkbox']:checked").each(function(e){
			var id = $(this).val();
			var text = $(this).parent().parent().find("span.text").text();
			
			str += '<li><span><input value="'+id+'" name="cabin_right_ids[]" type="checkbox"></span><span class="text">'+text+'</span></li>';
			$(this).parent().parent().remove();
		});
		
		$("#cabin_right_ul").append(str);
	});

	$(document).on('click','#cabin_left_but',function(){

		//alert('left');

		var str = '';
		//获取左边选中值
		$("#cabin_right_ul li").find("input[type='checkbox']:checked").each(function(e){
			var id = $(this).val();
			var text = $(this).parent().parent().find("span.text").text();
			
			str += '<li><span><input value="'+id+'" type="checkbox"></span><span class="text">'+text+'</span></li>';
			$(this).parent().parent().remove();
		});
		
		$("#cabin_left_ul").append(str);

			
	});

	$(document).on('click','#check_left',function(){
		var check = $(this).is(":checked");
		if(check==true){
			$("#cabin_left_ul").find("input[type='checkbox']").each(function(e){
				$(this).prop("checked","checked");
			});
		}else if(check==false){
			$("#cabin_left_ul").find("input[type='checkbox']").each(function(e){
				$(this).removeAttr("checked");
			});
		}
	});

	$(document).on('click','#check_right',function(){
		var check = $(this).is(":checked");
		if(check==true){
			$("#cabin_right_ul").find("input[type='checkbox']").each(function(e){
				$(this).prop("checked","checked");
			});
		}else if(check==false){
			$("#cabin_right_ul").find("input[type='checkbox']").each(function(e){
				$(this).removeAttr("checked");
			});
		}
	});

	$("input[type=text]").each(function(){//聚焦是清除
		$(this).focus(function(){
			 $(this).parent().find("span.point").remove();
			 $(this).removeClass("point");
		});
	 });
	
	$("form#roles_val").submit(function(){
		var data = "<span class='point' ><?php echo yii::t('app','Required fields cannot be empty ')?></span>";
		var only_data = "<span class='point' ><?php echo yii::t('app','Role name already exists, please change')?></span>";
	    var name = $("input[name='name']").val();
	    if(name==''){
	    	$("input[name='name']").parent().append(data);
	    	$("input[name='name']").addClass("point");
			return false;
		}
		var next = 1;
		//验证name是否唯一
		$.ajax({
		        url:"<?php echo Url::toRoute(['checkrolesnameonly']);?>",
		        type:'get',
		        async:false,
		        data:'name='+name,
		     	dataType:'json',
		    	success:function(data){
		    		if(data==0){
		    			$("input[name='name']").parent().append(only_data);
		    	    	$("input[name='name']").addClass("point");
		    	    	next = 0;
		    		}
		    	}      
		    });
	    if(next==0){return false;}
		
		var length = $("#cabin_right_ul").find("input[type='checkbox']").length;
		
		if(length==0){
			Alert("Uncheck permissions");return false;
		}
		var item_list = '';
		$("#cabin_right_ul").find("input[type='checkbox']").each(function(e){
			item_list +=  $(this).val()+',';
		});
		$("input[name='item_list']").val(item_list);
	});

	
}
</script>
