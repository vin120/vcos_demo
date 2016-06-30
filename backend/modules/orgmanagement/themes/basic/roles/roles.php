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
    <div class="topNav"><?php echo yii::t('app','Org Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Roles')?></a></div>
    
    <div class="searchResult">
    <?php
			$form = ActiveForm::begin([
					'method'=>'post',
					'id'=>'roles_from',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
        <table id="roles_table">
        <input type="hidden" id="roles_page" value="<?php echo $roles_pag;?>" />
        
            <thead>
            <tr>
                <th><input type="checkbox"></input></th>
                <th><?php echo yii::t('app','Name')?></th>
                <th><?php echo yii::t('app','Operate')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($roles_result as $key=>$row){?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $row['name'];?>"></input></td>
                <td><?php echo $row['name'];?></td>
                <td class="op_btn">
                    <a href="<?php echo Url::toRoute(['rolesedit','name'=>$row['name']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" id="<?php echo $row['name'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
       <?php 
		ActiveForm::end(); 
		?>
        <p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $roles_count;?></span></p>
        <div class="btn">
            <a class="btn_list_first" href="<?php echo Url::toRoute(['rolesadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
            <a><input id="del_submit" type="button" value="<?php echo yii::t('app','Del Selected')?>"></input></a>
        </div>
        
<!--         <div class="pageNum"> -->
<!-- 					<span> -->
<!-- 						<a href="#" class="active">1</a> -->
<!-- 						<a href="#">2</a> -->
<!-- 						<a href="#">》</a> -->
<!-- 						<a href="#">Last</a> -->
<!-- 					</span> -->
<!--         </div> -->

        <!-- 分页 -->
        <div class="center" id="roles_page_div"> </div>
    </div>
    
</div>
<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 
	<?php $roles_total = (int)ceil($roles_count/2);
	if($roles_total >1){
	?>
		$('#roles_page_div').jqPaginator({
		    totalPages: <?php echo $roles_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#roles_page").val();
		    	if(this_page==num){$("input#roles_page").val('fail');return false;}

		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getrolespage']);?>",
	                type:'get',
	                data:'pag='+num,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['name']+"'></input></td>";
	                            str += "<td>"+data[key]['name']+"</td>";
	                            str += "<td  class='op_btn'>";
	                            str += "<a href='<?php echo Url::toRoute(['rolesedit']);?>&name="+data[key]['name']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a class='delete' id='"+data[key]['name']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#roles_table > tbody").html(str);
	    	            }
	            	}      
	            });
	    	
	       	// $('#text').html('当前第' + num + '页');
	    	}
		});
	<?php }?>

	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but",function(){
	   var val = $(this).attr('id');
	   location.href="<?php echo Url::toRoute(['roles']);?>"+"&name="+val;
   });

 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form#roles_from").submit();
   });

   $("#roles_table thead th input[type='checkbox']").on('click',function(){
	   var check = $(this).is(":checked");
	   if(check){
		   $("#roles_table tbody tr").find("input[type='checkbox']").each(function(){
			   $(this).prop("checked","checked");
			});
	   }else{
		   $("#roles_table tbody tr").find("input[type='checkbox']").each(function(){
			   $(this).removeAttr("checked");
			});
	   }
	  
	});


}
</script>



