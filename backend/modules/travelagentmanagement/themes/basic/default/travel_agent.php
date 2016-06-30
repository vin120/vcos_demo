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
	<script src="<?php echo $baseUrl?>js/jqPaginator.js"></script>	
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('vcos', 'Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('vcos', 'Travel Agent')?></a></div>
		 <form id='member_list' method="post">
		    <div class="search">
		    	<label>
            <span><?php echo yii::t('vcos', 'Travel Agent Code:')?></span>
            <input type="text" name="travel_agent_code" value="<?php echo yii::t('vcos', $travel_agent_code)?>"></input>
        </label>
        <label>
            <span><?php echo yii::t('vcos', 'Travel Agent Name:')?></span>
            <input type="text" name="travel_agent_name" value="<?php echo yii::t('vcos', $travel_agent_name)?>"></input>
        </label>
        <label>
            <span><?php echo yii::t('vcos', 'Status:')?></span>
            <select name="travel_agent_status">
                <option value="2"><?php echo yii::t('vcos','All')?></option>
                <option value="1"  <?php echo  $travel_agent_status==1?"selected='selected'":'2'?>><?php echo yii::t('vcos','Usable')?></option>
                <option value="0" <?php echo  $travel_agent_status==0?"selected='selected'":'2'?>><?php echo yii::t('vcos','Disabled')?></option>
            </select>
        </label>
        <span class="btn"><input type="submit" value="<?php echo yii::t('vcos', 'SEARCH')?>" style="cursor:pointer;"></input></span>
    </div>
   
    <div class="searchResult">
  
        <table id="travel_agent_table">
      
            <thead>
            <tr>
              	<th><input type=checkbox id="mycheck"></input></th>
                <th><?php echo yii::t('vcos', 'Number')?></th>
                <th><?php echo yii::t('vcos', 'Travel Agent Code')?></th>
                <th><?php echo yii::t('vcos', 'Travel Agent Name')?></th>
                <th><?php echo yii::t('vcos', 'Contact')?></th>
                <th><?php echo yii::t('vcos', 'Contact phone number')?></th>
                <th><?php echo yii::t('vcos', 'Travel Agent Level')?></th>
                <th><?php echo yii::t('vcos', 'Status')?></th>
                <!-- <th>Login password</th>
                <th>Pay password </th> -->
                <th><?php echo yii::t('vcos', 'Operate')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pagedata as $key=>$row){?>
            <tr>
          <td ><input type=checkbox name="ids[]" value="<?php echo $row['travel_agent_id']?>" class="checkall"></input></td>
                <!-- <td><input type="checkbox" name="ids[]" value="echo $row['travel_agent_id'];"></input></td> -->
                <td><?php echo $key+1;?></td>
                <td><?php echo $row['travel_agent_code'];?></td>
                <td><?php echo yii::t('vcos', mb_substr($row['travel_agent_name'],0,15,"utf-8"))?></td>
                <td><?php echo yii::t('vcos', $row['travel_agent_contact_name'])?></td>
                <td><?php echo yii::t('vcos',$row['travel_agent_phone'])?></td>
                <td><?php echo yii::t('vcos',isset($row['travel_agent_level'])?$row['travel_agent_level']:'null')?></td>
                <td><?php echo $row['travel_agent_status']?yii::t('vcos', 'Usable'):yii::t('vcos', 'Disabled');?></td>
                <!-- <td><?php // echo yii::t('vcos', 'Reset')?></td> -->
                <!-- <td><?php //echo yii::t('vcos', 'Reset')?></td> -->
               	<td class="op_btn">
                    <a  href="<?php echo Url::toRoute(['travel_agent_edit','id'=>$row['travel_agent_id']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" id="<?php echo $row['travel_agent_id'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            
            </tbody>
        </table>
        <p class="records"><?php echo yii::t('vcos', 'Records:')?><span><?php echo $maxcount;?></span></p>
        <div class="btn">
            <input id="redictadd" type="button" value="<?php echo yii::t('vcos', 'Add')?>"></input>
            <input id="del_submit" type="button" value="<?php echo yii::t('vcos', 'Del Selected')?>"></input>
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
			        <div class="pageNum" style="margin-left:40%">
				 	<input type='hidden' name='page' value="<?php echo $page?>">
                 	<input type='hidden' name='isPage' value="1">
                 	<div class="center" id="page_div"></div> 
	            	</div>
	            	<input type="hidden" name="seleteselect" id="seleteselect" value=""><!-- 识别按的是否是选择删除按钮 -->
	           	 	</form>	
    <!--  <div class="center" id="travel_agent_page_div"> </div> -->
    </div>
</div>
<!-- content end -->

<script type="text/javascript">
$(function(){
	$("#redictadd").click(function(){
		window.location = "<?php echo Url::toRoute(['travel_agent_add']);?>";
		});
	$('#mycheck').click(function(){/* 多选按钮  */
		   if($(this).prop('checked')==true)
         {
             $(".checkall").prop("checked",true);
         }
         else {
             $(".checkall").prop("checked",false);
         }
  
		});
	
});
jQuery(function($) {
	/* 获取参数 */
	//分页
	var page = <?php echo $page;?>;
		$('#page_div').jqPaginator({
            totalPages: <?php echo $count;?>,
            visiblePages: 5,
            currentPage: page,
         
            first:  '<a href="javascript:void(0);">First</a>',
            prev:   '<a href="javascript:void(0);">«</a>',
            next:   '<a href="javascript:void(0);">»</a>',
            last:   '<a href="javascript:void(0);">Last</a>',
            page:   '<a href="javascript:void(0);">{{page}}</a>',
            onPageChange: function (num) {
                var val = $("input[name='page']").val();
                if(num != val)
                {
                    $("input[name='page']").val(num);
                    $("input[name='isPage']").val(2);
                    $("form#member_list").submit();
                }
            }
        });	
	
});  
window.onload = function(){ 
	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but",function(){
	   var val = $(this).attr('id');
	   location.href="<?php echo Url::toRoute(['travel_agent']);?>"+"&code="+val;
   });

 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("#seleteselect").val("1");
	   $("form:first").submit();
   });
   $(document).on('click',"#promptBox > .btn .cancel_but",function(){
	   $("#seleteselect").val("");
	   $(".ui-widget-overlay").removeClass("ui-widget-overlay");//移除遮罩效果
	   $("#promptBox").hide();
	 
	   
	 
   });

}
</script>
