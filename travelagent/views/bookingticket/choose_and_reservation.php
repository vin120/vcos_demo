<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use  yii\web\Session;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>

<!-- main content start -->
<div id="chooseAndReservation" class="mainContent">
	<div id="topNav">
		<?php echo yii::t('app','Agent Ticketing')?>
		<span>>></span>
		<a href="<?php echo Url::toRoute(['bookingticket','code'=>$code])?>"><?php echo yii::t('app','Reservation')?></a>
		<span>>></span>
		<a href="<?php echo Url::toRoute(['inputmode','code'=>$code])?>"><?php echo yii::t('app','Input mode')?></a>
		<span>>></span>
		<a href="<?php echo Url::toRoute(['adduestinfo','code'=>$code])?>"><?php echo yii::t('app','Add Guest Infomation')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Choose Cabin')?> &amp; <?php echo yii::t('app','Reservation Quantity')?></a>
	</div>
	<div id="mainContent_content" class="pBox">
		<div class="btnBox1">
			<input type="button" id="choose_add_tr_but" value="Add" class="btn1"></input>
			<input type="button" id="choose_del_tr_but" value="Del" class="btn2"></input>
		</div>
		
		<table id="choose_table">
			<thead>
				<tr>
					<th>No.</th>
					<th>Cabin Type</th>
					<th>Reservation Quantity</th>
					<th>Residual Quantity</th>
				</tr>
			</thead>
			<tbody>
				<!-- <tr>
					<td><input type="checkbox" ></td>
					<td>
						<select>
							<option>Owner Suite</option>
						</select>
					</td>
					
					<td>
						<input type="text"></input>
					</td>
					<td class="readOnly">9</td>
				</tr> -->
			</tbody>
		</table>
		<div class="btnBox2">
			<a href="javascript:history.go(-1)"><input type="button" value="PREVIOUS" class="btn2"></input></a>
			<input type="button" id="choose_save_next_but" value="NEXT" class="btn1"></input>
		</div>
	</div>
	<div class="shadow"></div>
	<div class="popups prompt">
		<h3>Prompt<a href="#" class="r close">&#10006;</a></h3>
		<div class="pBox">
			<p>Sure to delete?</p>
			<p class="btnBox">
				<input type="button" value="YES" class="btn1" id="query_del"></input>
				<input type="button" value="NO" class="btn2 close"></input>
			</p>
		</div>
	</div>
</div>

<!-- main content end -->

<script type="text/javascript">
window.onload = function(){

	//获取session数据判断是否存在，存在则遍历显示
	var room_data = $.session.get("room_<?php echo $code;?>");
	
	if(room_data != undefined){
		// 002/2=2/1&004/4=4/2
		//alert(room_data);
		
		<?php 
			$order_arr = array();
			foreach ($order_data as $val){
				$order_arr[$val['cabin_type_code']] = $val['count'];
			}?>
			
			var option = '<option num="0" value="0">Please select</option>';
			<?php  foreach ($all_data as $val){
			if(isset($order_arr[$val['type_code']])){
				$num = (int)$val['count'] - (int)$order_arr[$val['type_code']];
			}else{
				$num = (int)$val['count'];
			}
		?>
				option += "<option check_num ='<?php echo $val['check_num'];?>' num='<?php echo $num;?>' value='<?php echo $val['type_code']?>'><?php echo $val['type_name']?></option>";
		<?php }?>

		//alert(option);
				
		var room_only = room_data.split("&");
		$.each(room_only,function(k){
			var split = room_only[k].split("=");
			var name = split[0].split("/");
			var val = split[1].split("/");
			
			
			var l_left = "value='"+name[0]+"'";
			var r_right = "value='"+name[0]+"' selected='selected'";
			var this_option = option.replace(l_left,r_right);
			
			var str = '';
			str += "<tr>";
			str += '<td><input type="checkbox" ></td>';
			str += '<td>';
			str += '<select>';
			str += this_option;
			str += '</select>';
			str += '</td>';
			str += '<td><input type="text" value="'+val[1]+'" onkeyup="this.value=this.value.replace(/[^1-9]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^1-9]/g,\'\')"></input></td>';
			str += '<td class="readOnly"></td>';
			str += '</tr>';	

			$("table#choose_table tbody").append(str);
			
		});

		$("table#choose_table tbody tr").each(function(e){
			var this_index = $(this).index();
			var selectedValue = $(this).find("select option:selected").val();

			$(this).siblings().find("select option[value='" + selectedValue + "']").remove();
			
 			var this_num = $(this).find("select option:selected").attr("num");
 			if(this_num>10){
 				this_num = 'Enough';
 				}
 			$(this).find("td").eq(3).html(this_num);

		});

	}







	

	$("#choose_add_tr_but").on('click',function(){

		//获取cabin_type
		var length = $("table#choose_table tbody").find("tr").length;
		
		var total_length = "<?php echo count($all_data)?>";
		
		if(length == total_length){return false;}
		
		<?php 
		$order_arr = array();
		foreach ($order_data as $val){
			$order_arr[$val['cabin_type_code']] = $val['count'];
		}?>
		
		var option = '<option num="0" value="0">Please select</option>';
		if(length==0){
			<?php  foreach ($all_data as $val){
			if(isset($order_arr[$val['type_code']])){
				$num = (int)$val['count'] - (int)$order_arr[$val['type_code']];
			}else{
				$num = (int)$val['count'];
			}
				?>
					option += "<option check_num ='<?php echo $val['check_num'];?>' num='<?php echo $num;?>' value='<?php echo $val['type_code']?>'><?php echo $val['type_name']?></option>";
			<?php }?>
		}else{
				var name = new Array();
				
			$("table#choose_table tbody select").each(function(){
				if($(this).val() != 0){
					name.push($(this).val());
				}
			});
			
			<?php  foreach ($all_data as $val){
				if(isset($order_arr[$val['type_code']])){
					$num = (int)$val['count'] - (int)$order_arr[$val['type_code']];
				}else{
					$num = (int)$val['count'];
				}
				?>
				if($.inArray("<?php echo $val['type_code']?>", name)==-1){
					option += "<option check_num ='<?php echo $val['check_num'];?>' num='<?php echo $num;?>' value='<?php echo $val['type_code']?>'><?php echo $val['type_name']?></option>";
				}
			<?php }?>


		}
		
		var str = '';
		str += "<tr>";
		str += '<td><input type="checkbox" ></td>';
		str += '<td>';
		str += '<select>';
		str += option;
		str += '</select>';
		str += '</td>';
		str += '<td><input type="text" onkeyup="this.value=this.value.replace(/[^1-9]/g,\'\')"  onafterpaste="this.value=this.value.replace(/[^1-9]/g,\'\')"></input></td>';
		str += '<td class="readOnly"></td>';
		str += '</tr>';	
		
		$("table#choose_table tbody").append(str);
	
	
	});

	curr_val = '';
	curr_name = '';
	curr_num = '';

	$(document).on('click','#choose_table tbody select',function(){
		var val = $(this).val();
		var text = $(this).find("option:selected").text();
		var num = $(this).find("option:selected").attr("num");
		curr_val = val;
		curr_name = text;
		curr_num = num;

	});

	$(document).on('change','#choose_table tbody select',function(){
		var val = $(this).val();
		var this_num = $(this).find("option:selected").attr("num");
		var this_check_num = $(this).find("option:selected").attr("check_num");
		if(val == 0){
			this_num = '';
			}
		if(this_num>10){
			this_num = 'Enough';
			}
		$(this).parent().parent().find(".readOnly").html(this_num);

		
		var index = $("#choose_table tbody select").index(this);
		$("#choose_table tbody select").each(function(){
			var curr_index = $("#choose_table tbody select").index(this);
			if(index != curr_index){
				if(val!=0){
					$(this).find("option[value='"+val+"']").remove();
				}
				if(curr_val != 0){
				$(this).append("<option check_num='"+this_check_num+"' num='"+curr_num+"' value='"+curr_val+"'>"+curr_name+"</option>");
				}
			}
		});

	});



	//del

	$("#choose_del_tr_but").on('click',function(){
		var length = $("table#choose_table tbody").find("input[type='checkbox']:checked").length;
		if(length == 0){
			Alert("Please select delete items");return false;
			}
		if(length > 1){
			Alert("Can only choose a deleted items");return false;
			}
		
		new PopUps($(".prompt"));
	});


	$(document).on('click',".popups .btnBox #query_del",function(){
		var last_room_data = '';
		var curr_cabin_type = $(this).parent().parent().find("select option:selected").val();
		
		$("table#choose_table tbody").find("input[type='checkbox']:checked").each(function(){
			var cabin_type = $(this).find("select").val();
			var room_data = $.session.get("room_<?php echo $code;?>");
			// 002/2=2/1&004/4=4/2
			if(room_data != undefined){
				var ex_room_data = room_data.split("&");
				$.each(ex_room_data,function(e){
					var name = ex_room_data[e].split("=");
					name = name[0].split("/");
					name = name[0];
					if(curr_cabin_type != name){
						last_room_data += ex_room_data[e]+'&';
					}
				});
				last_room_data=last_room_data.substring(0,last_room_data.length-1);
				
				//设置session
				$.session.set("room_<?php echo $code;?>", last_room_data);
			}
			$(this).parent().parent().remove();
			$(".shadow").hide();
	        $(".popups").hide();
		});
		
	});


	//save
	$("#choose_save_next_but").on('click',function(){
		var length = $("table#choose_table tbody").find("tr").length;
		if(length == 0){Alert("Did not choose the room");return false;}
		var data = '';
		var a =0;
		$("table#choose_table tbody").find("tr").each(function(){
			var cabin_type = $(this).find("select").val();
			var cabin_type_text = $(this).find("select option:selected").text();
			var cabin_type_num = parseInt($(this).find("select option:selected").attr("num"));
			var cabin_type_check_num = parseInt($(this).find("select option:selected").attr("check_num"));
			var number = $(this).find("input[type='text']").val();
			if(cabin_type != 0){
				if(number == ''){Alert("Room number cannot be empty");a=1;return false;}
				number = parseInt(number);
				if(number>10){Alert("Room number can only enter an integer less than 10");a=1;return false;}
				if(number>cabin_type_num){Alert("Enter the room number is not greater than the rest of the room number ");a=1;return false;}
				data += cabin_type+'/'+cabin_type_text+'='+cabin_type_check_num+'/'+number+'&';
			}
		});
		if(a==1){return false;}
		if(data == ''){Alert("Did not choose the room");return false;}
		data=data.substring(0,data.length-1);
		
		//设置session
		$.session.set("room_<?php echo $code;?>", data);

		location.href="<?php echo Url::toRoute(['surchargecabinassignments','code'=>$code])?>";
		

	});
	

	
}
</script>


