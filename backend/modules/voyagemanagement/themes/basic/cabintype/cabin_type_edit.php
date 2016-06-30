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
<style>
.pagination{display:inline-flex;}
</style>
<script type="text/javascript">
var cabin_type_ajax_url = "<?php echo Url::toRoute(['cabintypecodecheck']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabintype']);?>"><?php echo yii::t('app','Cabin Type')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Cabin_type_edit')?></a></div>
    
    <div class="tab">
		<ul class="tab_title">
			<li class="active"><?php echo yii::t('app','Basic')?></li>
			<li><?php echo yii::t('app','Graphic')?></li>
		</ul>
		<div class="tab_content">
			<div class="active">
				<div class="searchResult">
					<div id="service_write" class="write">

					<?php
						$form = ActiveForm::begin([
								'action' => ['cabintypesaveedit','code'=>$cabin_type_result['type_code']],
								'method'=>'post',
								'id'=>'cabin_type_val',
								'options' => ['class' => 'cabin_type_edit'],
								'enableClientValidation'=>false,
								'enableClientScript'=>false
						]); 
					?>
					<div  class="check_save_div">
					<input type="hidden" id="id" name="id" value="<?php echo $cabin_type_result['id']?>" />
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Cabin Type Code')?>:</span>
								<input type="text" maxlength="16" id='code' name='code' value="<?php echo $cabin_type_result['type_code']?>"></input>
								
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Cabin Type Name')?>:</span>
								<input type="text" maxlength="16" id="name" name="name" value="<?php echo $cabin_type_result['type_name']?>"></input>
								
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Live Number')?>:</span>
								<select name='live_number' id="live_number" class='input_select'>
									<option value='1' <?php echo $cabin_type_result['live_number']==1?"selected='selected'":'';?>>1</option>
									<option value='2' <?php echo $cabin_type_result['live_number']==2?"selected='selected'":'';?>>2</option>
									<option value='3' <?php echo $cabin_type_result['live_number']==3?"selected='selected'":'';?>>3</option>
									<option value='4' <?php echo $cabin_type_result['live_number']==4?"selected='selected'":'';?>>4</option>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Beds')?>:</span>
								<select name='beds' id="beds" class='input_select'>
									<option value='1' <?php echo $cabin_type_result['beds']==1?"selected='selected'":'';?>>1</option>
									<option value='2' <?php echo $cabin_type_result['beds']==2?"selected='selected'":'';?>>2</option>
									<option value='3' <?php echo $cabin_type_result['beds']==3?"selected='selected'":'';?>>3</option>
									<option value='4' <?php echo $cabin_type_result['beds']==4?"selected='selected'":'';?>>4</option>
								</select>
							</label>
						</p>
						
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Room Area')?>:</span>
								<?php $room = explode('-', $cabin_type_result['room_area']);?>
								<input type="text" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="room_min"  maxlength="3" name="room_min" style="width:35px" value="<?php echo $room[0];?>" /> -
								<input type="text" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="room_max" maxlength="3" name="room_max" style="width:35px" value="<?php echo $room[1];?>" /><?php echo yii::t('app','㎡')?>
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Floor')?>:</span>
								<input type="text" id='floor' maxlength="16" name='floor' value="<?php echo $cabin_type_result['floor']?>" ></input>
								
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','location')?>:</span>
								<select name="location" id="location" class='input_select'>
									<option value="0" <?php echo $cabin_type_result['location']==0?"selected='selected'":'';?>><?php echo yii::t('app','Port Side')?></option>
									<option value="1" <?php echo $cabin_type_result['location']==1?"selected='selected'":'';?>><?php echo yii::t('app','Starboard Side')?></option>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
								<select name="state" id="state" class='input_select'>
									<option value='1' <?php echo $cabin_type_result['type_status']==1?"selected='selected'":'';?>><?php echo yii::t('app','Avaliable')?></option>
									<option value='0' <?php echo $cabin_type_result['type_status']==0?"selected='selected'":'';?>><?php echo yii::t('app','Unavaliable')?></option>
								</select>
							</label>
						</p>
						
						<?php foreach($type_attr as $k=>$val){?>
						<p>
							<label>
								<span class='max_l'><?php echo $val['att_name']?>:</span>
								<input type="radio" name="att[<?php echo $k;?>]" id="att[<?php echo $k;?>]" value="<?php echo $val['id']?>" <?php echo !empty($val['type_id'])?"checked='checked'":'';?>/> <?php echo yii::t('app','Y')?>
								<input <?php echo !empty($val['type_id'])?'':"checked='checked'";?> type="radio" name="att[<?php echo $k;?>]" id="att[<?php echo $k;?>]" value="0" /> <?php echo yii::t('app','N')?>
							</label>
						</p>
						<?php }?>
					</div>
					<div class="btn">
							<input style="cursor:pointer" type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
							<input class="cancel" type="button" value="<?php echo yii::t('app','CANCEL')?>"></input>
						</div>
					<?php 
					ActiveForm::end(); 
					?>
			
				</div>
				</div>
			</div>
			<div>
				<div class="searchResult">
					<table id="cabin_type_graphic_table">
					<input type="hidden" id="cabin_type_graphic_page" value="<?php echo $graphic_pag;?>" />
						<thead>
							<tr>
								<th><?php echo yii::t('app','No.')?></th>
								<th><?php echo yii::t('app','Cabin Type Desc')?></th>
								<th><?php echo yii::t('app','Cabin Type Img')?></th>
								<th><?php echo yii::t('app','Status')?></th>
								<th><?php echo yii::t('app','Operate')?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($graphic_result as $key=>$row){?>
				            <tr>
				                <td><?php echo ($key+1);?></td>
				                <td><?php echo $row['graphic_desc'];?></td>
				                <td><img style="width:50px;height:50px;" src="<?php echo $baseUrl.'upload/'.$row['graphic_img'];?>" /></td>
				                <td><?php echo $row['status']?yii::t('vcos', 'Avaliable'):yii::t('vcos', 'Unavaliable');?></td>
				                <td class="op_btn">
				                    <a href="<?php echo Url::toRoute(['cabintypegraphicedit','id'=>$row['id']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
				                    <a class="delete" style="cursor:pointer" id="<?php echo $row['id'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
				                </td>
				            </tr>
				            <?php }?>
						</tbody>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span><?php echo $cabin_type_graphic_count;?></span></p>
					<div class="btn">
						<a href="<?php echo Url::toRoute(['cabintypegraphicadd','id'=>$cabin_type_result['id']]);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
					</div>
					<div class="center" id="cabin_type_graphic_page_div"> </div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- content end -->
<script type="text/javascript">
window.onload = function(){ 


	
	<?php $cabin_type_graphic_total = (int)ceil($cabin_type_graphic_count/2);
	if($cabin_type_graphic_total >1){
	?>
		$('#cabin_type_graphic_page_div').jqPaginator({
		    totalPages: <?php echo $cabin_type_graphic_total;?>,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#cabin_type_graphic_page").val();
		    	if(this_page==num){$("input#cabin_type_graphic_page").val('fail');return false;}
		    	
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getcabintypegraphicpage']);?>",
	                type:'get',
	                data:'pag='+num+'&type_id='+<?php echo $cabin_type_result['id'];?>,
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                        	str += "<td>"+(key+1)+"</td>";
	                            str += "<td>"+data[key]['graphic_desc']+"</td>";
	                            str += "<td><img style='width:50px;height:50px;' src='<?php echo $baseUrl.'upload/';?>"+data[key]['graphic_img']+"' /></td>";
	                           	if(data[key]['status']==1)
	                            	var status = "Avaliable";
	                            else if(data[key]['status']==0)
	                            	var status = "Unavaliable";
	                            str += "<td>"+status+"</td>";
	                            str += "<td  class='op_btn'>";
	                            str += "<a href='<?php echo Url::toRoute(['cabintypegraphicedit']);?>&id="+data[key]['id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
	                            str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
		                        str += "</td>";
	                            str += "</tr>";
	                          });
	    	                $("table#cabin_type_graphic_table > tbody").html(str);
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
	   location.href="<?php echo Url::toRoute(['cabintypegraphicdel']);?>"+"&id="+val;
   });


}
</script>
