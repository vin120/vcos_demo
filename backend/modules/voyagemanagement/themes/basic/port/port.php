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
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Port')?></a></div>
    <?php
		$form = ActiveForm::begin([
			'method'=>'post',
			'enableClientValidation'=>false,
			'enableClientScript'=>false
		]); 
	?>
    <div class="search">
	    <label>
			<span><?php echo yii::t('app','Port Name')?>:</span>
			<input type="text" maxlength="16" name="w_name" value="<?php echo $w_name;?>"></input>
		</label>
		<label>
			<span><?php echo yii::t('app','Country Code')?>:</span>
			<input type="text" maxlength="16" name="w_code" value="<?php echo $w_code;?>"></input>
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
			'method'=>'post',
			'id'=>'port_from',
			'enableClientValidation'=>false,
			'enableClientScript'=>false
		]); 
	?>
        <table id="port_table">
        <input type="hidden" id="port_page" value="<?php echo $port_pag;?>" />
            <thead>
            <tr>
                <th><input type="checkbox"></input></th>
                <th><?php echo yii::t('app','Port Code')?></th>
                <th><?php echo yii::t('app','Port Short Code')?></th>
                <th><?php echo yii::t('app','Country Code')?></th>
                <th><?php echo yii::t('app','Port Name')?></th>
                <th><?php echo yii::t('app','Status')?></th>
                <th><?php echo yii::t('app','Operate')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($port_result as $key=>$row){?>
            <tr>
                <td><input type="checkbox" name='ids[]' value="<?php echo $row['port_code'];?>"></input></td>
                <td><?php echo $row['port_code'];?></td>
                <td><?php echo $row['port_short_code'];?></td>
                <td><?php echo $row['country_code'];?></td>
                <td><?php echo $row['port_name'];?></td>
                <td><?php echo $row['status']?yii::t('vcos', 'Avaliable'):yii::t('vcos', 'Unavaliable');?></td>
                <td class="op_btn">
                    <a href="<?php echo Url::toRoute(['portedit','code'=>$row['port_code']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" style="cursor:pointer" id="<?php echo $row['port_code'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <?php 
		ActiveForm::end(); 
		?>
        <p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $port_count;?></span></p>
        <div class="btn">
            <a href="<?php echo Url::toRoute(['portadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
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
        <div class="center" id="port_page_div"> </div>
        
    </div>
</div>
<!-- content end -->


<script type="text/javascript">
window.onload = function(){ 
	<?php $port_total = (int)ceil($port_count/2);
	if($port_total >1){
	?>
		$('#port_page_div').jqPaginator({
		    totalPages: <?php echo $port_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#port_page").val();
		    	if(this_page==num){$("input#port_page").val('fail');return false;}
	
		    	var w_code = "<?php echo $w_code;?>";
		    	var w_name = "<?php echo $w_name;?>";
		    	var w_state = "<?php echo $w_state;?>";
		    	var where_data = "&w_code="+w_code+"&w_name="+w_name+"&w_state="+w_state; 
		    	
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getportpage']);?>",
	                type:'get',
	                data:'pag='+num+where_data,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['port_code']+"'></input></td>";
	                            str += "<td>"+data[key]['port_code']+"</td>";
	                            str += "<td>"+data[key]['port_short_code']+"</td>";
	                            str += "<td>"+data[key]['country_code']+"</td>";
	                            str += "<td>"+data[key]['port_name']+"</td>";
	                            if(data[key]['status']==1)
	                            	var status = "Avaliable";
	                            else if(data[key]['status']==0)
	                            	var status = "Unavaliable";
	                            str += "<td>"+status+"</td>";
	                            str += "<td class='op_btn'>";
	                            str += "<a href='<?php echo Url::toRoute(['portedit']);?>&code="+data[key]['port_code']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a class='delete' style='cursor:pointer' id='"+data[key]['port_code']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#port_table > tbody").html(str);
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
		   location.href="<?php echo Url::toRoute(['port']);?>"+"&code="+val;
	   });

	 //delete删除确定but
	   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
		   $("form#port_from").submit();
	   });
}
</script>

