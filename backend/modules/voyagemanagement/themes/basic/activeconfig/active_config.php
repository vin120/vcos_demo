<?php
$this->title = 'Voyage Management';

use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

?>


<!-- content start -->
<div class="r content" id="refundReason_content">
	<div class="topNav"><?php echo yii::t('app','Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Active Config')?> </a></div>
	<div class="searchResult">
	<?php
		$form = ActiveForm::begin([
			'method'=>'post',
			'enableClientValidation'=>false,
			'enableClientScript'=>false
		]); 
	?>
			<table id="active_table">
        	<input type="hidden" id="active_page" value="<?php echo $active_page;?>" />
			<thead>
				<tr>
					<th><input type="checkbox"></input></th>
					<th><?php echo yii::t('app','No.')?></th>
					<th><?php echo yii::t('app','Name')?></th>
					<th><?php echo yii::t('app','Status')?></th>
					<th><?php echo yii::t('app','Operate')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($actives as $key=>$row){?>
				<tr>
                	<td><input type="checkbox" name="ids[]" value="<?php echo $row['active_id']?>"></input></td>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $row['name'];?></td>
					<td><?php echo $row['status']?yii::t('vcos', 'Avaliable'):yii::t('vcos', 'Unavaliable');?></td>
					<td class='op_btn'>
                    	<a href="<?php echo Url::toRoute(['activeconfigedit']);?>&active_id=<?php echo $row['active_id']?>"><img src="<?=$baseUrl ?>images/write.png"></a>
						<a class="delete" style="cursor:pointer" id="<?php echo $row['active_id'];?>" ><img src="<?=$baseUrl ?>images/delete.png"></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<?php 
			ActiveForm::end(); 
		?>
		<p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $count?></span></p>
		<div class="btn">
			<a href="<?php echo Url::toRoute(['activeconfigadd']);?>" ><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
			<input id="del_submit" type="button" value="<?php echo yii::t('app','Del Selected')?>"></input>
		</div>
		 <!-- 分页 -->
        <div class="center" id="active_page_div"> </div>
	</div>
</div>
<!-- content end -->

<script type="text/javascript">
window.onload = function(){ 
	<?php $active_total = (int)ceil($count/2);
		if($active_total >1){
	?>
		$('#active_page_div').jqPaginator({
		    totalPages: <?php echo $active_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);"><?php echo yii::t('app','First')?></a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);"><?php echo yii::t('app','Last')?></a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#active_page").val();
		    	if(this_page==num){$("input#active_page").val('fail');return false;}
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getactivepage']);?>",
	                type:'get',
	                data:'pag='+num,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['active_id']+"'></input></td>";
	                            str += "<td>"+(key+1)+"</td>";
	                            str += "<td>"+data[key]['name']+"</td>";
	                            if(data[key]['status']==1)
	                            	var status = "<?php echo yii::t('app','Avaliable')?>";
	                            else if(data[key]['status']==0)
	                            	var status = "<?php echo yii::t('app','Unavaliable')?>";
	                            str += "<td>"+status+"</td>";
	                            str += "<td class='op_btn'>";
	                            str += "<a href='<?php echo Url::toRoute(['activeconfigedit']);?>&active_id="+data[key]['active_id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a class='delete' style='cursor:pointer' id='"+data[key]['active_id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#active_table > tbody").html(str);
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
	   location.href="<?php echo Url::toRoute(['activeconfig']);?>"+"&active_id="+val;
   });

 	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form:first").submit();
   });


}
</script>