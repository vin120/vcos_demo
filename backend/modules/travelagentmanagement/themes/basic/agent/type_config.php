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
<script type="text/javascript">
var type_config_get_level_ajax_url = "<?php echo Url::toRoute(['find_agent_type']);?>";
var type_config_submit_level_ajax_url = "<?php echo Url::toRoute(['save_travel_agent_level']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app', 'Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app', 'Type Config')?></a></div>
    <div>
    <?php
			$form = ActiveForm::begin([
					'method'=>'post',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
    <div class="search" style="margin-bottom:0;">
        <label>
            <span><?php echo yii::t('app', 'Level')?>:</span>
            <input type="text" name="travel_agent_level" value="<?php echo $travel_agent_level?>"></input>
        </label>
        <label>
            <span><?php echo yii::t('app', 'Status')?>:</span>
            <select name="status">
                <option value="2"><?php echo yii::t('app', 'All')?></option>
                <option value="1" <?php echo $status==1?"selected='selected'":''?>><?php echo yii::t('app', 'Avaliable')?></option>
                <option value="0" <?php echo $status==0?"selected='selected'":''?>><?php echo yii::t('app', 'Unavaliable')?></option>
            </select>
        </label>
        <span class="btn"><input type="submit" value="<?php echo yii::t('app', 'SEARCH')?>" style="cursor:pointer;"></input></span>
    </div>
    <?php 
		ActiveForm::end(); 
		?>
	</div>
    <div class="searchResult">
    <?php
			$form = ActiveForm::begin([
					'method'=>'post',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
        <table id="type_config_table">
         <input type="hidden" id="type_config_page" value="<?php echo $type_config_pag;?>" />
            <thead>
            <tr>
            
            <th><input type="checkbox" id="mycheck"></th>
                <th><?php echo yii::t('app', 'Number')?></th>
                <th><?php echo yii::t('app', 'Grade')?></th>
                <th><?php echo yii::t('app', 'Higher Grade')?></th>
                <th><?php echo yii::t('app', 'Status')?></th>
                <th><?php echo yii::t('app', 'Operate')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($type_config_result as $key=>$row){?>
            <tr>
          
              <td ><input type=checkbox class="checkall"   name="ids[]" value="<?php echo $row['id']?>"></input></td>
               <!--  <td><input type="checkbox" name="ids[]" value=" echo $row['id'];"></input></td> -->
                <td><?php echo $key+1;?></td>
                <td><?php echo  $row['travel_agent_level']?></td>
                <td><?php echo  $row['travel_agent_higher_level']==''?yii::t('app','null'):$row['travel_agent_higher_level']?></td>
                <td><?php echo $row['status']?yii::t('app', 'Avaliable'):yii::t('app', 'Unavaliable');?></td>
                <td class="op_btn">
                <a href="<?php echo Url::toRoute(['type_config_edit','id'=>$row['id']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a><!--  <a href="type_config_edit?id= echo  $row['id'] ?>"> -->
                <a class="delete" style="cursor:pointer;" id="<?php echo $row['id'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            
            </tbody>
        </table>
        <input type="hidden" name="seleteselect" id="seleteselect" value=""><!-- 识别按的是否是选择删除按钮 -->
        <?php 
		ActiveForm::end(); 
		?>
        <p class="records"><?php echo yii::t('app', 'Records')?>:<span><?php echo $type_config_count;?></span></p>
        <div class="btn">
           <input type="button" id="redictadd" value="<?php echo yii::t('app', 'Add')?>"></input>
            <input id="del_submit" type="button" value="<?php echo yii::t('app', 'Del Selected')?>"></input>
        </div>
       <!-- <div class="pageNum">
					<span>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">》</a>
						<a href="#">Last</a>
					</span>
        </div> --> 
        <!-- 分页 -->
        <div  class="pageNum" style="margin-left:40%" id="type_config_page_div"> </div>
    </div>
</div>
<!-- content end -->

<script type="text/javascript">
		$(function(){
			$("#redictadd").click(function(){//添加跳转
				window.location = "<?php echo Url::toRoute(['type_config_add']);?>";
				});
			$('#mycheck').click(function(){
				   if($(this).prop('checked')==true)
		            {
		                $(".checkall").prop("checked",true);
		            }
		            else {
		                $(".checkall").prop("checked",false);
		            }
             
				});
			});
window.onload = function(){ 
	<?php $type_config_total = (int)ceil($type_config_count/7);
	if ($type_config_total==0){
		$type_config_total=1;
	}

	?>
		$('#type_config_page_div').jqPaginator({
		    totalPages: <?php echo $type_config_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    first: '<a href="javascript:void(0);"><?php echo yii::t('app', 'First')?></a>',
		    prev: '<a href="javascript:void(0);">«</a>',
		    next: '<a href="javascript:void(0);">»</a>',
		    last: '<a href="javascript:void(0);"><?php echo yii::t('app', 'Last')?></a>',
		    page: '<a href="javascript:void(0);">{{page}}</a>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#type_config_page").val();
		    	var travel_agent_level=$("input[name=travel_agent_level]").val();
		    	var status=$("select[name=status]").val();
		    	var tts=num+","+travel_agent_level+","+status;
		    	if(this_page==num){$("input#type_config_page").val('fail');return false;}
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['get_type_config_page']);?>",
	                type:'get',
	                data:'tts='+tts,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' class='checkall' type='checkbox' value='"+data[key]['id']+"'></input></td>";
	                            str += "<td>"+(key+1)+"</td>";
	                            str += "<td>"+data[key]['travel_agent_level']+'  Grade'+"</td>";
	                            var higher_level = data[key]['travel_agent_higher_level']==''?'no':data[key]['travel_agent_higher_level']+' Grade';
	                            str += "<td>"+higher_level+"</td>";
	                            if(data[key]['status']==1)
	                            	var status = "Usable";
	                            else if(data[key]['status']==0)
	                            	var status = "Disabled";
	                            str += "<td>"+status+"</td>";
	                            str += "<td  class='op_btn'>";
	                            str += "<a href=type_config_edit?id="+data[key]['id']+"><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a style='margin-left:3px' class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#type_config_table > tbody").html(str);
	    	            }
	            	}      
	            });
	    	
	       	// $('#text').html('当前第' + num + '页');
	    	}
		});
	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but",function(){
	   var val = $(this).attr('id');
	   location.href="<?php echo Url::toRoute(['type_config']);?>"+"&code="+val;
   });
 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("#seleteselect").val("1");
	   $("form").get(1).submit();
   });
   $(document).on('click',"#promptBox > .btn .cancel_but",function(){
	   $("#seleteselect").val("");
	   $(".ui-widget-overlay").removeClass("ui-widget-overlay");//移除遮罩效果
	   $("#promptBox").hide();
   });

}
</script>
