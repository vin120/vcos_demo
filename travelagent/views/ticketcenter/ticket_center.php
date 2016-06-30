<?php
$this->title = 'Agent Ticketing';
use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

?>
<!-- main content start -->
<div id="orderCenter" class="mainContent">
    <div id="topNav">
    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Ticket Center')?></a>
    </div>
    <div id="mainContent_content">
		<!-- 请用ajax提交 -->
		<div class="pBox search">
		
			<p>
				<label class="wrongBox">
					<span><?php echo yii::t('app','')?>Order No.:</span>
					<span>
						<select id="order_no" name="order_no">
						<option><?php echo yii::t('app','All')?></option>
						<?php foreach ( $order_num as $row) :?>
							<option><?php echo $row['order_serial_number']?></option>
						<?php endforeach;?>
						</select>
						<input type="hidden" id="order_no_hidden" value="All"></input>
						<!-- 错误提示 -->
							<!-- <em><?php echo yii::t('app','Please select')?>...</em> -->
						</span>
					</label>
					<label>
						<span><?php echo yii::t('app','Route Name')?>:</span>
						<input type="text" id="route_name" name="route_name" class="doubleWidth"></input>
						<input type="hidden" id="route_name_hidden" value=""></input>
					</label>
				</p>
				<p>
					<label>
						<span><?php echo yii::t('app','Start Time')?>:</span>
						<input type="text" id="start_time" name="start_time" class="Wdate"></input>
						<input type="hidden" id="start_time_hidden" value=""></input>
					</label>
					<label>
						<span><?php echo yii::t('app','End Time')?>:</span>
						<input type="text" id="end_time" name="end_time" class="Wdate"></input>
						<input type="hidden" id="end_time_hidden" value=""></input>
					</label>
					<label>
						<span><?php echo yii::t('app','Route Code')?>:</span>
						<input type="text" id="route_code" name="route_code"></input>
						<input type="hidden" id="route_code_hidden" value=""></input>
					</label>
				</p>
				<p class="btnBox2">
					<input type="submit" id="search" value="SEARCH" class="btn1"></input>
				</p>
			</div>
			<div class="pBox">
				<table id="ticket_center_table">
				<input type="hidden" id="pag" value="<?php echo $pag;?>"></input>
					<thead>
						<tr>
							<th><?php echo yii::t('app','No.')?></th>
							<th><?php echo yii::t('app','Order Number')?></th>
							<th><?php echo yii::t('app','Route Code')?></th>
							<th><?php echo yii::t('app','Route Name')?></th>
							<th><?php echo yii::t('app','Order Price')?></th>
							<th><?php echo yii::t('app','Order Time')?></th>
							<th><?php echo yii::t('app','Status')?></th>
							<th><?php echo yii::t('app','Operation')?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($order as $key=>$value ) :?>
						<tr>
							<td><?php echo $key+1?></td>
							<td><?php echo $value['order_serial_number']?></td>
							<td><?php echo $value['voyage_code']?></td>
							<td><?php echo $value['voyage_name']?></td>
							<td>￥<?php echo $value['total_pay_price']?></td>
							<td><?php echo $value['create_order_time']?></td>
							<td><?php echo $value['pay_status'] == 0 ? yii::t('app','To Be Paid') : yii::t('app','Finished')  ?></td>
							<td>
								<button class="btn1" onclick="alertinfo('<?php echo $value['order_serial_number']?>');"><img src="<?=$baseUrl ?>images/right.png"></button>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<p class="records"><?php echo yii::t('app','Records')?>:<span id="count"><?php echo $count;?></span></p>
				<div class="center" id="ticket_center_page_div"> </div>
			</div>
		</div>
	</div>
<!-- main content end -->

<script type="text/javascript">
window.onload = function(){ 
	var count_page =  $("#count").html();	
	get_page(count_page);


	$("#search").click(function(){
		var order_no = $("#order_no").val();
		var route_name = $("#route_name").val();
		var start_time = $("#start_time").val();
		var end_time = $("#end_time").val();
		var route_code = $("#route_code").val();
		
		$("#order_no_hidden").val(order_no);
	    $("#route_name_hidden").val(route_name);
		$("#start_time_hidden").val(start_time);
		$("#end_time_hidden").val(end_time);
		$("#route_code_hidden").val(route_code);
		
		
		$.ajax({
			url:"<?php echo Url::toRoute(['ticket_center_search']);?>",
			type:'post',
			data:'order_no='+order_no+"&route_name="+route_name+"&route_code="+route_code+"&start_time="+start_time+"&end_time="+end_time,
			dataType:'json',
			success:function(data){
				var str='';
	     		if(data != 0){
	                $.each(data,function(key){
	                	var k=parseInt(key+1);
		                if(key<2){
                    	str += "<tr>";
                        str += "<td>"+k+"</td>";
                        str += "<td>"+data[key]['order_serial_number']+"</td>";
                        str += "<td>"+data[key]['voyage_code']+"</td>";
                        str += "<td>"+data[key]['voyage_name']+"</td>";
                        str += "<td>"+data[key]['total_pay_price']+"</td>";
                        str += "<td>"+data[key]['create_order_time']+"</td>";
                        str += "<td>";
                        str +=data[key]['pay_status']==0?"<?php echo yii::t('app','To Be Paid');?>":"<?php echo yii::t('app','Finished');?>";
                        str += "</td>";
                        str += "<td>";
                        str += "<button onclick='alertinfo("+data[key]['order_serial_number']+");' code='"+data[key]['order_serial_number']+"' class='btn1'><img src='<?php echo $baseUrl;?>images/right.png'></button>";
                        str += "</td>";
                        str += "</tr>";
		                }
                      });
	            $("#count").html(data['count']);
				get_page(data['count']); 
	            $("table#ticket_center_table > tbody").html(str);
        		}  else{
					$("table#booking_ticke_table > tbody").html('');
				}
			}
		});
	});

}
function alertinfo(id){
	location.href="<?php echo Url::toRoute(['ticket_center_info']);?>&id="+id;
}

function get_page(count)
{
	var booking_total = parseInt(Math.ceil(count/2));
	if(booking_total==0){
		booking_total=1;
		}
	
		$('#ticket_center_page_div').jqPaginator({
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

		    	var order_no_hidden = $("#order_no_hidden").val();
		    	var route_name_hidden = $("#route_name_hidden").val();
		    	var start_time_hidden = $("#start_time_hidden").val();
		    	var end_time_hidden = $("#end_time_hidden").val();
		    	var route_code_hidden = $("#route_code_hidden").val();
		    	
			    var where_data = "&order_no_hidden="+order_no_hidden+"&route_name_hidden="+route_name_hidden+"&start_time_hidden="+start_time_hidden+"&end_time_hidden="+end_time_hidden+"&route_code_hidden="+route_code_hidden; 

		    	$.ajax({
	                url:"<?php echo Url::toRoute(['get_ticket_center_page']);?>",
	                type:'post',
	                data:'pag='+num+where_data,
	             	dataType:'json',
	            	success:function(data){
		            	
	                	var str = '';
	            		/* if(data != 0){
	            			var tmp = "";
	            			tmp += "{{each ticket}}";
	            			tmp += "<tr>";
	            			tmp +="<td>{{$index + 1}}</td>";
	            			tmp +="<td>{{$value.order_serial_number}}</td>";
	            			tmp +="<td>{{$value.voyage_code}}</td>";
	            			tmp +="<td>{{$value.voyage_name}}</td>";
	            			tmp +="<td>￥{{$value.total_pay_price}}</td>";
	            			tmp +="<td>{{$value.create_order_time}}</td>";
	            			tmp +="<td>{{$value.pay_status=='0'?'<php echo yii::t('app','To Be Paid');?>':'<pp echo yii::t('app','Finished');?>'}}</td>";
	            			tmp +="<td>";	        
							tmp +="<button code='{{$value.order_serial_number}}' class='btn1'><img src='<p]hp echo $baseUrl;?>images/right.png'></button>";
							tmp +="{{$value.pay_status=='0'}}"?"<button code='{{$value.order_serial_number}}' class='btn2'><img src='?hp echo $baseUrl;?>images/delete.png'></button>":'';
								
	            			tmp +="</td></tr>";
	            			tmp +="{{/each}}";
							var render = template.compile(tmp);
							var html = render({ticket:data});
		    	         	$("table#ticket_center_table > tbody").html(html);
	    	            } */
	            		if(data != 0){
	    	                $.each(data,function(key){
	                        	str += "<tr>";
	                            str += "<td>"+(key+1)+"</td>";
	                            str += "<td>"+data[key]['order_serial_number']+"</td>";
	                            str += "<td>"+data[key]['voyage_code']+"</td>";
	                            str += "<td>"+data[key]['voyage_name']+"</td>";
	                            str += "<td>"+data[key]['total_pay_price']+"</td>";
	                            str += "<td>"+data[key]['create_order_time']+"</td>";
	                            str += "<td>";
	                            str +=data[key]['pay_status']==0?"<?php echo yii::t('app','To Be Paid');?>":"<?php echo yii::t('app','Finished');?>";
	                            str += "</td>";
	                            str += "<td>";
	                            str += "<button onclick='alertinfo("+"'"+data[key]['order_serial_number']+"'"+");' code='"+data[key]['order_serial_number']+"' class='btn1'><img src='<?php echo $baseUrl;?>images/right.png'></button>";
	                            str += "</td>";
		                        str += "</tr>";
	                          });
	    	                $("table#ticket_center_table > tbody").html(str);
	            	}      
	           
	    	}
		});
	}
	});
}
</script>



