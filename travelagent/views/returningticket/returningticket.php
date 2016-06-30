<?php
$this->title = 'Agent Ticketing';
use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

?>
<!-- main content start -->
<div id="refundApplication" class="mainContent">
    <div id="topNav">
    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Refund Ticket')?></a>
    </div>
    <div id="mainContent_content">
		<!-- 请用ajax提交 -->
		<div class="pBox">
			<table id="return_ticket_table">
				<thead>
					<tr>
						<th><?php echo yii::t('app','No.')?></th>
						<th><?php echo yii::t('app','Order Number')?></th>
						<th><?php echo yii::t('app','Route ID')?></th>
						<th><?php echo yii::t('app','Route Name')?></th>
						<th><?php echo yii::t('app','Order Price')?></th>
						<th><?php echo yii::t('app','Order Time')?></th>
						<th><?php echo yii::t('app','Status')?></th>
						<th><?php echo yii::t('app','Operation')?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($order as $key=>$value):?>
				<?php if ($key<2){?>
					<tr>
						<td><?php echo $key+1?></td>
							<td><?php echo $value['order_serial_number']?></td>
							<td><?php echo $value['voyage_code']?></td>
							<td><?php echo $value['voyage_name']?></td>
							<td>￥<?php echo $value['total_pay_price']?></td>
							<td><?php echo $value['create_order_time']?></td>
							<td><?php echo $value['pay_status'] == 0 ? yii::t('app','To Be Paid') : yii::t('app','Finished')  ?></td>
						<td><button class="btn1" onclick="hrefinfo('<?php echo $value['order_serial_number'] ?>')"><img src="<?=$baseUrl?>images/right.png"></button></td>
					</tr>
					<?php }?>
				<?php endforeach;?>
				</tbody>
			</table>
				<div class="center" id="return_ticket_page_div"> </div>
		</div>
	</div>
</div>
<!-- main content end -->
<input type="hidden" id="count" value="<?php echo sizeof($order)?>"/>
<script type="text/javascript">
window.onload = function(){ 
	var count_page =  $("#count").val();	
	get_page(count_page);
}
function get_page(count)
{
	var booking_total = parseInt(Math.ceil(count/2));
	if(booking_total <= 1 ){
		return;
	}
		$('#return_ticket_page_div').jqPaginator({
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
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['returnticketpage']);?>",
	                type:'post',
	                data:'pag='+num,
	             	dataType:'json',
	            	success:function(data){
		            	
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
		    	                var k=parseInt(key)+1;
	                        	str += "<tr>";
	                            str += "<td>"+k+"</td>";
	                            str += "<td>"+data[key]['order_serial_number']+"</td>";
	                            str += "<td>"+data[key]['voyage_code']+"</td>";
	                            str += "<td>"+data[key]['voyage_name']+"</td>";
	                            str += "<td>￥"+data[key]['total_pay_price']+"</td>";
	                            str += "<td>"+data[key]['create_order_time']+"</td>";
	                            str += "<td>";
	                            str +=data[key]['pay_status']==0?"<?php echo yii::t('app','To Be Paid');?>":"<?php echo yii::t('app','Finished');?>";
	                            str += "</td>";
	                            str += "<td>";
	                            str += "<button onclick='hrefinfo(\""+data[key]['order_serial_number']+"\");' code='"+data[key]['order_serial_number']+"' class='btn1'><img src='<?php echo $baseUrl;?>images/right.png'></button>";
	                            str += "</td>";
		                        str += "</tr>";
	                          });
	    	                $("table#return_ticket_table > tbody").html(str);
	            	}      
	           
	    	}
		});
	}
	});
}
function hrefinfo(id){
	location.href="<?php echo Url::toRoute(['returnticketinfo']);?>&id="+id;
}
</script>



