<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
			<input type="button" id="surcharge_next_but" value="NEXT" class="btn1"></input>
		</div>
	</div>
</div>
<!-- main content end -->
<script type="text/javascript">
window.onload = function(){
	var user_arr = new Array();
	var data = $.session.get('membership');
	//alert(data);
	var str = '';	//	存放其他
	var curr_str = ''; //存放当前
	var option_user = '';		//option存放乘客
	
	//人数
	if(data != undefined){
		data = data.replace(/\+/g," "); 
		data_ex = data.split('-');
		$.each(data_ex,function(e){
			if(data_ex[e]!=''){
				var val = data_ex[e].split('&');
				var u_passport = '';
				var u_full_name = ''
				val.forEach(function(param){
				  param = param.split('=');
				  var name = param[0],
				      val = param[1];
					if(name == 'passport'){u_passport=val;}
					if(name == 'full_name'){u_full_name=val;}
			      	 
				});
				//护照号-人名
				user_arr.push(u_passport+'-'+u_full_name);
			}
			
		});
	
		var data_str = '';
		$.each(user_arr,function(k){
			var d_val = user_arr[k].split("-");
			data_str += "<label>";
			data_str += '<input type="checkbox" value="'+d_val[0]+'"></input>';
			data_str += '<span>'+d_val[1]+'</span>';
			data_str += '</label>';


			option_user += "<option value='"+d_val[0]+"'>"+d_val[1]+"</option>";
	
		});
	
		$(".shore_div").html(data_str);
		$(".insurance_div").html(data_str);

		
	}

	//房间
	var room_data = $.session.get("room_<?php echo $code;?>");
	if(room_data != undefined){
		var str = '';
		var room_only = room_data.split("&");
		var number = 1;
		$.each(room_only,function(k){
			var split = room_only[k].split("=");
			var name = split[0].split("/");
			var val = split[1].split("/");
			var td_num = 4-parseInt(val[0]);

			//判断当前类型选择了多少个房间，循环几次
			for(var e=0;e<parseInt(val[1]);e++){
				str += '<tr>';
				str += '<td class="readOnly">'+number+'</td>';
				str += '<td class="readOnly" cabin_code="'+name[0]+'">'+name[1]+'</td>';
				//判断该房间住几人
				for(var i=0;i<val[0];i++){
					str += '<td>';
					str += '<select>';
					str += '<option value="0">Please Select</option>';
					str += option_user;
					str += '</select>';
					str += '</td>';
				}
				for(var j=0;j<td_num;j++){
					str += '<td class="readOnly point">Null</td>';
				}
				str += '</tr>';
				++number; 
			}

		});

		//alert(str);
		$("table#room_div tbody").append(str);
		
	}
	

	//alert(room_data);


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



//数据保存下一步提交------------------------------------------------------
	//下一步判断，完好则保存如库下单
	$("#surcharge_next_but").on('click',function(){
		//获取session中人数
		var data_total = data.split('-');
		var num = 0;
		$.each(data_total,function(k){
			if(data_total[k]!=''){
				++num;
				}
		});
		var shore_str = '';
		var sh_num = 0;

		
		//拼接会员
		var last_name =  new Array();
		var first_name = new Array();
		var full_name = new Array();
		var passport = new Array();
		var gender = new Array();
		var nationalify = new Array();
		var email = new Array();
		var phone = new Array();
		var birth = new Array();
		var birth_place = new Array();
		var issue = new Array();
		var expiry = new Array();
		
		var data_str = data.split("-");
		$.each(data_str,function(e){
			if(data_str[e]!=''){
				var da_str = data_str[e].split('&');
				$.each(da_str,function(l){
					var d_str = da_str[l].split('=');
					var name = d_str[0];
					var val = d_str[1];

					if(name == 'last_name'){last_name.push(val);}
					if(name == 'first_name'){first_name.push(val);}
					if(name == 'full_name'){full_name.push(val);}
					if(name == 'passport'){passport.push(val);}
					if(name == 'gender'){gender.push(val);}
					if(name == 'nationalify'){nationalify.push(val);}
					if(name == 'email'){email.push(val);}
					if(name == 'phone'){phone.push(val);}
					if(name == 'birth'){birth.push(val);}
					if(name == 'birth_place'){birth_place.push(val);}
					if(name == 'issue'){issue.push(val);}
					if(name == 'expiry'){expiry.push(val);}
					
				});
				
			}
		});
		
		var membership_data = 'last_name='+last_name+'&first_name='+first_name+'&full_name='+full_name+'&passport='+passport;
		membership_data += '&gender='+gender+'&nationalify='+nationalify+'&email='+email+'&phone='+phone;
		membership_data += '&birth='+birth+'&birth_place='+birth_place+'&issue='+issue+'&expiry='+expiry;
		
		
		//拼接观光路线
		$(".shore_div").each(function(){
			var sh_id = $(this).attr('sh_id');
			var sh_str = sh_id+':';
			$(".shore_div[sh_id='"+sh_id+"']").find("input[type='checkbox']:checked").each(function(){
				sh_str += $(this).val()+',';
				++sh_num;
			});		
			sh_str=sh_str.substring(0,sh_str.length-1);
			shore_str += sh_str+'/';
		});
		
		//alert(sh_num);alert(num);
		if(sh_num<num){Alert("Existing members do not specify a sightseeing route");return false;}
		//alert(shore_str);
		shore_str=shore_str.substring(0,shore_str.length-1);
		
		//拼接保险
		var user_passport = new Array();
		$(".insurance_div").eq(0).find("input[type='checkbox']").each(function(){
			user_passport.push($(this).val());
		});
		var insurance_str = '';
		$.each(user_passport,function(e){
			var in_str = user_passport[e]+':';
			
			$(".insurance_div").find("input[type='checkbox'][value='"+user_passport[e]+"']:checked").each(function(){
				in_str += $(this).parent().parent().attr('in_id')+',';
			});
			
			in_str=in_str.substring(0,in_str.length-1);
			insurance_str += in_str+'/';
			
		});
		insurance_str=insurance_str.substring(0,insurance_str.length-1);
		//alert(passport_str);
		
		
		
		//拼接房间
		var ca_num = 0;
		var cabin_str = '';
		
		$("table#room_div tbody tr").each(function(){
			var cabin_code = $(this).find("td").eq(1).attr('cabin_code');
			var is_exist = 0;
			var ca_str = cabin_code+':';
			
			$(this).find("select").each(function(){
				var val = $(this).find("option:selected").val();
				if(val!=0){
					ca_str += val+',';
					++ca_num;
				}
			});
			
				ca_str=ca_str.substring(0,ca_str.length-1);
				cabin_str += ca_str+'/';
			
		});

		//alert(ca_num);alert(num);
		if(ca_num<num){Alert("Existing members does not specify the ship type");return false;}
		//alert(cabin_str);
		cabin_str=cabin_str.substring(0,cabin_str.length-1);

		

		//membership+shore_excursion+Insurance+room
		var post_data = membership_data+'&shore_excursion='+shore_str+'&insurance='+insurance_str+'&room='+cabin_str+'&voyage_code='+<?php echo $code;?>;


		
		$.ajax({
	        url:"<?php echo Url::toRoute(['ordersave']);?>",
	        type:'post',
	        async:false,
	        data:post_data,
	     	dataType:'json',
	    	success:function(data){
	    		if(data != 0){
	    			if(data !== 0){
		    			//提交数据成功
		    			var order_number = data;
	    				Alert("Save success ");
	    				//清除session
	    				//$.session.clear();
	    				location.href="<?php echo Url::toRoute(['orderinformation'])?>&order_number="+order_number;
		    		}else{
			    		//提交数据失败
			    		Alert("Save failed");
			    	}
	    		}
	        		
	    	}      
	    });
		
	
	});

	
	

	
}
</script>