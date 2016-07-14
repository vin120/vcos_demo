<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use travelagent\components\Helper;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';
?>

<!-- main content start -->
<div id="surchargeAndCabinAssignments" class="mainContent">
	<div id="topNav">
    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
	<a href="<?php echo Url::toRoute(['bookingticket','code'=>$code])?>"><?php echo yii::t('app','Reservation')?></a>&nbsp;&gt;&gt;&nbsp;
	<a href="<?php echo Url::toRoute(['inputmode','code'=>$code])?>"><?php echo yii::t('app','Input mode')?></a>&nbsp;&gt;&gt;&nbsp;
	<a href="<?php echo Url::toRoute(['adduestinfo','code'=>$code])?>"><?php echo yii::t('app','Add Guest Infomation')?></a>&nbsp;&gt;&gt;&nbsp;
	<a href="<?php echo Url::toRoute(['chooseandreservation','code'=>$code])?>"><?php echo yii::t('app','Choose Cabin &amp; Reservation Quantity')?></a>&nbsp;&gt;&gt;&nbsp;
	<a href="#"><?php echo yii::t('app','Surcharge &amp; Cabin Assignments')?></a>
	</div>
	<div id="mainContent_content" class="pBox">
		<h2><?php echo yii::t('app','Shore Excursions')?></h2>
		
		<?php foreach ($shore as $key=>$row):?>
		<!-- foreach  -->
		<div class="accordion">
			<div class="head clearfix pBox">
				<div class="l">
					<label>
						<?php echo ($key+1)?>.
						<span class="shore_title_id" id="<?php echo $row['se_code']?>"><?php echo $row['se_name']?></span>
					</label>
				</div>
				<div class="r accordionBtn">
					<a href="#"><?php echo yii::t('app','Detail')?><i>></i></a>
					<a href="#"><?php echo yii::t('app','Select Guests')?><i>></i></a>
				</div>
			</div>
			<div class="body">
				<div class="pBox">
				<?php echo $row['se_info'];?>
				<!--  
					<h3>01/28 Without Meals</h3>
					<p>Travel time:1 hours;tour time:4 hours</p>
					<p><em>[Jeju,jeju Folk Museum of natural history]</em> info in 1984 Jeju Folk Museum of natural history displays originally scattered in Jeju's traditional folk relics, natural historical sites and other precious items and information. The museum is divided info the natural history of the exhibition hall and second first folk exhibition hall and outdoor exhibition hall.</p>
					<p><em>[Jeju,jeju Folk Museum of natural history]</em> info in 1984 Jeju Folk Museum of natural history displays originally scattered in Jeju's traditional folk relics, natural historical sites and other precious items and information. The museum is divided info the natural history of the exhibition hall and second first folk exhibition hall and outdoor exhibition hall.</p>
					<p><em>[Jeju,jeju Folk Museum of natural history]</em> info in 1984 Jeju Folk Museum of natural history displays originally scattered in Jeju's traditional folk relics, natural historical sites and other precious items and information. The museum is divided info the natural history of the exhibition hall and second first folk exhibition hall and outdoor exhibition hall.</p>
				-->
				</div>
				<div class="pBox shore_div" sh_id="<?php echo $row['se_code']?>">
					<!-- <label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label> -->
				</div>
			</div>
		</div>
		<!-- endforeach -->
		<?php endforeach;?>
		
		<h2 class="mgt"><?php echo yii::t('app','Insurance')?></h2>
		
		
		<?php foreach($surcharge as $key=>$row):?>
		<!-- foreach start -->
		<div class="accordion">
			<div class="head clearfix pBox">
				<div class="l">
					<label>
						<?php echo ($key+1);?>.
						<span id="<?php echo $row['cost_id']?>"><?php echo $row['cost_name']?></span>
					</label>
				</div>
				<div class="r accordionBtn">
					<a href="#">Detail<i>></i></a>
					<a href="#">Select Guests<i>></i></a>
				</div>
			</div>
			<div class="body">
				<div class="pBox">
				<?php echo $row['cost_desc']?>
				<!-- 
					<h3>01/28 Without Meals</h3>
					<p>Travel time:1 hours;tour time:4 hours</p>
					<p><em>[Jeju,jeju Folk Museum of natural history]</em> info in 1984 Jeju Folk Museum of natural history displays originally scattered in Jeju's traditional folk relics, natural historical sites and other precious items and information. The museum is divided info the natural history of the exhibition hall and second first folk exhibition hall and outdoor exhibition hall.</p>
					<p><em>[Jeju,jeju Folk Museum of natural history]</em> info in 1984 Jeju Folk Museum of natural history displays originally scattered in Jeju's traditional folk relics, natural historical sites and other precious items and information. The museum is divided info the natural history of the exhibition hall and second first folk exhibition hall and outdoor exhibition hall.</p>
					<p><em>[Jeju,jeju Folk Museum of natural history]</em> info in 1984 Jeju Folk Museum of natural history displays originally scattered in Jeju's traditional folk relics, natural historical sites and other precious items and information. The museum is divided info the natural history of the exhibition hall and second first folk exhibition hall and outdoor exhibition hall.</p>
			 	-->
				</div>
				<div class="pBox insurance_div" in_id="<?php echo $row['cost_id']?>">
					<!-- <label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label>
					<label>
						<input type="checkbox"></input>
						<span>ZHANG SAN</span>
					</label> -->
				</div>
			</div>
		</div>
		<!-- endforeach -->
		<?php endforeach;?>
		
		
		
		<h2 class="mgt"><?php echo yii::t('app','Cabin Assignments')?></h2>
		<table id="room_div">
			<thead>
				<tr>
					<th><?php echo yii::t('app','Room')?></th>
					<th><?php echo yii::t('app','Cabin Type')?></th>
					<th><?php echo yii::t('app','Guest1')?></th>
					<th><?php echo yii::t('app','Guest2')?></th>
					<th><?php echo yii::t('app','Guest3')?></th>
					<th><?php echo yii::t('app','Guest4')?></th>
				</tr>
			</thead>
			<tbody>
				<!-- <tr>
					<td class="readOnly">1</td>
					<td class="readOnly">Owner Suite</td>
					<td>
						<select>
							<option>Please Select</option>
						</select>
					</td>
					<td>
						<select>
							<option>Please Select</option>
						</select>
					</td>
					<td class="readOnly point">Null</td>
					<td class="readOnly point">Null</td>
				</tr> -->
				
			</tbody>
		</table>
		<div class="btnBox2">
			<a href="javascript:history.go(-1)"><input type="button" value="PREVIOUS" class="btn2"></input></a>
			<a href="<?php echo Url::toRoute(['ordersave','voyage_code'=>$code])?>" onclick="return savejson()"><input type="button" id="surcharge_next_but" value="NEXT" class="btn1"></input></a>
		</div>
	</div>
</div>
<!-- main content end -->
<script type="text/javascript">
window.onload = function(){
	var person_str = '';
	var option_user = '';
	<?php if(!empty($person_info)) {
	foreach ($person_info as $row){?>
		person_str += "<label>";
		person_str += '<input type="checkbox" value="<?php echo $row['passport']?>"></input>';
		person_str += "<span><?php echo $row['full_name'] ?></span>";
		person_str += '</label>';
		<?php $birth = Helper::GetCreateTime($row['birth']); $age = Helper::Getage($birth);?>
		option_user += "<option age='<?php echo $age;?>' value='<?php echo $row['passport']?>'><?php echo $row['full_name'] ?></option>";
	<?php }}?>

	$(".shore_div").html(person_str);
	$(".insurance_div").html(person_str);

	//房间
	var room_str = '';
	<?php if(!empty($cabins_info)){
		$number = 1;
		foreach ($cabins_info as $row){
		//判断该类型选择了多少个房间
		$live_num = $row['check_num'];
		$min_live = $row['min_live'];
		$empty_bed = 4-(int)$row['check_num'];
		for($n=0;$n<(int)$row['room_num'];$n++){
	?>
		room_str += '<tr>';
		room_str += '<td class="readOnly"><?php echo $number;?></td>';
		room_str += '<td class="readOnly" min_live="<?php echo $row['min_live']?>" cabin_code="<?php echo $row['type']?>"><?php echo $row['type_text']?></td>';
	//判断该房间住几人
	<?php for($i=0;$i<(int)$live_num;$i++){?>
		room_str += '<td>';
		room_str += '<select>';
		room_str += '<option value="0">Please Select</option>';
		room_str += option_user;
		room_str += '</select>';
		room_str += '</td>';
	<?php }?>
	<?php for($j=0;$j<(int)$empty_bed;$j++){?>
		room_str += '<td class="readOnly point">Null</td>';
	<?php }?>
		room_str += '</tr>';
	
	<?php ++$number;}}}?>
	$("table#room_div tbody").append(room_str);

//------------------------------------------------------------------------------------------------

	//定义全局变量 ，房间乘客改变，其他下拉框被选中人移除
	curr_room_user_passport = 0;
	curr_room_user_name = 0;

	$(document).on('click','#room_div tbody select',function(){
		var val = $(this).val();
		var text = $(this).find("option:selected").text();
		
		if(val!=0){
			curr_room_user_passport = val;
			curr_room_user_name = text;
		}

	});

	$(document).on('change','#room_div tbody select',function(){
		var val = $(this).val();
		var index = $("#room_div tbody select").index(this);
		$("#room_div tbody select").each(function(){
			var curr_index = $("#room_div tbody select").index(this);
			if(index != curr_index){
				if(val!=0){
					$(this).find("option[value='"+val+"']").remove();
				}
				if(curr_room_user_passport != 0){
				  var num = $("#room_div tbody select option[value='"+curr_room_user_passport+"']:selected").length;
				  if(num == 0){
				   $(this).append("<option value='"+curr_room_user_passport+"'>"+curr_room_user_name+"</option>");
				  }
				}
			}
		});

	});



	//观光路线选择
	$(document).on('click',".shore_div input[type='checkbox']",function(){
		var checked = $(this).is(":checked");
		var val = $(this).val();
		var index = $(".shore_div input[type='checkbox'][value='"+val+"']").index(this);
		var shore_id = $(this).parent().parent().parent().parent().find(".shore_title_id").attr('id');
		
		if(checked){
			//选中后取消其他选择
			$(".shore_div input[type='checkbox'][value='"+val+"']").each(function(e){
				var curr_index  = $(".shore_div input[type='checkbox'][value='"+val+"']").index(this);
				if(index != curr_index){
					$(this).attr("disabled","disabled");
					
					}
			});
		}else{
			//取消选择后开启其他选择
			$(".shore_div input[type='checkbox'][value='"+val+"']").each(function(e){
				var curr_index  = $(".shore_div input[type='checkbox'][value='"+val+"']").index(this);
				if(index != curr_index){
					$(this).removeAttr("disabled");
					}
			});
		}
		
	});

}
//数据保存下一步提交------------------------------------------------------
//下一步判断，完好则保存入库下单
function savejson(){
	var person_total = "<?php echo count($person_info)?>";
	
	//拼接观光路线
	var shore_josn = '{"shore":[';
	var sh_num = 0;
	var shore_data = '';
	$(".shore_div").each(function(){
		var sh_id = $(this).attr('sh_id');
		var shore_str = '{"type":"'+sh_id+'","person_key":[';
		var sh_str = '';
		$(".shore_div[sh_id='"+sh_id+"']").find("input[type='checkbox']:checked").each(function(){
			sh_str += '"'+$(this).val()+'",';
			++sh_num;
		});	
		if(sh_str!=''){	
			sh_str=sh_str.substring(0,sh_str.length-1);
			shore_str = shore_str+sh_str+']},';
			shore_data += shore_str;
		}
		
	});
	if(shore_data!=''){shore_data=shore_data.substring(0,shore_data.length-1);}
	
	shore_josn = shore_josn+shore_data+']},';
	if(sh_num<person_total){Alert("Existing members do not specify a sightseeing route");return false;}

	

	//拼接附加费
	var insurance_json = '{"insurance":[';
	var insurance_data = '';
	$(".insurance_div").each(function(){
		var in_id = $(this).attr('in_id');
		var insurance_str = '{"type":"'+in_id+'","person_key":[';
		var in_str = '';
		$(".insurance_div[in_id='"+in_id+"']").find("input[type='checkbox']:checked").each(function(){
			in_str += '"'+$(this).val()+'",';
		});	
		if(in_str!=''){	
			in_str=in_str.substring(0,in_str.length-1);
			insurance_str = insurance_str+in_str+']},';
			insurance_data += insurance_str;
		}
		
	});
	if(insurance_data!=''){insurance_data=insurance_data.substring(0,insurance_data.length-1);}
	insurance_json = insurance_json+insurance_data+']},';


	//验证房间，(1.判断最少入住成人数。2.判断是否存在空房)
	//拼接房间
	var success = 1;
	var ca_num = 0;
	var adult_num = 0;
	var cabins_json = '{"cabins":[';
	var cabins_data_all = '';
	var cruise_child_age = "<?php echo Yii::$app->params['children_age']?>";

	$("table#room_div tbody tr").each(function(){
		var cabin_type_name = $(this).find("td").eq(1).html();
		var cabin_code = $(this).find("td").eq(1).attr('cabin_code');
		var min_live = $(this).find("td").eq(1).attr('min_live');
		var cabin_str = '{"type":"'+cabin_code+'","pereson":[';
		var cabin_data = '';
		var cabin_number = 0;
		$(this).find("select").each(function(){
			var val = $(this).find("option:selected").val();
			if(val!=0){
				var age = $(this).find("option:selected").attr('age');
				if(parseInt(age) > parseInt(cruise_child_age)){
					++adult_num;
				}
				cabin_data += '"'+val+'",';
				++ca_num;
				++cabin_number;
			}else{
				cabin_data += '"",';
			}
			
		});
		if(cabin_number == 0){
			Alert("Can't existence empty cabins ");
			success = 0;return false;
		}
		if(adult_num<min_live){
			Alert(cabin_type_name+"type cabin check-in at least "+min_live+" adults");
			success = 0;return false;
		}
		if(cabin_number != 0){
			cabin_data=cabin_data.substring(0,cabin_data.length-1);
			cabin_str = cabin_str + cabin_data+']},';
			cabins_data_all += cabin_str;
		}
	});

	if(success == 0){return false;}
	if(ca_num<person_total){Alert("Existing members does not specify the ship type");return false;}
	
	if(cabins_data_all!=''){
		cabins_data_all=cabins_data_all.substring(0,cabins_data_all.length-1);
	}
	cabins_json = cabins_json + cabins_data_all+ ']}';

	var additional_json = '[{"additional_json":['+shore_josn+insurance_json+cabins_json+']}]';

	//保存session
	$.ajax({
        url:"<?php echo Url::toRoute(['savesessionadditional']);?>",
        type:'post',
        async:false,
        data:'additional_json='+additional_json,
     	dataType:'json',
	});

	return true;
	
}
</script>