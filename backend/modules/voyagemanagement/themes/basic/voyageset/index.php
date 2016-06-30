<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetDate;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\components\Helper;


ThemeAsset::register($this);
ThemeAssetDate::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>

<!-- content start -->
<div class="r content">
<div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['index']);?>"><?php echo yii::t('app','Voyage Set')?></a></div>
    <?php
		$form = ActiveForm::begin([
			'method'=>'post',
			'enableClientValidation'=>false,
			'enableClientScript'=>false
		]); 
	?>
	<div class="search">
		<label>
			<span><?php echo yii::t('app','Voyage Name')?>:</span>
			<input type="text" maxlength="16" id="voyage_name" name="voyage_name" value="<?php echo $voyage_name ?>"></input>
		</label>
		<label>
			<span><?php echo yii::t('app','Start Time')?>:</span>
			<input type="text" id="s_time" name="s_time" placeholder="<?php echo yii::t('app','please choose')?>" value="<?php echo empty($s_time)?"":Helper::GetDate($s_time);?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',maxDate:'#F{$dp.$D(\'e_time\')}'})" class="Wdate" ></input>
		</label>
		<label>
		<span><?php echo yii::t('app','End Time')?>:</span>
			<input type="text" id="e_time" name="e_time" placeholder="<?php echo yii::t('app','please choose')?>" value="<?php echo empty($e_time)?"":Helper::GetDate($e_time);?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',minDate:'#F{$dp.$D(\'s_time\')}',startDate:'#F{$dp.$D(\'s_time\',{d:+1})}'})" class="Wdate" ></input>
		</label>
		<span class="btn"><input style="cursor:pointer" type="submit" value="<?php echo yii::t('app','SEARCH')?>"></input></span>
	</div>
	<?php
		ActiveForm::end();
	?>
	<div class="searchResult">
		<table id="voyage_table">
		 <input type="hidden" id="voyage_page" value="<?php echo $voyage_pag;?>" />
			<thead>
				<tr>
					<th><?php echo yii::t('app','Voyage Name')?></th>
					<th><?php echo yii::t('app','Voyage Code')?></th>
					<th><?php echo yii::t('app','Start Time')?></th>
					<th><?php echo yii::t('app','End Time')?></th>
					<th><?php echo yii::t('app','Operate')?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($voyage as $row ){ ?>
				<tr>
					<td><?php echo $row['voyage_name']?></td>
					<td><?php echo $row['voyage_code']?></td>
					<td><?php echo empty($row['start_time'])?"":Helper::GetDate($row['start_time']);?></td>
					<td><?php echo empty($row['end_time'])?"":Helper::GetDate($row['end_time']);?></td>
					<td>
						<a href="<?php echo Url::toRoute(['voyageedit']).'&voyage_id='.$row['id'];?>"><img src="<?=$baseUrl ?>images/write.png" ></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $count ?></span></p>
		<div class="btn">
			<a href="<?php echo Url::toRoute(['voyageadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
		</div>
		<!--分页-->
		 <div class="center" id="voyage_page_div"> </div>
	</div>
</div>
<!-- content end -->


<script type="text/javascript">
window.onload = function(){
	<?php $voyage_total = (int)ceil($count/2);
		if($voyage_total >1){
	?>
	$('#voyage_page_div').jqPaginator({
	    totalPages: <?php echo $voyage_total;?>,
	    visiblePages: 5,
	    currentPage: 1,
	    wrapper:'<ul class="pagination"></ul>',
	    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
	    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
	    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
	    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
	    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
	    onPageChange: function (num, type) {
	    	var this_page = $("input#voyage_page").val();
	    	if(this_page==num){$("input#voyage_page").val('fail');return false;}
	  
	    	var voyage_name = '<?php echo $voyage_name ?>';
	    	var s_time = '<?php echo $s_time ?>';
	    	var e_time = '<?php echo $e_time ?>';

	    	$.ajax({
                url:"<?php echo Url::toRoute(['getvoyagepage']);?>",
                type:'get',
                data:'pag='+num+'&voyage_name='+voyage_name+"&s_time="+s_time+"&e_time="+e_time,
             	dataType:'json',
            	success:function(data){
                	var str = '';
            		if(data != 0){
    	                $.each(data,function(key){
                        	str += "<tr>";	
                            str += "<td>"+data[key]['voyage_name']+"</td>";
                            str += "<td>"+data[key]['voyage_code']+"</td>";
                            var s_time = data[key]['start_time']==''?'':createDate(data[key]['start_time']);
                            str += "<td>"+s_time+"</td>";
                            var e_time = data[key]['end_time']==''?'':createDate(data[key]['end_time']);
                            str += "<td>"+e_time+"</td>";
                            str += "<td><a href='<?php echo Url::toRoute(['voyageedit']);?>&voyage_id="+data[key]['id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                        str += "</td>";
                            str += "</tr>";
                          });
    	                $("table#voyage_table > tbody").html(str);
    	            }
            	}      
            });
    	}
	});
	<?php }?>
}
</script>
