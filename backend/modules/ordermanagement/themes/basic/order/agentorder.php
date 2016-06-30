<?php
$this->title = 'Order Management';

use app\modules\ordermanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<!-- content start -->
<div class="r content">
	<div class="topNav"><?php echo yii::t('app','Order Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Agent Order')?></a></div>
	<div class="search">
		<p>
			<label>
				<span><?php echo yii::t('app','Order Num')?> :</span>
				<input type="text" id="order_serial_number"></input>
			</label>
			
			<label>
				<span><?php echo yii::t('app','Status')?>:</span>
				<select id="status">
				<option value="100"><?php echo yii::t('app','All')?></option>
				<?php for ($i=0;$i<sizeof($status);$i++){?>
					<option value="<?php echo $i?>"><?php echo yii::t('app',$status[$i])?></option>
					<?php }?>
				</select>
			</label>
		</p>
		<p>
			<label>
				<span><?php echo yii::t('app','Agent Name')?>:</span>
				<input type="text" id="travel_agent_name"></input>
			</label>
			<label>
				<span><?php echo yii::t('app','Voyage Code')?>:</span>
				<input type="text" id="voyage_code"></input>
			</label>
			<span class="btn"><input type="button" id="search" value="SEARCH"></input></span>
		</p>
	</div>
	<div class="searchResult">
		<table id="order_page_table">
			<thead>
				<tr>
					<th><?php echo yii::t('app','Num')?></th>
					<th><?php echo yii::t('app','Order Serial Number')?></th>
					<th><?php echo yii::t('app','Voyage Code')?></th>
					<th><?php echo yii::t('app','Agent Name')?></th>
					<th><?php echo yii::t('app','Price')?></th>
					<th><?php echo yii::t('app','Status')?></th>
					<th><?php echo yii::t('app','Operate')?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($order as $key => $value):?>
			<?php if ($key<2){?>
				<tr>
					<td><?php echo $key+1;?></td>
					<td><?php echo $value['order_serial_number']?></td>
					<td><?php echo $value['voyage_code']?></td>
					<td><?php echo $value['travel_agent_name']?></td>
					<td><?php echo $value['total_pay_price']?></td>
					<td><?php echo $value['status']?></td>
					<td>
						<a href="<?php echo Url::toRoute(['order/agentorderdetail'])?>&order_serial_number=<?php echo $value['order_serial_number']?>"><img src="<?=$baseUrl ?>images/write.png" class="btn1"></a>
						<!-- <a href="#"><img src="<=$baseUrl ?>images/delete.png" class="btn2"></a> -->
					</td>
				</tr>
				<?php }?>
			<?php endforeach;?>
			</tbody>
		</table>
		<p class="records">Records:<span id='count'><?php echo sizeof($order)?></span></p>
		<div class="btn">
		<!-- 	<input type="button" id="savechangeclick" value="Add"></input>
			<input type="button" value="Del Selected"></input> -->
		</div>
		<div class="center" id="order_page_div"> </div>
	</div>
</div>
<input id="t" type="hidden"/>
<input id="pag" type="hidden" value="1"/>
<!-- content end -->
<script>
window.onload = function(){ 
	var count_page =  $("#count").html();	
	get_page(count_page);
	$("#search").click(function(){
		var order_serial_number=$("#order_serial_number").val();
		var status=$("#status").val();
		var travel_agent_name=$("#travel_agent_name").val();
		var voyage_code=$("#voyage_code").val();
		var t=1;
		$("#t").val('1');
		
		$.ajax({
			 url:"<?php echo Url::toRoute(['getorderpage']);?>",
             type:'post',
             data:{order_serial_number:order_serial_number,status:status,travel_agent_name:travel_agent_name,voyage_code:voyage_code,t:t},/* voyage_code:voyage_code,cabin_name:cabin_name,t:t */
          	 dataType:'json',
			success:function(data){
            	$("#count").html(data['count']);
            	if(data!=0){
				get_page(data['count']);
            	}
            	else{
            		get_page('0');
                	}
        	}  
			});
		});
}

function get_page(count)
{
	var booking_total = parseInt(Math.ceil(count/2));
	if(booking_total==0){
		booking_total=1;
		}
		$('#order_page_div').jqPaginator({
		    totalPages: booking_total,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		
		    	var this_page = $("input#pag").val();
		    	if(this_page==num){$("input#pag").val('fail');return false;}
		    	/* var voyage_code=$("select[name=voyage_code]").val();
		    	var cabin_name=$("input[name=cabin_name]").val(); */
		    	var order_serial_number=$("#order_serial_number").val();
				var status=$("#status").val();
				var travel_agent_name=$("#travel_agent_name").val();
				var voyage_code=$("#voyage_code").val();
		    	var t=$("#t").val();
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getorderpage']);?>",
	                type:'post',
	                data:{pag:num,order_serial_number:order_serial_number,status:status,travel_agent_name:travel_agent_name,voyage_code:voyage_code,t:t},/* voyage_code:voyage_code,cabin_name:cabin_name,pag:num,t:t */
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
		    	            if(key<2){
		    	            	var k=parseInt(key)+1;
	                        	str += "<tr>";
	                            str += "<td>"+k+"</td>";
	                            str += "<td>"+data[key]['order_serial_number']+"</td>";
	                            str += "<td>"+data[key]['voyage_code']+"</td>";
	                            str += "<td>"+data[key]['travel_agent_name']+"</td>";
	                            str += "<td>"+data[key]['total_pay_price']+"</td>";
	                            str += "<td>"+data[key]['status']+"</td>";
	                            str += "<td><a href='<?php echo Url::toRoute(['order/agentorderdetail'])?>&order_serial_number="+data[key]['order_serial_number']+"'><img src='<?=$baseUrl ?>images/write.png' class='btn1'></a> ";
	                            str +="<a href='#'><img src='<?=$baseUrl ?>images/delete.png' class='btn2'></a>";
	                            str +=" </td>";
			                        str += "</tr>";
		    	            }
	                          });
	    	                $("table#order_page_table > tbody").html(str);
	            	}  
	            		else{
	            			$("#count").html("0");
	    					$("table#order_page_table > tbody").html("");
		            		} 
            		
	           
	    	}
		});
	}
	});
}
</script>

