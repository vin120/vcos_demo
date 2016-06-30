<?php
$this->title = 'Voyage Management';

use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetDate;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUpload;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUeditor;

ThemeAsset::register($this);
ThemeAssetDate::register($this);
ThemeAssetUpload::register($this);
ThemeAssetUeditor::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$baseUrl_date = $this->assetBundles[ThemeAssetDate::className()]->baseUrl . '/';
$baseUrl_upload = $this->assetBundles[ThemeAssetUpload::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style type="text/css">

	.write p { overflow: hidden; }
	.write label { width: 324px; }
	.write label:first-child { float: left; margin-left: 5%; }
	.write label + label { float: right; margin-right: 15%; }
	.write label span { width: 140px; }
	.shortLabel { margin-right: 84px; }
	#desc{ display: inline-block; width: 50%; vertical-align: top; }
	
	/*upload*/
	.write .upload { width: auto; }
	.write .upload > span { line-height: 30px; vertical-align: top; }
	.uploadFileBox { display: inline-block; width: 280px; line-height: 20px; border: 1px solid #dcdcdc; border-radius: 4px; box-sizing: border-box; overflow: hidden; }
	.fileName { display: inline-block; width: 190px; line-height: 30px; margin-left: 10px; vertical-align: middle; overflow: hidden; }
	.uploadFile { float: right; position: relative; display: inline-block; background-color: #3f7fcf; padding: 6px 12px; overflow: hidden; color: #fff; text-decoration: none; text-indent: 0; line-height: 20px; }
	.uploadFile input { position: absolute; font-size: 100px; right: 0; top: 0; opacity: 0; }
	.price {border-radius: 4px; box-sizing: border-box; background-color:"#fff"}
	#map img {display: block; width: 40%; min-height: 400px; margin-bottom: 20px; border: 1px solid #dcdcdc; }
	
	
	
	/* cabin */
	.selectBox { float: left; width: 100%; overflow: hidden; box-sizing: border-box; }
	.selectList { border: 1px solid #e0e9f4; }
	.selectList ul { width: 200px; margin: 0; padding: 0; list-style: none; }
	.selectList ul:first-child { background-color: #99bfee; }
	.selectList ul:last-child { max-height: 500px; overflow-y: scroll; }
	.selectList li { display: table-row; }
	.selectList li > span { display: table-cell; padding: 10px; }
	.selectBox .btn input { display: block; margin: 20px; }
	
	.pagination{display:inline-flex;}
	
	.file_map {
    position: relative;
    display: inline-block;
    background: #D0EEFF;
    border: 1px solid #99D3F5;
    border-radius: 4px;
    padding: 4px 12px;
    overflow: hidden;
    color: #1E88C7;
    text-decoration: none;
    text-indent: 0;
    line-height: 20px;
	}
	.file_map input {
	    position: absolute;
	    font-size: 100px;
	    right: 0;
	    top: 0;
	    opacity: 0;
	}
	.file_map:hover {
	    background: #AADFFD;
	    border-color: #78C3F3;
	    color: #004974;
	    text-decoration: none;
	}

</style>
<script>
var  voyage_set_code_check_ajax_url = "<?php echo Url::toRoute(['voyagesetcodecheck']);?>";
</script>
<!-- content start -->
<div class="r content">
<div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['index']);?>"><?php echo yii::t('app','Voyage Set')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Voyage_set_edit')?></a></div>
	<div class="tab">
		<ul class="tab_title">
			<li class="active" id="tab_voyage"><?php echo yii::t('app','Voyage')?></li>
			<li id="tab_voyage_port"><?php echo yii::t('app','Voyage Port')?></li>
			<li id="tab_active"><?php echo yii::t('app','Active')?></li>
			<li id="tab_voyage_map"><?php echo yii::t('app','Voyage Map')?></li>
			<li id="tab_voyage_cabin"><?php echo yii::t('app','Cabin')?></li>
			<li id="tab_voyage_return_route"><?php echo yii::t('app','Return route')?></li>
		</ul>
		<div class="tab_content">
			<div class="active">
				<!-- voyage start -->
				<div class="write">
				<?php
					$form = ActiveForm::begin([
						'action' => ['voyageedit'],
						'method'=>'post',
						'id'=>'voyage_val',
						'options' => ['class' => 'voyage_edit','enctype'=>'multipart/form-data'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false
					]); 
				?>
				<input type="hidden" id="voyage_id" name="voyage_id" value="<?php echo $voyage['id']?>"></input>
				<input type="hidden" id="voyage_code" name="voyage_code" value="<?php echo $voyage['voyage_code']?>"></input>
					<div class="check_save_div">
						<p>
							<label>
								<span><?php echo yii::t('app','Voyage Code')?>:</span>
								<input type="text" id="voyage_code_1" name="voyage_code_1" style="cursor:not-allowed;background: #ccc" disabled="disabled" value="<?php echo $voyage['voyage_code']?>"></input>
							</label>
							<label>
								<span><?php echo yii::t('app','Voyage Name')?>:</span>
								<input type="text" id="voyage_name" name="voyage_name" value="<?php echo $voyage['voyage_name']?>" maxlength="16" ></input>
							</label>
							
						</p>
						<p>
							<label class="shortLabel">
								<span><?php echo yii::t('app','Area')?>:</span>
								<select name="area" id="area" style="width: 170px;">
									<?php foreach ($area as $row ){?>
									<option <?php echo $row['area_code']==$voyage['area_code']?"selected='selected'":'' ?>  value="<?php echo $row['area_code'];?>"><?php echo $row['area_name']?></option>
									<?php } ?>
								</select>
							</label>
							<label>
								<span><?php echo yii::t('app','Cruise')?>:</span>
								<select id="cruise" name="cruise" style="width: 170px;">
								<?php foreach($cruise as $row) {?>
									<option <?php echo $row['cruise_code']==$voyage['cruise_code']?"selected='selected'":'' ?> value="<?php echo $row['cruise_code']?>"><?php echo $row['cruise_name']?></option>
								<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span><?php echo yii::t('app','Start Time')?>:</span>
								<input type="text" id="s_time" name="s_time" placeholder="<?php echo yii::t('app','please choose')?>" value="<?php echo empty($voyage['start_time'])?date('d/m/Y H:i:s',strtotime('+3 month')):Helper::GetDate($voyage['start_time']);?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',maxDate:'#F{$dp.$D(\'e_time\')}'})" class="Wdate"  ></input>
							</label>
							<label>
								<span><?php echo yii::t('app','End Time')?>:</span>
								<input type="text" id="e_time" name="e_time" placeholder="<?php echo yii::t('app','please choose')?>" value="<?php echo empty($voyage['end_time'])?date('d/m/Y H:i:s',strtotime('+4 month')):Helper::GetDate($voyage['end_time']);?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',minDate:'#F{$dp.$D(\'s_time\')}',startDate:'#F{$dp.$D(\'s_time\',{d:+1})}'})" class="Wdate"  ></input>
							</label>
						</p>
						<p>
							<label class="upload">
								<span><?php echo yii::t('app','Scheduling')?>:</span>
								<label class="uploadFileBox">
									<span class="fileName"><?php echo yii::t('app','Select PDF')?>...</span>
									<a href="#" class="uploadFile">choose<input type="file" name="pdf" id="pdf"></input></a>
								</label>
							</label>
						</p>
						<p>
							<label >
								<span><?php echo yii::t('app','Desc')?>:</span>
								<textarea id="desc" name="desc"><?php echo $voyage['voyage_desc']?></textarea>
							</label>
						</p>
						
						<div class="price">
							<p>
								<label>
									<span><?php echo yii::t('app','Start booking time')?>:</span>
									<input type="text" id="s_book_time" name="s_book_time" placeholder="please choose" value="<?php echo empty($voyage['start_book_time'])?date('d/m/Y H:i:s',time()):Helper::GetDate($voyage['start_book_time']); ?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',maxDate:'#F{$dp.$D(\'e_book_time\')}'})" class="Wdate" ></input>
								</label>
								<label>
									<span><?php echo yii::t('app','Stop booking time')?>:</span>
									<input type="text" id="e_book_time" name="e_book_time" placeholder="please choose" value="<?php echo empty($voyage['stop_book_time'])?date('d/m/Y H:i:s',strtotime('+3 month')):Helper::GetDate($voyage['stop_book_time']); ?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',minDate:'#F{$dp.$D(\'s_book_time\')}',startDate:'#F{$dp.$D(\'s_book_time\',{d:+1})}',maxDate:'#F{$dp.$D(\'s_time\')}'})" class="Wdate"  ></input>
								</label>
							</p>
							<p>
								<label>
									<span><?php echo yii::t('app','Ticket Price')?>:</span>
									<input class="price_data" type="text" id="ticket_price"  onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')" name="ticket_price" value="<?php echo $voyage['ticket_price']?>" maxlength="10"></input>
								</label>
								<label>
									<span><?php echo yii::t('app','Ticket Taxes')?>(%):</span>
									<input type="text" id="ticket_taxes"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="ticket_taxes" value="<?php echo $voyage['ticket_taxes']?>" maxlength="3" ></input>
								</label>
							</p>
							<p>
								<label>
									<span><?php echo yii::t('app','Harbour Taxes')?>:</span>
									<input class="price_data" type="text" id="harbour_taxes" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"  name="harbour_taxes" value="<?php echo $voyage['harbour_taxes']?>" maxlength="10"></input>
								</label>
								<label>
									<span><?php echo yii::t('app','Deposit ratio')?>(%):</span>
									<input type="text" id="deposit_ratio" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="deposit_ratio" value="<?php echo $voyage['deposit_ratio']?>" maxlength="3" ></input>
								</label>
							</p>
						</div>
					</div>
					<div class="btn">
						<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','SAVE')?>"></input>
						<input class="cancel" type="button" value="<?php echo yii::t('app','CANCEL')?>" ></input>
					</div>
				</div>
				<?php 
					ActiveForm::end(); 
				?>
				<!-- voyage end -->
			</div>
			<div>
				<!-- voyage port start -->
				<?php
					$form = ActiveForm::begin([
						'action' => ['voyageeditdelete'],
						'method'=>'post',
						'id'=>'voyage_edit_delete',
						'options' => ['class' => 'voyage_edit_delete'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false
					]); 
				?>
				<input type="hidden" id="voyage_port_page" value="<?php echo $voyage_port_page;?>" />
				<input type="hidden" id="voyage_id" name="voyage_id" value="<?php echo $voyage['id'] ?>"></input>
				<table id="voyage_port_table">
					<thead>
						<tr>
							<th><input type="checkbox"></input></th>
							<th><?php echo yii::t('app','No.')?></th>
							<th><?php echo yii::t('app','Port Name')?></th>
							<th><?php echo yii::t('app','Arrival Time')?></th>
							<th><?php echo yii::t('app','Departure Time')?></th>
							<th><?php echo yii::t('app','Operation')?></th>
						</tr>
					</thead>
					<tbody>
						<!-- get data via ajax -->
					</tbody>
				</table>
				<?php 
					ActiveForm::end();
				?>
				<p class="records">Records:<span><?php echo $count ?></span></p>
		        <div class="btn">
		            <a href="<?php echo Url::toRoute(['voyageportadd']).'&voyage_id='.$voyage['id'];?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
		            <input id="del_submit" type="button" value="<?php echo yii::t('app','Del Selected')?>"></input>
		        </div>
		        <!-- pagination -->
        		<div class="center" id="voyage_port_page_div"> </div>
				<!-- voyage port end -->
			</div>
			<div >
			<!-- active start -->
			
			<?php
				$form = ActiveForm::begin([
					'action' => ['voyageactive'],
					'method'=>'get',
					'id'=>'voyage_active',
					'options' => ['class' => 'voyage_active','enctype'=>'multipart/form-data'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
				]); 
			?>
				<input type="hidden" name="voyage_active_id" value="<?php echo $voyage['id']?>" />
				<div class="div_active">
					<!-- get via ajax -->
				</div>
				<div class="btn">
					<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','Save')?>"  ></input>
				</div>
			<?php 
				ActiveForm::end();
			?>
				
				<!-- active end -->
			</div>
			<div id="map">
			<!-- voyage map start -->
			<?php
				$form = ActiveForm::begin([
					'action' => ['voyagemap'],
					'method'=>'post',
					'id'=>'voyage_map',
					'options' => ['class' => 'voyage_map','enctype'=>'multipart/form-data'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
				]); 
			?>
			
				<div class="div_voyage_map">
				<!-- get data via ajax -->
				
					<input type='hidden' name='voyage_map_id' value='' />
					<input type='hidden' name='map_id' value='' />
					<img id='ImgPr' src=''>
					<label class="uploadFileBox">
						<span class="fileName"><?php echo yii::t('app','Select IMG')?>...</span>
						<a href="#" class="uploadFile">choose<input type="file" name="photoimg" id="photoimg"></input></a>
					</label>
					<div class='btn'>
					<input type='submit' style="cursor:pointer" style='cursor:pointer' value='<?php echo yii::t('app','Upload')?>'></input>
					</div>	
					
				</div>
				<?php 
					ActiveForm::end();
				?>
				<!-- voyage map end -->
			</div>
			
			<div>
				<!-- cabin start -->
				<?php
					$form = ActiveForm::begin([
						'action' => ['voyagecabinsave'],
						'method'=>'post',
						'id'=>'voyage_cabin_form',
						'options' => ['class' => 'voyage_cabin'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false
					]); 
				?>	
					<div class="search">
						<!-- get data via ajax -->
					</div>
					
					<div class="searchResult selectBox" style="margin-top:20px;">
						<div class="l selectList">
							<div class="div_no_select">
								<!-- get data via ajax -->
							</div>
						</div>
						<div class="btn l">
							<input id="cabin_right_but" type="button" value=" >> "></input>
							<input id="cabin_left_but" type="button" value=" << "></input>
						</div>
						<div class="l selectList">
						
							<div class="div_select">
								<!-- get data via ajax -->
								
							</div>
						</div>
					</div>
					
					<div class="btn">
						<input id="voyage_cabin_save_but" style="cursor:pointer" type="button" value="<?php echo yii::t('app','Save')?>" style=" float: left; margin-left: 20%;"></input>
					</div>
				<?php 
					ActiveForm::end();
				?>
				<!-- cabin end -->
			</div>
			
			<div>
			<!-- Return route start -->
				<?php
					$form = ActiveForm::begin([
						'action' => ['returnvoyage'],
						'method'=>'get',
						'id'=>'return_voyage',
						'options' => ['class' => 'return_voyage'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false
					]); 
				?>
				
				<input type="hidden" name="return_voyage_id" value="<?php echo $voyage['id']?>" />
				<div class="div_return_route">
					<!-- get data via ajax -->
				</div>
				<div class="btn">
					<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','Save')?>" ></input>
				</div>
				<?php 
					ActiveForm::end();
				?>
				<!-- Return route end -->
			</div>
		</div>
	</div>
</div>
<!-- content end -->
<script type="text/javascript">
window.onload = function(){
	UE.getEditor('desc');
	$("#photoimg").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });

	//tab voyage port
	$(document).on('click','#tab_voyage_port',function(){
		var count = 0;
		$.ajax({
            url:"<?php echo Url::toRoute(['getvoyageportajax']);?>",
            type:'get',
            async:false,
            data:"voyage_id="+<?php echo $voyage['id']?>,
         	dataType:'json',
        	success:function(res){
            	var str = '';
        		if(res != 0){
        			count = res['count'];
        			var data = res['result'];
	                $.each(data,function(key){
                    	str += "<tr>";
                        str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['id']+"'></input></td>";
                        str += "<td>"+data[key]['order_no']+"</td>";
                        str += "<td>"+data[key]['port_name']+"</td>";
                        if(data[key]['ETA']==null){var eta='- -';}else{var eta=createDate(data[key]['ETA']);}
                        if(data[key]['ETD']==null){var etd='- -';}else{var etd=createDate(data[key]['ETD']);}
                        str += "<td>"+eta+"</td>";
                        str += "<td>"+etd+"</td>";
                        str += "<td  class='op_btn'>";
                        str += "<a href='<?php echo Url::toRoute(['voyageportedit']);?>&voyage_id="+<?php echo $voyage['id']?>+"&port_id="+data[key]['id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
                        str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
                        str += "</td>";
                        str += "</tr>";
                      });
	                $("table#voyage_port_table > tbody").html(str);
	            }else{
	            	$("table#voyage_port_table > tbody").html('');
		            }

        		$("input#voyage_port_page").val(1);
        	}      
        });

		var voyage_port_total = parseInt(Math.ceil(count/2));
		if(voyage_port_total >1){
			$('#voyage_port_page_div').jqPaginator({
			    totalPages: voyage_port_total,
			    visiblePages: 5,
			    currentPage: 1,
			    wrapper:'<ul class="pagination"></ul>',
			    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
			    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
			    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
			    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
			    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
			    onPageChange: function (num, type) {
			    	var this_page = $("input#voyage_port_page").val();
			    	if(this_page==num){$("input#voyage_port_page").val('fail');return false;}
			    	
			    	$.ajax({
		                url:"<?php echo Url::toRoute(['getvoyageportpage']);?>",
		                type:'get',
		                data:'pag='+num+"&voyage_id="+<?php echo $voyage['id']?>,
		             	dataType:'json',
		            	success:function(data){
		                	var str = '';
		            		if(data != 0){
		    	                $.each(data,function(key){
		                        	str += "<tr>";
		                            str += "<td><input name='ids[]' type='checkbox' value='"+data[key]['id']+"'></input></td>";
		                            str += "<td>"+data[key]['order_no']+"</td>";
		                            str += "<td>"+data[key]['port_name']+"</td>";
		                            if(data[key]['ETA']==null){var eta='- -';}else{var eta=createDate(data[key]['ETA']);}
		                            if(data[key]['ETD']==null){var etd='- -';}else{var etd=createDate(data[key]['ETD']);}
		                            str += "<td>"+eta+"</td>";
		                            str += "<td>"+etd+"</td>";
		                            str += "<td  class='op_btn'>";
		                            str += "<a href='<?php echo Url::toRoute(['voyageportedit']);?>&voyage_id="+<?php echo $voyage['id']?>+"&port_id="+data[key]['id']+"'><img src='<?=$baseUrl ?>images/write.png'></a>";
		                            str += "<a class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
			                        str += "</td>";
		                            str += "</tr>";
		                          });
		    	                $("table#voyage_port_table > tbody").html(str);
		    	            }
		            	}      
		            });
		    	}
			});
		}	
	});

	//tab active
	$(document).on('click','#tab_active',function(){
		
		$.ajax({
            url:"<?php echo Url::toRoute(['getactiveajax']);?>",
            type:'get',
            data:"voyage_id="+<?php echo $voyage['id']?>,
         	dataType:'json',
        	success:function(data){
            	var str = '';
            	
        		if(data != 0){
        			
	            	var active = data['active'];
	            	var curr_active = data['curr_active'];
	            	str += "<p>";
					str +="<label>";
					str +="<span><?php echo yii::t('app','Curr Active')?>:</span>";
					str +="<span style='color:red'>"+curr_active['name']+"</span>";
					str +="</label>";
					str +="</p>";
					str +="<p>";
					str +="<label>";
					str +="<span><?php echo yii::t('app','Active Type')?>:</span>";
					str +="<select name='voyage_active'>";
					$.each(active,function(k){
						str +="<option value='"+active[k]['active_id']+"'>"+active[k]['name']+"</option>";   	
					});
					str +="</select>";
					str +="</label>";
					str +="</p>";
	                $(".div_active").html(str);
	            }
        	}      
        });	
	});


	
	//tab map
	$(document).on('click','#tab_voyage_map',function(){
		$.ajax({
            url:"<?php echo Url::toRoute(['getvoyagemapajax']);?>",
            type:'get',
            data:"voyage_id="+<?php echo $voyage['id']?>,
         	dataType:'json',
        	success:function(data){
            	var str = '';
        		if(data != 0){
	            	var map_result = data['map_result'];

	            	var src = "<?php echo $baseUrl.'upload/'?>"+map_result['map_img'];
					$("div.div_voyage_map input[name='voyage_map_id']").val(<?php echo $voyage['id']?>);
					$("div.div_voyage_map input[name='map_id']").val(map_result['map_id']);
					$("div.div_voyage_map img#ImgPr").attr('src',src);

	            	
	            }
        	}      
        });	
	});

	//tab cabin
	$(document).on('click','#tab_voyage_cabin',function(){
		$.ajax({
            url:"<?php echo Url::toRoute(['getcabinajax']);?>",
            type:'get',
            data:'voyage_id='+<?php echo $voyage['id']?>,
         	dataType:'json',
        	success:function(data){
            	var str = '';
            	var i = 0;
        		if(data != 0){
            		
	            	var cabin_result = data['cabin_result'];
	            	var cabin_type_result = data['cabin_type_result'];
	            	var really_cabin_result = data['really_cabin_result'];
	            	var cruise_result = data['cruise_result'];

	            	//type deck
	            	var str = '';
	            	str += "<input type='hidden' name='cabin_voyage_id' value='<?php echo $voyage['id']?>' />";
	            	str += "<label>";
					str += "<span><?php echo yii::t('app','Type')?>:</span>";
					str += "<select name='cabin_type_id'>";
					$.each(cabin_type_result,function(key){
						str +="<option value='"+cabin_type_result[key]['id']+"'>"+cabin_type_result[key]['type_name']+"</option>";   	
					});
					str += "</select>";
					str += "</label>";
					str += "<label>";
					str += "<span><?php echo yii::t('app','Deck')?>:</span>";
					str += "<select name='cabin_deck'>";
					
					for(i=1; i<=cruise_result['deck_number'];i++){
						str +="<option value='"+i+"'>"+i+"</option>"; 
					}
					str += "</select>";
					str += "</label>";
	                $(".search").html(str);


	                //no select
					var str_no_select='';
					str_no_select += "<ul>";
					str_no_select += "<li><span><input type='checkbox' id='canbin_check_left'></span></input><span><?php echo yii::t('app','No Selected')?></span></li>";
					str_no_select += "</ul>";
					str_no_select += "<ul  id='cabin_left_ul'>";
					var really_arr = new Array;
					$.each(really_cabin_result,function(key){
						really_arr[key] = 	really_cabin_result[key]['cabin_lib_id'];
					});
					$.each(cabin_result,function(key){
						//if(really_arr.indexOf(cabin_result[key]['id'])){
						if($.inArray(cabin_result[key]['id'], really_arr)==-1){
							str_no_select += "<li><span><input type='checkbox'  c_max='"+cabin_result[key]['max_check_in']+"' c_last='"+cabin_result[key]['last_aduits_num']+"'  value='"+cabin_result[key]['id']+"'></span><span class='text'>"+cabin_result[key]['cabin_name']+"</span></li>";
						}
					});
					str_no_select += "</ul>";
					$(".div_no_select").html(str_no_select);

					//select
					var str_select = '';
					str_select += "<ul>";
					str_select += "<li><span><input type='checkbox' id='canbin_check_right'></span></input><span><?php echo yii::t('app','Selected')?></span></li>";
					str_select += "</ul>";
					str_select += "<ul id='cabin_right_ul'>";
					$.each(really_cabin_result,function(key){
						str_select += "<li><span><input type='checkbox' name='cabin_right_ids[]' value='"+really_cabin_result[key]['cabin_lib_id']+"' ><input type='hidden' name='c_id[]' value='"+really_cabin_result[key]['cabin_lib_id']+"' /><input type='hidden' name='c_name[]' value='"+really_cabin_result[key]['cabin_name']+"'><input type='hidden' name='c_max[]' value='"+really_cabin_result[key]['max_check_in']+"' /><input type='hidden' name='c_last[]' value='"+really_cabin_result[key]['last_aduits_num']+"' /></span><span class='text'>"+really_cabin_result[key]['cabin_name']+"</span></li>";
					});
					str_select += "</ul>";
					$(".div_select").html(str_select);
	            }
        	}      
        });	
	});

	// tab return route
	$(document).on('click','#tab_voyage_return_route',function(){
		$.ajax({
            url:"<?php echo Url::toRoute(['getreturnrouteajax']);?>",
            type:'get',
            data:"voyage_id="+<?php echo $voyage['id']?>,
         	dataType:'json',
        	success:function(data){
            	var str = '';
        		if(data != 0){
	            	var curr_return_voyage_result = data['curr_return_voyage_result'];
	            	var voyage_return = data['voyage_return'];
	            	var str = '';
	            	str += "<p>";
	            	str += "<label>";
	            	str += "<span><?php echo yii::t('app','Curr Route')?>:</span>";
	            	str += "<span style='color:red'>"+curr_return_voyage_result['voyage_name']+"</span>";
	            	str += "</label>"
	            	str += "</p>";
	            	str += "<p>";
	            	str += "<label>";
	            	str += "<span><?php echo yii::t('app','Return Route')?>:</span>";
	            	str += "<select name='return_voyage'>";
	            	$.each(voyage_return,function(key){
	            		str += "<option value='"+voyage_return[key]['id']+"'>"+voyage_return[key]['voyage_name']+"</option>";
					});
	            	str += "</select>";
	            	str += "</label>";
	            	str += "</p>";
	                $(".div_return_route").html(str);
	            }
        	}      
        });	
	});
	
	
	
	
	// 上传文件功能
	$(".uploadFile").on("change","input[type='file']",function(){
		var filePath = $(this).val();
		var arr=filePath.split('\\');
		var fileName=arr[arr.length-1];
		$(".fileName").html(fileName);
		$(".fileName").attr("title",fileName);
	});
	
	//船舱保存
	$(document).on('click',"#voyage_cabin_form #voyage_cabin_save_but",function(){
			var length = $("#voyage_cabin_form ul#cabin_right_ul").find("input[type='checkbox']").length;
			if(length==0){
				alert("No selected items!");return false;
				}
			$("form#voyage_cabin_form").submit(); 
	});


	//航线-》船舱船舱类型改变
	$(document).on('change',"#voyage_cabin_form select[name='cabin_type_id'],#voyage_cabin_form select[name='cabin_deck']",function(){
		var type_id = $("#voyage_cabin_form select[name='cabin_type_id']").val();
		var deck = $("#voyage_cabin_form select[name='cabin_deck']").val();
		$.ajax({
	        url:"<?php echo Url::toRoute(['voyagecabinchangetypegetcabinlib']);?>",
	        type:'get',
	        async:false,
	        data:'type_id='+type_id+'&deck='+deck,
	     	dataType:'json',
	    	success:function(data){
	    		if(data!=0){
	    			var cabin_lib_result = data['cabin_lib'];
	    			var really_result = data['really'];
					var str = '';
					var really_arr = new Array();
	    			$.each(really_result,function(k){
	    				str += '<li><span><input value="'+really_result[k]['cabin_lib_id']+'"  name="cabin_right_ids[]" type="checkbox"><input type="hidden" name="c_id[]" value="'+really_result[k]['cabin_lib_id']+'" /><input type="hidden" name="c_name[]" value="'+really_result[k]['cabin_name']+'" /><input type="hidden" name="c_max[]" value="'+really_result[k]['max_check_in']+'" /><input type="hidden" name="c_last[]" value="'+really_result[k]['last_aduits_num']+'"></span><span class="text">'+really_result[k]['cabin_name']+'</span></li>';
	    				really_arr.push(really_result[k]['cabin_lib_id']);
	    			});
	    			$("#cabin_right_ul").html(str);
	    			var l_str = '';
	    			$.each(cabin_lib_result,function(k){
		    			if($.inArray(cabin_lib_result[k]['id'],really_arr)==-1){
	    					l_str += '<li><span><input value="'+cabin_lib_result[k]['id']+'" c_max="'+cabin_lib_result[k]['max_check_in']+'" c_last="'+cabin_lib_result[k]['last_aduits_num']+'" type="checkbox"></span><span class="text">'+cabin_lib_result[k]['cabin_name']+'</span></li>';
		    			}
	    			});
	    			$("#cabin_left_ul").html(l_str);
	    		}else{
	    			
	    		}
	    	}      
	    });
	});

	//点击全选--左边
	$(document).on('click','#canbin_check_left',function(){
		var check = $(this).is(":checked");
		if(check==true){
			$("#cabin_left_ul").find("input[type='checkbox']").each(function(e){
				$(this).prop("checked","checked");
			});
		}else if(check==false){
			$("#cabin_left_ul").find("input[type='checkbox']").each(function(e){
				$(this).removeAttr("checked");
			});
		}
	});

	//点击全选--右边
	$(document).on('click','#canbin_check_right',function(){
		var check = $(this).is(":checked");
		if(check==true){
			$("#cabin_right_ul").find("input[type='checkbox']").each(function(e){
				$(this).prop("checked","checked");
			});
		}else if(check==false){
			$("#cabin_right_ul").find("input[type='checkbox']").each(function(e){
				$(this).removeAttr("checked");
			});
		}
	});



	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but",function(){
	   var val = $(this).attr('id');
	   location.href="<?php echo Url::toRoute(['voyageeditdelete']);?>"+"&id="+val+"&voyage_id="+"<?php echo $voyage['id']?>";
   });

 	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form#voyage_edit_delete").submit();
   });


	

}
</script>