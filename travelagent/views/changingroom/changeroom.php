<?php
$this->title = 'Agent Ticketing';
use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

?>
<!-- main content start -->
<div id="changeroom" class="mainContent">
    <div id="topNav">
    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Change Room')?></a>
    </div>
    <div id="mainContent_content">
		<!-- 请用ajax提交 -->
		<div class="pBox search">
				<p>
					<label>
						<span><?php echo yii::t('app','Route Code')?>:</span>
							<select class="doubleWidth" name="voyage_code">
							<option value=""><?php echo \Yii::t('app','All')?></option>
							<?php foreach ($voyageinfo as $k=>$v):?>
								<option value="<?php echo $v['voyage_code']?>"> <?php echo $v['voyage_code']?></option>
								<?php endforeach;?>
							</select>
					</label>
					<label>
						<span><?php echo yii::t('app','Cabin Name')?>:</span>
						<input type="text" id="cabin_name" name="cabin_name"></input>
					</label>
				<input type="button" id="search" value="SEARCH" class="btn1"></input>
				</p>
			</div>
			<div class="pBox">
				<table id="ticket_center_table">
				<input type="hidden" id="pag" value="<?php echo '1';?>"></input>
					<thead>
						<tr>
							<th><?php echo yii::t('app','No.')?></th>
							<th><?php echo yii::t('app','Route Code')?></th>
							<th><?php echo yii::t('app','Cabin Name')?></th>
							<th><?php echo yii::t('app','Cabin Price')?></th>
							<th><?php echo yii::t('app','Check Number')?></th>
							<th><?php echo yii::t('app','Operation')?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($data as $key=>$value ) :?>
					<?php if($key<2){?>
						<tr>
							<td><?php echo $key+1?></td>
							<td><?php echo $value['voyage_code']?></td>		
							<td><?php echo $value['cabin_name']?></td>
							<td>￥<?php echo $value['cabin_price']?></td>
							<td><?php echo $value['check_in_number']?></td>
							<td>
							<select name="cabin_name<?php echo $key?>" id="cabin_name<?php echo $key?>">
							<option value="<?php echo $value['cabin_name'] ?>"><?php echo $value['cabin_name'] ?>(own)</option>
							<?php foreach ($value['changcabin'] as $k=>$v):?>
							<option value="<?php echo $v['cabin_name']?>"><?php echo $v['cabin_name']?></option>
							<?php endforeach;?>
							</select>
							<input type="button" class="btn1" onclick="changeownroom('<?php echo $value['voyage_code'].','.$value['cabin_type_code'].','.$key.','.$value['cabin_name']?>')" value="change">
							</td>
						</tr>
						<?php }?>
					<?php endforeach;?>
					</tbody>
				</table>
				<p class="records"><?php echo yii::t('app','Records')?>:<span id="count"><?php echo sizeof($data)?></span></p>
				<div class="center" id="ticket_center_page_div"> </div>
			</div>
		</div>
	</div>
	<input type="hidden" id="t" value="">
<!-- main content end -->
<script type="text/javascript">
function changeownroom(voyage){
	var voyage=voyage.split(",");
	var cabin="#cabin_name"+voyage[2];
	var cabin_name=$(cabin).val();
	var voyage_code=voyage[0];
	var cabin_type_code=voyage[1];
	var owncabin_name=voyage[3];
    $.ajax({  
        url:"<?php echo Url::toRoute(['changeownroom']);?>",
        data:{cabin_name:cabin_name,voyage_code:voyage_code,cabin_type_code:cabin_type_code,owncabin_name:owncabin_name},
        type: 'POST',  
        dataType: 'json',  
        timeout: 3000,  
        cache: false,  
        beforeSend: LoadFunction, //加载执行方法      
        error: erryFunction,  //错误执行方法      
        success: succFunction //成功执行方法      
    }) 
    function LoadFunction() {  
        $("#list").html('加载中...');  
    }  
    function erryFunction() {  
        alert("error");  
    }  
    function succFunction(tt) {  
	         if(tt==0){
				Alert("Option fail");
				$(".cancel_but").click(function(){
				location.href="<?php echo Url::toRoute(['changeroom']);?>";
				});
		         }
	         else if(tt==1){
				Alert("Option success");
				$(".cancel_but").click(function(){
				location.href="<?php echo Url::toRoute(['changeroom']);?>";
				});
		         }      
    } 
}
window.onload = function(){ 
	var count_page =  $("#count").html();	
	get_page(count_page);
	$("#search").click(function(){
		var voyage_code=$("select[name=voyage_code]").val();
		var cabin_name=$("input[name=cabin_name]").val();
		var t=1;
		$("#t").val('1');
		$.ajax({
			 url:"<?php echo Url::toRoute(['getchangeroompage']);?>",
             type:'post',
             data:{voyage_code:voyage_code,cabin_name:cabin_name,t:t},
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
		    	var voyage_code=$("select[name=voyage_code]").val();
		    	var cabin_name=$("input[name=cabin_name]").val();
		    	var t=$("#t").val();
		    	$.ajax({
	                url:"<?php echo Url::toRoute(['getchangeroompage']);?>",
	                type:'post',
	                data:{voyage_code:voyage_code,cabin_name:cabin_name,pag:num,t:t},
	             	dataType:'json',
	            	success:function(data){
	                	var str = '';
	            		if(data != 0){
	    	                $.each(data,function(key){
		    	            if(key<2){
		    	            	var k=parseInt(key)+1;
	                        	str += "<tr>";
	                            str += "<td>"+k+"</td>";
	                            str += "<td>"+data[key]['voyage_code']+"</td>";
	                            str += "<td>"+data[key]['cabin_name']+"</td>";
	                            str += "<td>"+data[key]['cabin_price']+"</td>";
	                            str += "<td>"+data[key]['check_in_number']+"</td>";
	                            str += "<td><select name='cabin_name"+key+"' id='cabin_name"+key+"'>" ;
	                            str += "<option value='"+data[key]['cabin_name']+"'>"+data[key]['cabin_name']+"(own)</option>" 	
								for(var i=0;i<data[key]['changcabin'].length;i++){
									str +="<option value='"+data[key]['changcabin'][i]['cabin_name']+"'>"+data[key]['changcabin'][i]['cabin_name']+"</option>"
									}
								str += "</select>";
								str +="<input type='button' class='btn1' onclick='changeownroom(\""+data[key]['voyage_code']+","+data[key]['cabin_type_code']+","+key+","+data[key]['cabin_name']+"\")' value='change'>";
								str +="</td>";
		                        str += "</tr>";
		    	            }
	                          });
	    	                $("table#ticket_center_table > tbody").html(str);
	            	}  
	            		else{
	            			$("#count").html("0");
	    					$("table#ticket_center_table > tbody").html("");
		            		} 
            		
	           
	    	}
		});
	}
	});
}
</script>



