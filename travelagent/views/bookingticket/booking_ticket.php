<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
//use travelagent\views\myasset\PublicAssetPage;
use travelagent\components\Helper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';
//PublicAssetPage::register($this);
//$baseUrl_page = $this->assetBundles[PublicAssetPage::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<!-- main content start -->
<div id="reservation" class="mainContent">
    <div id="topNav">
    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Booking Ticket')?></a>
    </div>
    <div id="mainContent_content">
		<!-- 请用ajax提交 -->
		<div class="pBox search">
			<label>
				<span><?php echo yii::t('app','Sailing Date')?>:</span>
				<span>
					<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en'})" id="sailing_date" name="sailing_date"></input>
					<input type="hidden" id="sailing_date_hidden" value=""></input>
				</span>
			</label>
			<label>
				<span><?php echo yii::t('app','Route Name')?>:</span>
				<span>
					<input type="text" id="route_name" name="route_name"></input>
					<input type="hidden" id="route_name_hidden" value=""></input>
				</span>
			</label>
			<label>
				<span><?php echo yii::t('app','Route Code')?>:</span>
				<span>
					<input type="text" id="route_code" name="route_code"></input>
					<input type="hidden" id="route_code_hidden" value=""></input>
				</span>
			</label>
			<input type="submit" id="search" value="SEARCH" class="btn1"></input>
		</div>
		<div class="pBox">
			<table id="booking_ticke_table">
			<input type="hidden" id="booking_ticke_page" value="<?php echo $booking_ticke_pag;?>" />
				<thead>
					<tr>
						<th><?php echo yii::t('app','Route Code')?></th>
						<th><?php echo yii::t('app','Price')?></th>
						<th><?php echo yii::t('app','Sailing Date')?></th>
						<th><?php echo yii::t('app','Return Date')?></th>
						<th><?php echo yii::t('app','Route Name')?></th>
						<!-- <th>Shore Excursions</th>
						<th>Departure Port</th> -->
						<th>Operation</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($result as $v){?>
					<tr>
						<td><?php echo $v['voyage_code']?></td>
						<td><?php echo $v['ticket_price']?></td>
						<td><?php echo Helper::GeNewtDate($v['start_time'])?></td>
						<td><?php echo Helper::GeNewtDate($v['end_time'])?></td>
						<td><?php echo $v['voyage_name']?></td>
						<td><a href="<?php echo Url::toRoute(['inputmode'])?>&code=<?php echo $v['voyage_code']?>"><button class="btn1" code="<?php echo $v['voyage_code']?>"><img src="<?=$baseUrl ?>images/right.png"></button></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			<p class="records"><?php echo yii::t('app','Records')?>:<span id="count"><?php echo $count?></span></p>
			<div class="center" id="booking_ticke_page_div"> </div>
		</div>
	</div>
</div>
<!-- main content end -->

<script type="text/javascript">
window.onload = function(){
	var count_page =  $("#count").html();	
	get_page(count_page);
	$("#search").click(function(){
		var sailing_date = $("#sailing_date").val();
		var route_name = $("#route_name").val();
		var route_code = $("#route_code").val();
		
		$("#sailing_date_hidden").val(sailing_date);
	    $("#route_name_hidden").val(route_name);
		$("#route_code_hidden").val(route_code);
		
		$.ajax({
			url:"<?php echo Url::toRoute(['bookingticketsearch']);?>",
			type:'post',
			data:'sailing_date='+sailing_date+"&route_name="+route_name+"&route_code="+route_code,
			dataType:'json',
			success:function(data){
			
				if(data != 0){
					var result = data['result'];
					var count = data['count'];

					
					var tmp = "{{each voyage}}";
					var num="{{$index}}";
					
					tmp+="<tr>";
					tmp+="<td>{{$value.voyage_code}}</td>"+
						"<td>{{$value.ticket_price}}</td>"+
						"<td>{{$value.start_time}}</td>"+
						"<td>{{$value.end_time}}</td>"+
						"<td>{{$value.voyage_name}}</td>"+
						"<td><a href='<?php echo Url::toRoute(['inputmode'])?>&code={{$value.voyage_code}}'><button code='{{$value.voyage_code}}' class='btn1'> <img src='<?php echo $baseUrl;?>images/right.png'>"+
						"</button>";
					tmp+="</td>";
			
					tmp+="{{/each}}";
					var render = template.compile(tmp);
					var html = render({voyage:result});
		            $("table#booking_ticke_table > tbody").html(html);
		            
		            $("#count").html(count);
		            get_page(count);  
				}else{
					 $("#count").html('0');
					$("table#booking_ticke_table > tbody").html('');
				}
			}
		});
	});

	$(document).on('click',"#booking_ticke_table button.btn1",function(){
		var voyage_code = $(this).parent().finc
	});

}


function get_page(count){
	var booking_total = parseInt(Math.ceil(count/2));
	if(booking_total >1){
		$('#booking_ticke_page_div').jqPaginator({
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
		    	var this_page = $("input#booking_ticke_page").val();
		    	if(this_page==num){$("input#booking_ticke_page").val('fail');return false;}
	
		    	var sailing_date_hidden = $("#sailing_date_hidden").val();
		    	var route_name_hidden = $("#route_name_hidden").val();
		    	var route_code_hidden = $("#route_code_hidden").val();
			    var where_data = "&sailing_date_hidden="+sailing_date_hidden+"&route_name_hidden="+route_name_hidden+"&route_code_hidden="+route_code_hidden; 
			    	
			    $.ajax({
					url:"<?php echo Url::toRoute(['getbookingticketpage']);?>",
		          	type:'post',
		           	data:'pag='+num+where_data,
		           	dataType:'json',
		           	success:function(data){
		            	var str = '';
		            	if(data != 0){
		            		$.each(data,function(k){
			            		str +=	"<tr>";
			        			str +=	"<td>"+data[k]['voyage_code']+"</td>";
			        			str +=	"<td>"+data[k]['ticket_price']+"</td>";
			        			str +=	"<td>"+createDate(data[k]['start_time'])+"</td>";
			        			str +=	"<td>"+createDate(data[k]['end_time'])+"</td>";
			        			str +=	"<td>"+data[k]['voyage_name']+"</td>";
			        			str +=	"<td><a href='<?php echo Url::toRoute(['inputmode'])?>&code="+data[k]['voyage_code']+"'><button code='"+data[k]['voyage_code']+"' class='btn1'><img src='<?php echo $baseUrl;?>images/right.png'>";
			        			str +=	"</button>";
			        			str +=	"</td>";
			        			str +=	"</tr>";
		            		});
		    	         	$("table#booking_ticke_table > tbody").html(str);
		    	     	}
		          	}
		      	});
			}
		});
	}else{
		$('#booking_ticke_page_div').html('');
	}
}
</script>



