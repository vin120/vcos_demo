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
var get_cabin_type_ajax_url = "<?php echo Url::toRoute(['getcabintype']);?>";
var cabin_pricing_submit_ajax_url = "<?php echo Url::toRoute(['cabinpricingsubmit']);?>";
//var cabin_pricing_submit_success_ajax_url = "<?php //echo  Url::toRoute(['getcabinpricingpage','pag'=>1]);?>";
var get_cabin_pricing_data_ajax_url = "<?php echo Url::toRoute(['getcabinpricingdata']);?>";
var get_strategy_data_ajax_url = "<?php echo Url::toRoute(['getstrategydata']);?>";
var preferential_policies_submit_ajax_url = "<?php echo Url::toRoute(['preferentialpoliciessubmit']);?>";
var get_preferential_policies_data_ajax_url = "<?php echo Url::toRoute(['getpreferentialpoliciesdata']);?>";
</script>


<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Cabin Pricing')?></a></div>
   <div class="tab">
		<ul class="tab_title">
			<li class="active" act="pricing"><?php echo yii::t('app','Cabin Pricing')?></li>
			<li act="policies"><?php echo yii::t('app','Preferential Policies')?></li>
			<li act="surcharge"><?php echo yii::t('app','Surcharge')?></li>
			<li act="tour"><?php echo yii::t('app','Tour Route')?></li>
		</ul>
		<div class="tab_content">
		<!-- one -->
			<div class="active">
				<div class="search" style="margin-bottom: 10px;">
					<label>
						<span><?php echo yii::t('app','Route No.')?>:</span>
						<select id="cabin_pricing_vayage">
						<?php foreach ($voyage_result as $k=>$v){?>
							<option value="<?php echo $v['voyage_code']?>"><?php echo $v['voyage_name']?></option>
						<?php }?>
						</select>
					</label>
					<!-- <span class="btn">
						<input type="button" value="Copy Price"></input>
					</span> -->
				</div>
				<div class="searchResult">
					<table id="cabin_pricing_table">
						<thead>
							<tr>
								<th><?php echo yii::t('app','Cabin Type Name')?></th>
								<th><?php echo yii::t('app','Check Num')?></th>
								<th><?php echo yii::t('app','Bed Price')?></th>
								<th><?php echo yii::t('app','3/4th-Bed Price')?></th>
								<th><?php echo yii::t('app','2th-Bed Sates(%)')?></th>
								<th><?php echo yii::t('app','3/4th-Bed Sates(%)')?></th>
								<th><?php echo yii::t('app','Operation')?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($cabin_pricing_result as $k=>$v){?>
							<tr>
								<td><?php echo $v['type_name']?></td>
								<td><?php echo $v['check_num']?></td>
								<td><?php echo $v['bed_price']?></td>
								<td><?php echo $v['check_num']<=2?'--':$v['last_bed_price'];?></td>
								<td><?php echo $v['2_empty_bed_preferential']?></td>
								<td><?php echo $v['check_num']<=2?'--':$v['3_4_empty_bed_preferential'];?></td>
								<td class="op_btn">
				                    <a class="cabin_pricing_edit" style="cursor:pointer" id="<?php echo $v['id']?>" value="edit"><img src="<?=$baseUrl ?>images/write.png"></a>
				                    <a class="delete" style="cursor:pointer" id="<?php echo $v['id']?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
				                </td>
							</tr>
						<?php }?>
						</tbody>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span id="cabin_pricing_total"><?php echo count($cabin_pricing_result);?></span></p>
			        <div class="btn">
			            <input id="cabin_pricing_add_but" type="button" value="<?php echo yii::t('app','Add')?>"></input>
			        </div>
				</div>
			</div>
			<!-- two -->
			<div>
				<div class="search" style="margin-bottom: 10px;">
					<label>
						<span><?php echo yii::t('app','Route No.')?>:</span>
						<select id="policies_vayage">
						<?php foreach ($voyage_result as $k=>$v){?>
							<option value="<?php echo $v['voyage_code']?>"><?php echo $v['voyage_name']?></option>
						<?php }?>
						</select>
					</label>
					<!-- <span class="btn">
						<input type="button" value="Copy Price"></input>
					</span> -->
				</div>
				<div>
					<table id="preferential_policies_table">
						<thead>
							<tr>
								<th><?php echo yii::t('app','Strategy')?></th>
								<th><?php echo yii::t('app','1/2 Preferential(%)')?></th>
								<th><?php echo yii::t('app','3/4 Preferential(%)')?></th>
								<th><?php echo yii::t('app','Operate')?></th>
							</tr>
						</thead>
						<tbody>
						<!-- ajax -->
						</tbody>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span id="preferential_policies_total"></span></p>
					<div class="btn">
						<input type="button" id="preferential_policies_add" value="<?php echo yii::t('app','Add')?>"></input>
					</div>
				</div>
			</div>
			<!-- three -->
			<div>
				<div class="search" style="margin-bottom: 10px;">
						<label>
							<span><?php echo yii::t('app','Route No.')?>:</span>
							<select id="surcharge_vayage">
							<?php foreach ($voyage_result as $k=>$v){?>
								<option value="<?php echo $v['voyage_code']?>"><?php echo $v['voyage_name']?></option>
							<?php }?>
							</select>
						</label>
						<!-- <span class="btn">
							<input type="button" value="Copy Price"></input>
						</span> -->
					</div>
					<div>
					<table id="surcharge_table">
						<thead>
							<tr>
								<th><?php echo yii::t('app','Cost Name')?></th>
								<th><?php echo yii::t('app','Operate')?></th>
							</tr>
						</thead>
						<tbody>
						<!-- ajax -->
						</tbody>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span id="surcharge_total"></span></p>
					<div class="btn">
						<a href="<?php echo Url::toRoute(['surchargeadd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
					</div>
				</div>
			</div>
			<!-- four -->
			<div>
				<div class="search" style="margin-bottom: 10px;">
						<label>
							<span><?php echo yii::t('app','Route No.')?>:</span>
							<select id="tour_vayage">
							<?php foreach ($voyage_result as $k=>$v){?>
								<option value="<?php echo $v['voyage_code']?>"><?php echo $v['voyage_name']?></option>
							<?php }?>
							</select>
						</label>
						<!-- <span class="btn">
							<input type="button" value="Copy Price"></input>
						</span> -->
					</div>
					<div>
					<table id="tour_table">
						<thead>
							<tr>
								<th><?php echo yii::t('app','Title')?></th>
								<th><?php echo yii::t('app','Operate')?></th>
							</tr>
						</thead>
						<tbody>
						<!-- ajax -->
						</tbody>
					</table>
					<p class="records"><?php echo yii::t('app','Records')?>:<span id="tour_total"></span></p>
					<div class="btn">
						<a href="<?php echo Url::toRoute(['touradd']);?>"><input type="button" value="<?php echo yii::t('app','Add')?>"></input></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- content end -->



<script type="text/javascript">
window.onload = function(){ 
		/**点击导航栏获取相应值***/
		
		$(".tab_title li[act='pricing']").on('click',function(){
			var curr = $(this).is('.active');
			if(curr == true){return false;}
			var voyage = $("select#cabin_pricing_vayage").val();
			$.ajax({
		        url:"<?php echo Url::toRoute(['getcabinpricinglist']);?>",
		        type:'get',
		        async:false,
		        data:'voyage='+voyage,
		     	dataType:'json',
		    	success:function(data){
		    		var str = '';
	        		if(data != 0){
		                $.each(data,function(key){
							str += "<tr>";
							str += "<td>"+data[key]['type_name']+"</td>";
		                	str += "<td>"+data[key]['check_num']+"</td>";
							str += "<td>"+data[key]['bed_price']+"</td>";
							var last_bed_price = data[key]['check_num']<=2?'--':data[key]['last_bed_price'];
							str += "<td>"+last_bed_price+"</td>";
							str += "<td>"+data[key]['2_empty_bed_preferential']+"</td>";
							var t_3_data = data[key]['check_num']<=2?'--':data[key]['3_4_empty_bed_preferential'];
							str += "<td>"+t_3_data+"</td>";
							str += "<td class='op_btn'>";
							str += "<a class='cabin_pricing_edit' style='cursor:pointer' id='"+data[key]['id']+"' value='edit'><img src='<?=$baseUrl ?>images/write.png'></a>";
			                str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";   
			                str += "</td></tr>";    
	                      });
		                $("table#cabin_pricing_table > tbody").html(str);
		                $("#cabin_pricing_total").html(data.length);
		            }else{
		            	$("table#cabin_pricing_table > tbody").html('');
		            	$("#cabin_pricing_total").html(data);
			        }
		    	}      
		    });
		});

		$(".tab_title li[act='policies']").on('click',function(){
			var curr = $(this).is('.active');
			if(curr == true){return false;}

			var voyage = $("select#policies_vayage").val();
			$.ajax({
		        url:"<?php echo Url::toRoute(['getpreferentialpolicieslist']);?>",
		        type:'get',
		        async:false,
		        data:'voyage='+voyage,
		     	dataType:'json',
		    	success:function(data){
		    		var str = '';
	        		if(data != 0){
		                $.each(data,function(key){
		                	str += "<tr>";
							str += "<td>"+data[key]['strategy_name']+"</td>";
		                	str += "<td>"+data[key]['p_price']+"</td>";
		                	str += "<td>"+data[key]['s_p_price']+"</td>";
							str += "<td  class='op_btn'>";
							str += "<a class='preferential_policies_edit' style='cursor:pointer' id='"+data[key]['id']+"' value='edit'><img src='<?=$baseUrl ?>images/write.png'></a>";
			                str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
			                str += "</td></tr>";
	                      });
		                $("table#preferential_policies_table > tbody").html(str);
		                $("#preferential_policies_total").html(data.length);
		            }else{
		            	$("table#preferential_policies_table > tbody").html('');
		            	$("#preferential_policies_total").html(data);
			        }
		    	}      
		    });
		});
		$(".tab_title li[act='surcharge']").on('click',function(){
			var curr = $(this).is('.active');
			if(curr == true){return false;}

			var voyage = $("select#surcharge_vayage").val();
			$.ajax({
		        url:"<?php echo Url::toRoute(['getsurchargelist']);?>",
		        type:'get',
		        async:false,
		        data:'voyage='+voyage,
		     	dataType:'json',
		    	success:function(data){
		    		var str = '';
	        		if(data != 0){
		                $.each(data,function(key){
		                	str += "<tr>";
							str += "<td>"+data[key]['cost_name']+"</td>";
							str += "<td  class='op_btn'>";
			                str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
			                str += "</td></tr>";
	                      });
		                $("table#surcharge_table > tbody").html(str);
		                $("#surcharge_total").html(data.length);
		            }else{
		            	$("table#surcharge_table > tbody").html('');
		            	$("#surcharge_total").html(data);
			        }
		    	}      
		    });
		});
		$(".tab_title li[act='tour']").on('click',function(){
			var curr = $(this).is('.active');
			if(curr == true){return false;}

			var voyage = $("select#tour_vayage").val();
			$.ajax({
		        url:"<?php echo Url::toRoute(['gettourroutelist']);?>",
		        type:'get',
		        async:false,
		        data:'voyage='+voyage,
		     	dataType:'json',
		    	success:function(data){
		    		var str = '';
	        		if(data != 0){
		                $.each(data,function(key){
		                	str += "<tr>";
							str += "<td>"+data[key]['se_name']+"</td>";
							str += "<td  class='op_btn'>";
			                str += "<a class='delete' style='cursor:pointer' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
			                str += "</td></tr>";

	                      });
		                $("table#tour_table > tbody").html(str);
		                $("#tour_total").html(data.length);
		            }else{
		            	$("table#tour_table > tbody").html('');
		            	$("#tour_total").html(data);
			        }
		    	}      
		    });
		});






	
	//船舱定价-》船舱定价航线改变
	$(document).on('change',"#cabin_pricing_vayage",function(){
		var voyage = $(this).val();
		$.ajax({
	        url:"<?php echo Url::toRoute(['cabinpricingto']);?>",
	        type:'get',
	        async:false,
	        data:'voyage='+voyage,
	     	dataType:'json',
	    	success:function(data){
	    		var str = '';
        		if(data != 0){
	                $.each(data,function(key){
                    	str += "<tr>";
                        str += "<td>"+data[key]['type_name']+"</td>";
                        str += "<td>"+data[key]['check_num']+"</td>";
                        str += "<td>"+data[key]['bed_price']+"</td>";
                        if(data[key]['check_num']<=2){var last_bed_price = '--';}else{var last_bed_price = data[key]['last_bed_price'];}
                        str += "<td>"+last_bed_price+"</td>";
                        str += "<td>"+data[key]['2_empty_bed_preferential']+"</td>";
                        if(data[key]['check_num']<=2){var bed_preferential = '--';}else{var bed_preferential = data[key]['3_4_empty_bed_preferential'];}
                        str += "<td>"+bed_preferential+"</td>";
                        str += "<td  class='op_btn'>";
                        str += "<a class='cabin_pricing_edit' id='"+data[key]['id']+"' value='edit'><img src='<?=$baseUrl ?>images/write.png'></a>";
                        str += "<a class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
                        str += "</td>";
                        str += "</tr>";
                      });
	                $("table#cabin_pricing_table > tbody").html(str);
	                $("#cabin_pricing_total").html(data.length);
	            }else{
	            	$("table#cabin_pricing_table > tbody").html('');
	            	$("#cabin_pricing_total").html(data);
		        }
	    	}      
	    });
	});

	//船舱定价-》船舱定价航线改变
	$(document).on('change',"#policies_vayage",function(){
		var voyage = $(this).val();
		$.ajax({
	        url:"<?php echo Url::toRoute(['preferentialpoliciesto']);?>",
	        type:'get',
	        async:false,
	        data:'voyage='+voyage,
	     	dataType:'json',
	    	success:function(data){
	    		var str = '';
        		if(data != 0){
	                $.each(data,function(key){
                    	str += "<tr>";
                        str += "<td>"+data[key]['strategy_name']+"</td>";
                        str += "<td>"+data[key]['p_price']+"</td>";
                        str += "<td  class='op_btn'>";
                        str += "<a class='preferential_policies_edit' id='"+data[key]['id']+"' value='edit'><img src='<?=$baseUrl ?>images/write.png'></a>";
                        str += "<a class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
                        str += "</td>";
                        str += "</tr>";
                      });
	                $("table#preferential_policies_table > tbody").html(str);
	                $("#preferential_policies_total").html(data.length);
	            }else{
	            	$("table#preferential_policies_table > tbody").html('');
	            	$("#preferential_policies_total").html(data);
		        }
	    	}      
	    });
	});

	//船舱定价-》附加费航线改变
	$(document).on('change',"#surcharge_vayage",function(){
		var voyage = $(this).val();
		$.ajax({
	        url:"<?php echo Url::toRoute(['surchargeto']);?>",
	        type:'get',
	        async:false,
	        data:'voyage='+voyage,
	     	dataType:'json',
	    	success:function(data){
	    		var str = '';
        		if(data != 0){
	                $.each(data,function(key){
                    	str += "<tr>";
                        str += "<td>"+data[key]['cost_name']+"</td>";
                        str += "<td  class='op_btn'>";
                       	str += "<a class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
                        str += "</td>";
                        str += "</tr>";
                      });
	                $("table#surcharge_table > tbody").html(str);
	                $("#surcharge_total").html(data.length);
	            }else{
	            	$("table#surcharge_table > tbody").html('');
	            	$("#surcharge_total").html(data);
		        }
	    	}      
	    });
	});


	//船舱定价-》附加费航线改变
	$(document).on('change',"#tour_vayage",function(){
		var voyage = $(this).val();
		$.ajax({
	        url:"<?php echo Url::toRoute(['tourto']);?>",
	        type:'get',
	        async:false,
	        data:'voyage='+voyage,
	     	dataType:'json',
	    	success:function(data){
	    		var str = '';
        		if(data != 0){
	                $.each(data,function(key){
                    	str += "<tr>";
                        str += "<td>"+data[key]['se_name']+"</td>";
                        str += "<td  class='op_btn'>";
                       	str += "<a class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
                        str += "</td>";
                        str += "</tr>";
                      });
	                $("table#tour_table > tbody").html(str);
	                $("#tour_total").html(data.length);
	            }else{
	            	$("table#tour_table > tbody").html('');
	            	$("#tour_total").html(data);
		        }
	    	}      
	    });
	});

	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but",function(){
	   var val = $(this).attr('id');
	   var act = $(".tab .tab_title").find("li.active").attr('act');
	   //alert(act);return false;
	   if(act=='pricing'){ 
	   		location.href="<?php echo Url::toRoute(['cabinpricingdelete']);?>"+"&id="+val;
	   }else if(act == 'policies'){
		   location.href="<?php echo Url::toRoute(['preferentialpoliciesdelete']);?>"+"&id="+val;
	   }else if(act == 'surcharge'){
		   location.href="<?php echo Url::toRoute(['surchargedelete']);?>"+"&id="+val;
	   }else if(act == 'tour'){
		   location.href="<?php echo Url::toRoute(['tourdelete']);?>"+"&id="+val;
	   }
   });

}

</script>



