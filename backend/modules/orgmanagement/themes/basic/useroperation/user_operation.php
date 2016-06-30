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


<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Org Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','User Operation')?></a></div>
    
    <div class="searchResult">
    	<table style="margin-bottom: 20px;" id="user_operation_table">
    	<input type="hidden" id="user_operation_page" value="<?php echo $user_operation_pag;?>" />
    	<thead>
    		<tr>
	    		<th><input type="checkbox"></th>
	    		<th><?php echo yii::t('app','user')?></th>
	    		<th><?php echo yii::t('app','role')?></th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php foreach ($result as $k=>$v){?>
    		<tr>
    			<td><input type="checkbox" value="<?php echo $v['id']?>"></td>
    			<td><?php echo $v['username']?></td>
    			<td><?php echo $v['item_name']==''?'null':$v['item_name']?></td>
    		</tr>
    	<?php }?>
    	</tbody>
    	
    	</table>
    
        <div class="btn">
            <input id="set_up_user" type="button" value="<?php echo yii::t('app','Set up')?>"></input>
        </div>
        
        <!-- 分页 -->
        <div class="center" id="user_operation_page_div"> </div>
    </div>
    
    
    
</div>
<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 
	<?php $user_operation_total = (int)ceil($user_operation_count/2);
	if($user_operation_total >1){
	?>
		$('#user_operation_page_div').jqPaginator({
		    totalPages: <?php echo $user_operation_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#user_operation_page").val();
		    	if(this_page==num){$("input#user_operation_page").val('fail');return false;}

		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getuseroperationpage']);?>",
	                type:'get',
	                data:'pag='+num,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['id']+"'></input></td>";
	                            str += "<td>"+data[key]['username']+"</td>";
	                            if(data[key]['item_name']==''){var item_name = 'null';}else{var item_name=data[key]['item_name'];}
	                            str += "<td>"+item_name+"</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#user_operation_table > tbody").html(str);
	    	            }
	            	}      
	            });
	    	
	       	// $('#text').html('当前第' + num + '页');
	    	}
		});
	<?php }?>








	
	$(document).on('click','#set_up_user',function(){
		var length = $("table#user_operation_table tbody").find("input[type='checkbox']:checked").length;
		if(length==0){
			alert("Uncheck set items");return false;
		}

		
		$(".ui-widget-overlay").remove();
		$("#user_operation_float_div").remove();
		var str = "<div class='ui-widget-overlay ui-front'></div>";
		
		var data_str = '<div id="user_operation_float_div" style="position: absolute;left: 525px;z-index: 1050 !important;top: 200px;width:300px;min-height:250px;border:1px solid #ccc;background:#fff;">';
		data_str += "<p><span style='margin-left:20px;'>Role:</span></p>";
    	data_str += '<ul style="list-style:none;min-height:135px;">';
    	<?php foreach ($role_result as $v){?>
		data_str += "<li style='line-height:25px;'><input type='radio' value='<?php echo $v['name']?>' name='role_id'><span><?php echo $v['name']?></span></li>";
		<?php }?>
		data_str += '</ul>'
		data_str += '<div class="btn">';
        data_str += '<input id="set_confirm" type="button" style="margin-right:10px;" value="Confirm"></input>';
        data_str += '<input id="set_close" type="button" value="Close"></input>';
    	data_str += '</div></div>';

		
		$(document.body).append(str);
		$(document.body).append(data_str);
		//alert();
	});



	$(document).on('click','#set_confirm',function(){
		var user_data = '';
		$("table#user_operation_table tbody").find("input[type='checkbox']:checked").each(function(e){
			user_data += $(this).val()+',';
		});
		var data = $("#user_operation_float_div ul").find("input[name='role_id']:checked").val();
		if(data == undefined){
			alert("Uncheck permissions");
		}else{
			$.ajax({
		        url:"<?php echo Url::toRoute(['saveuseroperation']);?>",
		        type:'get',
		        async:false,
		        data:'data='+data+'&user_data='+user_data,
		     	dataType:'json',
		    	success:function(data){
		    		$(".ui-widget-overlay").remove();
		    		$("#user_operation_float_div").remove();
		    		if(data!=0){
		    			Alert('Save success');
		    			location.reload();
		    		}else{
		    			Alert('Save failed');
		    		}
		    	}      
		    });
		}
		
	});

	$(document).on('click','#set_close',function(){
		$(".ui-widget-overlay").remove();
		$("#user_operation_float_div").remove();
	});


	$("#user_operation_table thead th input[type='checkbox']").on('click',function(){
		   var check = $(this).is(":checked");
		   if(check){
			   $("#user_operation_table tbody tr").find("input[type='checkbox']").each(function(){
				   $(this).prop("checked","checked");
				});
		   }else{
			   $("#user_operation_table tbody tr").find("input[type='checkbox']").each(function(){
				   $(this).removeAttr("checked");
				});
		   }
		  
		});
}
</script>



