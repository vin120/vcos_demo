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
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Cabin')?></a></div>
    <?php
			$form = ActiveForm::begin([
					'method'=>'post',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
    	<div class="search">
			 <label>
			<span><?php echo yii::t('app','Cabin Name')?>:</span>
			<input type="text" maxlength="16" name="w_name" value="<?php echo $w_name;?>"></input>
			</label>
			<label>
				<span><?php echo yii::t('app','Cabin Type Name')?>:</span>
				<input type="text" maxlength="16" name="w_p_name" value="<?php echo $w_p_name;?>"></input>
			</label>
			<label>
				<span><?php echo yii::t('app','Status')?>:</span>
				<select name="w_state">
					<option value="2" <?php echo $w_state==2?"selected='selected'":'';?>><?php echo yii::t('app','All')?></option>
	                <option value="1" <?php echo $w_state==1?"selected='selected'":'';?>><?php echo yii::t('app','Avaliable')?></option>
	                <option value="0" <?php echo $w_state==0?"selected='selected'":'';?>><?php echo yii::t('app','Unavaliable')?></option>
            </select>
			</label>
			<span class="btn"><input style="cursor:pointer" type="submit" name="w_submit" value="<?php echo yii::t('app','SEARCH')?>"></input></span>
		</div>
    <?php 
		ActiveForm::end(); 
		?>
    <div class="searchResult">
    <?php
			$form = ActiveForm::begin([
					'id'=>'cabin_from',
					'method'=>'post',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
        <table id="cabin_table">
        <input type="hidden" id="cabin_page" value="<?php echo $cabin_pag;?>" />
        
            <thead>
            <tr>
                <th><input type="checkbox"></input></th>
                <th><?php echo yii::t('app','Cabin Type Name')?></th>
                <th><?php echo yii::t('app','Cabin Name')?></th>
                <th><?php echo yii::t('app','Deck Num')?></th>
                <th><?php echo yii::t('app','Max Check In')?></th>
                <th><?php echo yii::t('app','Ieast Aduits Num')?></th>
                <th><?php echo yii::t('app','Status')?></th>
                <th><?php echo yii::t('app','Operate')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cabin_result as $key=>$row){?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $row['id'];?>"></input></td>
                <td><?php echo $row['type_name'];?></td>
                <td><?php echo $row['cabin_name'];?></td>
                <td><?php echo $row['deck_num'];?></td>
                <td><?php echo $row['max_check_in'];?></td>
                <td><?php echo $row['last_aduits_num'];?></td>
                <td><?php echo $row['status']?yii::t('vcos', 'Avaliable'):yii::t('vcos', 'Unavaliable');?></td>
                <td class="op_btn">
                    <a href="<?php echo Url::toRoute(['cabinedit','id'=>$row['id']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" style="cursor:pointer" id="<?php echo $row['id'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
       <?php 
		ActiveForm::end(); 
		?>
        <p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $cabin_count;?></span></p>
        <div class="btn">
            <a href="<?php echo Url::toRoute(['cabinadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
            <input id="del_submit" type="button" value="<?php echo yii::t('app','Del Selected')?>"></input>
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
        <div class="center" id="cabin_page_div"> </div>
    </div>
    
</div>
<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 
	<?php $cabin_total = (int)ceil($cabin_count/2);
	if($cabin_total >1){
	?>
		$('#cabin_page_div').jqPaginator({
		    totalPages: <?php echo $cabin_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#cabin_page").val();
		    	if(this_page==num){$("input#cabin_page").val('fail');return false;}


		    	var w_name = "<?php echo $w_name;?>";
		    	var w_p_name = "<?php echo $w_p_name;?>";
		    	var w_state = "<?php echo $w_state;?>";

		    	var where_data = "&w_p_name="+w_p_name+"&w_name="+w_name+"&w_state="+w_state; 
		    	
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getcabinpage']);?>",
	                type:'get',
	                data:'pag='+num+where_data,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['id']+"'></input></td>";
	                            str += "<td>"+data[key]['type_name']+"</td>";
	                            str += "<td>"+data[key]['cabin_name']+"</td>";
	                            str += "<td>"+data[key]['deck_num']+"</td>";
	                            str += "<td>"+data[key]['max_check_in']+"</td>";
	                            str += "<td>"+data[key]['last_aduits_num']+"</td>";
	                            if(data[key]['status']==1)
	                            	var status = "Avaliable";
	                            else if(data[key]['status']==0)
	                            	var status = "Unavaliable";
	                            str += "<td>"+status+"</td>";
	                            str += "<td  class='op_btn'>";
	                            str += "<a href='<?php echo Url::toRoute(['cabinedit']);?>&id="+data[key]['id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#cabin_table > tbody").html(str);
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
	   location.href="<?php echo Url::toRoute(['cabin']);?>"+"&id="+val;
   });

 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form#cabin_from").submit();
   });


}
</script>



