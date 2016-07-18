<?php
use yii\helpers\Url;
$this->title = 'Report Management';

use app\modules\reportmanagement\themes\basic\myasset\ThemeAsset;
use app\modules\reportmanagement\themes\basic\myasset\ThemeAssetDate;
ThemeAsset::register($this);
ThemeAssetDate::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

?>

<!-- content start -->
<div class="r content" id="refundReason_content">
	<div class="topNav">Report Manage&nbsp;&gt;&gt;&nbsp;<a href="#">Boarding Report</a></div>
	<div class="search">
	<p>
		<label>
			<span><?php echo yii::t('app','Date:')?></span>
			<input type="text" id="date" name="date" placeholder="<?php echo yii::t('app','please choose')?>" value="<?php echo date("Y-m",time());?>" onfocus="WdatePicker({dateFmt:'yyyy-MM',lang:'en',readOnly:'false',isShowClear:false,onpicking:getvoyageport()})" class="Wdate"  ></input>
		</label>
		<label>
			<span><?php echo yii::t('app','Voyage:')?></span>
			<select id="voyage">
				<?php foreach($voyage as $row):?>
				<option value="<?php echo $row['voyage_code']?>"><?php echo $row['voyage_code']."--".$row['voyage_name']?></option>
				<?php endforeach;?>
			</select>
		</label>
	</p>
	<p>
		<label>
			<span><?php echo yii::t('app','Port:')?></span>
			<select id="port">
				<?php foreach ($port as $row):?>
				<option value="<?php echo $row['id']?>"><?php echo $row['port_name']?></option>
				<?php endforeach;?>
			</select>
		</label>
		<label>
			<span><?php echo yii::t('app','MemberType:')?></span>
			<select id="member_type">
				<option value="1"><?php echo yii::t('app','Member')?></option>
				<option value="2"><?php echo yii::t('app','Crew')?></option>
				<option value="3"><?php echo yii::t('app','Visitor')?></option>
			</select>
		</label>
		<label>
			<span><?php echo yii::t('app','BoardingType:')?></span>
			<select id="bording_type">
				<option value="-1">未登船</option>
				<option value="1">登船</option>
				<option value="2">下船</option>
			</select>
		</label>
		<span class="btn"><input type="button" id="search" value="<?php echo yii::t('app','Search')?>"></input></span>
	</p>
	
	</div>
	
	<div class="searchResult">
	<div style="margin-bottom:20px;">
		<span>航线名：中韩三日游</span>
		<span class="r"><button class="btn1" id="export">导出EXCEL</button></span>
	</div>
	
		<table id="member_table">
			<thead>
				<tr>
					<th>序号</th>
					<th>姓名</th>
					<th>船员类型</th>
					<th>性别</th>
					<th>护照号</th>
					<th>房间号</th>
					<th>港口</th>
					<th>上落点</th>
					<th>时间</th>
					<th>类型</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<p class="records">Records:<span id="count">0</span></p>
	</div>
	<!-- 分页 -->
    <div class="center" id="report_page_div"> </div>
    <input type="hidden" id="curr_page" value="1">
</div>
<!-- content end -->
<script type="text/javascript">
window.onload = function(){
	
	//获取港口
	$("#voyage").on("change",function(){
		var voyage_code = $("#voyage").val();
		var str_port = '';
		$.ajax({
	        url:"<?php echo Url::toRoute(['getport']);?>",
	        type:'get',
	        data:'voyage_code='+voyage_code,
	     	dataType:'json',
	    	success:function(data){
	        	$.each(data,function(key){
	        		str_port += "<option value="+data[key]['id']+">"+data[key]['port_name']+"</option>";
	            });
	            $("#port").html(str_port);
	    	}      
	    });
	});

	
	//点击search
	$("#search").on("click",function(){
		var voyage_code = $("#voyage").val();
		var port_id = $("#port").val();
		var member_type = $("#member_type").val();
		var bording_type = $("#bording_type").val();
		var str = '';
		var count = 0;
		$.ajax({
	        url:"<?php echo Url::toRoute(['getmemberinfo']);?>",
	        type:'get',
	        data:'voyage_code='+voyage_code+'&port_id='+port_id+'&member_type='+member_type+'&bording_type='+bording_type,
	     	dataType:'json',
	    	success:function(data){
	        	$.each(data,function(key){
					str += '<tr>';
					str += '<td>'+(key+1)+'</td>';
					str += '<td>'+data[key]['member_name']+'</td>';
					str += '<td>'+data[key]['member_type']+'</td>';
					str += '<td>'+data[key]['gender']+'</td>';
					str += '<td>'+data[key]['passport_number']+'</td>';
					str += '<td>'+data[key]['cabin_name']+'</td>';
					str += '<td>'+data[key]['port_name']+'</td>';
					str += '<td>'+data[key]['gangway_number']+'</td>';
					str += '<td>'+data[key]['boarding_time']+'</td>';
					str += '<td>'+data[key]['gangway_type']+'</td>';
					str += '</tr>';
					count = data[key]['total'];
		        });
		        $("#count").text(count);
		        $("table#member_table > tbody").html(str);

		     	//分页
		     	var total_page = Math.ceil(count / 2);
		     	if(total_page > 1){
		     		$('#report_page_div').jqPaginator({
					    totalPages: total_page,
					    visiblePages: 5,
					    currentPage: 1,
					    wrapper:'<ul class="pagination"></ul>',
					    first: '<li class="first"><a href="javascript:void(0);">First</a></li>',
					    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
					    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
					    last: '<li class="last"><a href="javascript:void(0);">Last</a></li>',
					    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
					    onPageChange: function (num, type) {
					        $("#curr_page").val(num);	//记录当前页码
						    var str_page = '';
					    	$.ajax({
				                url:"<?php echo Url::toRoute(['getreportpage']);?>",
				                type:'get',
				                data:'page='+num+'&voyage_code='+voyage_code+'&port_id='+port_id+'&member_type='+member_type+'&bording_type='+bording_type,
				             	dataType:'json',
				            	success:function(data){
				            		$.each(data,function(key){
				            			str_page += '<tr>';
				            			str_page += '<td>'+(key+1)+'</td>';
				            			str_page += '<td>'+data[key]['member_name']+'</td>';
				            			str_page += '<td>'+data[key]['member_type']+'</td>';
				            			str_page += '<td>'+data[key]['gender']+'</td>';
				            			str_page += '<td>'+data[key]['passport_number']+'</td>';
				            			str_page += '<td>'+data[key]['cabin_name']+'</td>';
				            			str_page += '<td>'+data[key]['port_name']+'</td>';
				            			str_page += '<td>'+data[key]['gangway_number']+'</td>';
				            			str_page += '<td>'+data[key]['boarding_time']+'</td>';
				            			str_page += '<td>'+data[key]['gangway_type']+'</td>';
				            			str_page += '</tr>';
				    		        });
				            	    $("table#member_table > tbody").html(str_page);
				            	}
					    	});
					    }
					});
		     	}else {
			     	$("#report_page_div").html('');
			    }
	    	}   
	    });
	});

	
	//点击导出export
	$("#export").on("click",function(){
		var curr_page = $("#curr_page").val();
		var voyage_code = $("#voyage").val();
		var port_id = $("#port").val();
		var member_type = $("#member_type").val();
		var bording_type = $("#bording_type").val();
		$.ajax({
            url:"<?php echo Url::toRoute(['exportexcel']);?>",
            type:'get',
            data:'page='+curr_page+'&voyage_code='+voyage_code+'&port_id='+port_id+'&member_type='+member_type+'&bording_type='+bording_type,
            dataType:'json'
		}).done(function(data){
		    var $a = $("<a>");
		    $a.attr("href",data.file);
		    $("body").append($a);
		    $a.attr("download",data.path);
		    $a[0].click();
		    $a.remove();
		});
	});
}

//获取港口
function getvoyageport(){
	var date = $("#date").val();
	var str_voyage = '';
	//获取航线
	$.ajax({
        url:"<?php echo Url::toRoute(['getvoyage']);?>",
        type:'get',
        data:'date='+date,
     	dataType:'json',
    	success:function(data){
        	$.each(data,function(key){
        		str_voyage += "<option value="+data[key]['voyage_code']+">"+data[key]['voyage_code']+"--"+data[key]['voyage_name']+"</option>";
            });
            $("#voyage").html(str_voyage);

			//获取港口
            var voyage_code = $("#voyage").val();
    		var str_port = '';
    		$.ajax({
    	        url:"<?php echo Url::toRoute(['getport']);?>",
    	        type:'get',
    	        data:'voyage_code='+voyage_code,
    	     	dataType:'json',
    	    	success:function(data){
    	        	$.each(data,function(key){
    	        		str_port += "<option value="+data[key]['id']+">"+data[key]['port_name']+"</option>";
    	            });
    	            $("#port").html(str_port);
    	    	}
    	    });
    	}      
    });
};
</script>


