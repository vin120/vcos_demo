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
<style>
	#member_list .search { text-align: center; }
	#member_list .search label span { display: inline-block; width: 80px; text-align: right; }
</style>
	<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.2.min.js"></script>
	<script src="<?php echo $baseUrl?>js/jqPaginator.js"></script>	
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app', 'Org Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app', 'User')?></a></div>
		 <form id='member_list' method="post">
		    <div class="search">
		    <p>
		    <label >
            <span><?php echo yii::t('app', 'Code')?>:</span>
            <input type="text" style="width: 250px;" name="employee_code" value="<?php echo $employee_code?>"></input>
        	</label>
        	</p>
        	<p>
		    <label>
            <span><?php echo yii::t('app',  'Name')?>:</span>
            <input type="text" style="width: 250px" name="full_name" value="<?php echo $full_name?>"></input>
        	</label>
        	</p>
		    <p>
		    <label >
            <span><?php echo yii::t('app', 'Department')?>:</span>
            <select  style="width: 250px" name="department_id">
            <option value="" selected="selected">All</option>
          <?php foreach ($departmentinfo as $k=>$v):?>				
		 <option value="<?=$v['department_id']?>" <?=$v['department_id']==$department_id?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v['department_name'])?></option>
		 <?php endforeach;?>
            </select>
        	</label>
        	</p>
        	<p class="btn">
             <input type="submit" value="<?php echo yii::t('app', 'SEARCH')?>" style="cursor:pointer;"></input>
        	<input id="isclear" class="btn2" type="button" value="<?php echo yii::t('app', 'CLEAR')?>" style="cursor:pointer;"></input>
        	 </p>
    		</div>	
		 
		    <div class="searchResult" style="margin: 10px 20px;">
       		 <table id="travel_agent_table">
            <thead>
            <tr>
              	<th><input type=checkbox id="mycheck"></input></th>
                <th><?php echo yii::t('app', 'Num.')?></th>
                <th><?php echo yii::t('app', 'Code')?></th>
                <th><?php echo yii::t('app', 'Card')?></th>
                <th><?php echo yii::t('app', 'Name')?></th>
                <th><?php echo yii::t('app', 'Gender')?></th>
                <th><?php echo yii::t('app', 'Department')?></th>
                <th><?php echo yii::t('app', 'Dormitory')?></th>
                <th><?php echo yii::t('app', 'Telephone')?></th>
                <th><?php echo yii::t('app', 'Mobile')?></th>
                <th><?php echo yii::t('app', 'Date Of Entry')?></th>
                <th><?php echo yii::t('app', 'Operate')?></th>
	            </tr>
	            </thead>
	            <tbody>
	            <?php foreach($pagedata as $key=>$row){?>
	            <tr>
	         	 <td ><input type=checkbox name="ids[]" value="<?php echo $row['employee_code']?>" class="checkall"></input></td>
                <!-- <td><input type="checkbox" name="ids[]" value="echo $row['travel_agent_id'];"></input></td> -->
                <td><?php echo $key+1;?></td>
                <td><?php echo $row['employee_code'];?></td>
                <td><?php echo $row['employee_card_number'];?></td>
                <td><?php echo $row['full_name']?></td>
                <td><?php echo $row['gender']?></td>
                <td><?php echo $row['department_name']?></td>
                <td><?php echo $row['dormitory_num']?></td>
                <td><?php echo $row['telephone_num']?></td>
                <td><?php echo $row['mobile_num']?></td>
                <td><?php echo date("d/m/Y H:i:s",strtotime($row['date_of_entry']))?></td>
                <!-- <td><?php // echo yii::t('vcos', 'Reset')?></td> -->
                <!-- <td><?php //echo yii::t('vcos', 'Reset')?></td> -->
               	<td class="op_btn">
                    <a  href="<?php echo Url::toRoute(['option_user','id'=>$row['employee_code']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" id="<?php echo $row['employee_code'];?>" style="cursor:pointer"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            
            </tbody>
        </table>
        <p class="records"><?php echo yii::t('app', 'Records')?>:<span><?php echo $maxcount;?></span></p>
        <div class="btn">
            <input id="redictadd" type="button" value="<?php echo yii::t('app', 'Add')?>"></input>
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
$("input#isclear").click(function(){
	window.location = "<?php echo Url::toRoute(['index']);?>";
});
	$("#redictadd").click(function(){
		window.location = "<?php echo Url::toRoute(['option_user']);?>";
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
	   location.href="<?php echo Url::toRoute(['index']);?>"+"&code="+val;
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
