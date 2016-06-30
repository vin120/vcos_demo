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
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Preferential Way')?></a></div>
 
    <div class="searchResult">
        <table id="way_table">
        <input type="hidden" id="way_page" value="<?php echo $way_pag;?>" />
            <thead>
            <tr>
                <th><?php echo yii::t('app','No.')?></th>
                <th><?php echo yii::t('app','Strategy')?></th>
                <th><?php echo yii::t('app','Operate')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($way_result as $key=>$row){?>
            <tr>
            	<td><?php echo ($key+1);?></td>
                <td><?php echo $row['strategy_name'];?></td>
                <td class="op_btn">
                    <a href="<?php echo Url::toRoute(['preferentialwayedit','id'=>$row['id']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" style="cursor:pointer" id="<?php echo $row['id'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $way_count;?></span></p>
        <div class="btn">
            <a href="<?php echo Url::toRoute(['preferentialwayadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
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
        <div class="center" id="way_page_div"> </div>
    </div>
    
</div>
<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 
	<?php $way_total = (int)ceil($way_count/2);
	if($way_total >1){
	?>
		$('#way_page_div').jqPaginator({
		    totalPages: <?php echo $way_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#way_page").val();
		    	if(this_page==num){$("input#way_page").val('fail');return false;}
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getwaypage']);?>",
	                type:'get',
	                data:'pag='+num,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                        	str += "<td>"+(key+1)+"</td>";
	                            str += "<td>"+data[key]['strategy_name']+"</td>";
	                            str += "<td  class='op_btn'>";
	                            str += "<a href='<?php echo Url::toRoute(['preferentialwayedit']);?>&id="+data[key]['id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#way_table > tbody").html(str);
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
	   location.href="<?php echo Url::toRoute(['preferentialway']);?>"+"&id="+val;
   });


}
</script>



