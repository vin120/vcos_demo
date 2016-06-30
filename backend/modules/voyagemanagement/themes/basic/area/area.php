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


<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Area')?></a></div>
    
    <div class="searchResult">
    <?php
			$form = ActiveForm::begin([
					'method'=>'post',
					'id'=>'area_from',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
        <table id="area_table">
        <input type="hidden" id="area_page" value="<?php echo $area_pag;?>" />
            <thead>
            <tr>
                <th><input type="checkbox"></input></th>
                <th><?php echo yii::t('app','No.')?></th>
                <th><?php echo yii::t('app','Area Code')?></th>
                <th><?php echo yii::t('app','Area Name')?></th>
                <th><?php echo yii::t('app','Status')?></th>
                <th>Operate</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($area_result as $key=>$row){?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $row['area_code'];?>"></input></td>
                <td><?php echo ($key+1);?></td>
                <td><?php echo $row['area_code'];?></td>
                <td><?php echo $row['area_name'];?></td>
                <td><?php echo $row['status']?yii::t('vcos', 'Avaliable'):yii::t('vcos', 'Unavaliable');?></td>
                <td class="op_btn">
                	<a href="<?php echo Url::toRoute(['areaupdate','code'=>$row['area_code']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                     <a class="delete" id="<?php echo $row['area_code'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a> 
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
       <?php 
		ActiveForm::end(); 
		?>
        <p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $area_count;?></span></p>
        <div class="btn">
        	<a href="<?php echo Url::toRoute(['areaupdate']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
            <input id="del_submit" type="button" value="Del Selected"></input>
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
        <div class="center" id="area_page_div"> </div>
    </div>
    
</div>
<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 
	<?php $area_total = (int)ceil($area_count/2);
	if($area_total >1){
	?>
		$('#area_page_div').jqPaginator({
		    totalPages: <?php echo $area_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);"><?php echo yii::t('app','First')?></a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);"><?php echo yii::t('app','Last')?></a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#area_page").val();
		    	if(this_page==num){$("input#area_page").val('fail');return false;}
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getareapage']);?>",
	                type:'get',
	                data:'pag='+num,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['area_code']+"'></input></td>";
	                            str += "<td>"+(key+1)+"</td>";
	                            str += "<td>"+data[key]['area_code']+"</td>";
	                            str += "<td>"+data[key]['area_name']+"</td>";
	                            if(data[key]['status']==1)
	                            	var status = "<?php echo yii::t('app','Avaliable')?>";
	                            else if(data[key]['status']==0)
	                            	var status = "<?php echo yii::t('app','Unavaliable')?>";
	                            str += "<td>"+status+"</td>";
	                            str += "<td  class='op_btn'>";
	                            str += '<a href="<?php echo Url::toRoute(['areaupdate']);?>&code='+data[key]['area_code']+'"><img src="<?=$baseUrl ?>images/write.png"></a>';
	                            str += "<a class='delete' id='"+data[key]['area_code']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#area_table > tbody").html(str);
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
	   location.href="<?php echo Url::toRoute(['area/area']);?>"+"&code="+val;
   });

 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form#area_from").submit();
   });


}
</script>



