<?php
$this->title = 'Travelagent Management';


use app\modules\membermanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);
?>
	<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.2.min.js"></script>
	<script src="<?php echo $baseUrl?>js/jqPaginator.js"></script>	
	<style type="text/css">
	.shadow { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #000; opacity: 0.5; }
		.searchResult div { border: 1px solid #e0e9f4; }
		.searchResult div div { padding: 20px; }
		.searchResult label { margin-right: 20px; }
		.searchResult label span { display: inline-block; width: 100px; text-align: right; }
		.searchResult input:not([type="submit"]) { width: 300px; }
		.searchResult input[readonly="readonly"] { background: #eee; }
		#searchBox {position: fixed;width: 800px;margin: -200px 0 0 -400px;top: 50%;left: 50%; background: #fff;}
		#searchBox div { padding: 10px 20px; }
		#searchBox label { margin-right: 20px; }
		#searchBox .red { color: red; }
		
	 .point { outline-color: red; border: 2px solid red; }
	 .error { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    .error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
	</style>
<!-- content start -->
<div class="r content">
			<div class="topNav"><?php echo yii::t('vcos', 'Membership Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('vcos', 'Recharge')?></a></div>
			<div class="search">
				<label>
					<span><?php echo yii::t('vcos', 'Member No.:')?></span>
					<input type="text" id="m_code"></input>
				</label>
				<label>
					<span><?php echo yii::t('vcos', 'Member Name:')?></span>
					<input type="text" id="m_name"></input>
				</label>
				<span class="btn"><input type="button" id="selectmember" value="<?php echo yii::t('vcos', 'SEARCH')?>" onclick="selectmember();"></input></span>
			</div>
			<div class="searchResult">
			<form method="post">
			<input id="m_id" type="hidden" name="m_id">
			<input type="hidden" name="m_code" value="<?php echo isset($code)?$code:''?>">
				<div>
					<div>
						<label>
					
							<span><?php echo yii::t('vcos', 'Member Name:')?></span>
							<input type="text" style="border:#B0B0B0 1px solid"  name="member_name2" value="<?php echo isset($member_name2)?$member_name2:''?>" readonly="readonly" class="doubleWidth"></input>
						</label>
						<span class="error"   id="isname" style="display:none"><?php echo yii::t('app','Please select to top-up agents')?></span>
						<label>
							<span><?php echo yii::t('vcos', 'Balance:')?></span>
							<input type="text" name="balance" style="border:#B0B0B0 1px solid" value="<?php echo isset($balance)?$balance:''?>" readonly="readonly"></input>
						</label>
					</div>
					<div>
						<label>
							<span><?php echo yii::t('vcos', 'Recharge:')?></span>
							<input type="text" name="recharge"  id='recharge'></input>
						</label>
							<span class="error"   id="isrecharge" style="display:none"><?php echo yii::t('app','Recharge must be Num and only two decimal')?></span>
						<label>
							<span><?php echo yii::t('vcos', 'Remarks:')?></span>
							<input type="text" name="remarks" class="doubleWidth"></input>
						</label>
						<span class="btn">
							<input type="submit" value="<?php echo yii::t('vcos', 'CONFIRM')?>" id="confirm"></input>
						</span>
					</div>
					<div>
					</form>
						<p><?php echo yii::t('vcos', 'Recharge Records:')?></p>
						<table>
							<thead>
								<tr>
									<th><?php echo yii::t('vcos', 'No.')?></th>
									<th><?php echo yii::t('vcos', 'Member No.')?></th>
									<th><?php echo yii::t('vcos', 'Member Name')?></th>
									<th><?php echo yii::t('vcos', 'Recharge')?></th>
									<th><?php echo yii::t('vcos', 'Time')?></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if (!empty($pagedata)){
							foreach ($pagedata as $k=>$v):?>
								<tr>
									<td><?php echo $k+1?></td>
									<td><span style="cursor:pointer;" title="<?php echo yii::t('vcos', $v['remarks'])?>"><?php echo yii::t('vcos', $v['m_code'])?></span></td>
									<td><span style="cursor:pointer;" title="<?php echo yii::t('vcos', $v['remarks'])?>"><?php echo yii::t('vcos', $v['m_name'])?></span></td>
									<td><?php echo yii::t('vcos', $v['recharge_amount'])?></td>
									<td><?php echo date("d/m/Y H:i:s",strtotime($v['recharge_time']))?></td>
									<?php endforeach;
									}
									?>
								</tr>
							</tbody>
						</table>
						<form id="member_list" method="post">
						<input type="hidden"  name="proty_m_code" value="<?php echo isset($code)?$code:''?>">
						<input type="hidden" id="balance" name="balance" value="<?php echo isset($balance)?$balance:''?>">
						<input type="hidden" id="member_name2" name="member_name2" value="<?php echo isset($member_name2)?$member_name2:''?>">
					<div class="pageNum" style="border:medium none;margin-left:35%;margin-bottom:0px">
				 	<input type='hidden' name='page' value="<?php echo isset($page)?$page:'1'?>">
                 	<input type='hidden' name='isPage' value="1">
                 	<div class="center" style="border:medium none;margin-bottom:0px" id="page_div"></div> 
	            	</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">

jQuery(function($) {
	/* 获取参数 */
	//分页
	var page = <?php echo isset($page)?$page:'1';?>;
		$('#page_div').jqPaginator({
            totalPages: <?php echo isset($count)?$count:'1';?>,
            visiblePages: 5,
            currentPage: page,
         
            first:  '<a href="javascript:void(0);">First</a>',
            prev:   '<a href="javascript:void(0);">«</a>',
            next:   '<a href="javascript:void(0);">»</a>',
            last:   '<a href="javascript:void(0);">Last</a>',
            page:   '<a href="javascript:void(0);">{{page}}</a>',
            onPageChange: function (num) {
                var val = $("input[name='page']").val();
                if(num != val)
                {
                    $("input[name='page']").val(num);
                    $("input[name='isPage']").val(2);
                    $("form#member_list").submit();
                }
            }
        });	
	
});  
function selectmember() { 
    var m_code = $('#m_code').val();  
    var m_name = $('#m_name').val(); 
    $.ajax({  
        url: '<?php echo Url::toRoute(['travel_recharge'])?>',  
        type: 'POST',  
        data:{code:m_code,name:m_name},
        dataType: 'json',  
        timeout: 3000,  
        cache: false,  
        beforeSend: LoadFunction, //加载执行方法      
        error: erryFunction,  //错误执行方法      
        success: succFunction //成功执行方法      
    })  
    function LoadFunction() {  
    	  $("table#type_config_table > tbody").html('<tr><td colspan="3" style="font-size:18px;font-weight:bold;"><?php echo yii::t('vcos', 'Is trying to load,Please Wait...')?></td></tr>');  
    }  
    function erryFunction() {  
        alert("error");  
    }  
    function succFunction(data) {  
        //$("#gradevalue").html('');  
        var json = eval(data); //数组
      var str='';
        $.each(data,function(key){
        	str += "<tr>";
            str += "<td>"+data[key]['m_code']+"</td>";
            str += "<td>"+data[key]['m_name']+"</td>";     
            str += "<td class='btn'><input type='button' class='close' onclick='getmemberid("+data[key]['m_id']+")' value='choose'></input></td>";
            str += "</tr>";
          });
        $("table#type_config_table > tbody").html(str);
        closeSearchBox();
      //  $.each(json, function (index, item) { 
         //  $("#agentwhere").html($("#agentwhere").html()+"<span style='margin-left:5%'>Agent No.:</span>"+json[index].travel_agent_code+""+"<span style='margin-left:170px'>Agent Name:</span>"+json[index].travel_agent_name+"<button type='button' class='undelete' style='margin-left:40px' onclick='getagentid("+json[index].travel_agent_id+")'>submit</button><br/><br/>");
        	// $("#agentwnere").html($("#list").html() + "<br>"  + "<input type='text' id='"  + "' /><br/>");  
      //  $("#city_code").append($("<option/>").text(json[index].city_name).attr("value",json[index].city_code));
      //循环获取数据      
//             var Id = json[index].id;  
//             var Name = json[index].name;  
//             $("#gradevalue").html($("#list").html() + "<br>" + Name + "<input type='text' id='" + Id + "' /><br/>");  
      //  });  
        
      
    }  
};

function mmember() {
    var m_code = $('#mcode').val();  
    var m_name = $('#mname').val(); 
    $.ajax({  
        url: '<?php echo Url::toRoute(['travel_recharge'])?>',  
        type: 'POST',  
        data:{code:m_code,name:m_name},
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
    function succFunction(data) {  
        //$("#gradevalue").html('');  
        var json = eval(data); //数组
     	var str='';
        $.each(data,function(key){
        	str += "<tr>";
            str += "<td>"+data[key]['m_code']+"</td>";
            str += "<td>"+data[key]['m_name']+"</td>";     
            str += "<td class='btn'><input type='button' class='close' onclick='getmemberid("+data[key]['m_id']+")' value='choose'></input></td>";
            str += "</tr>";
          });
        $("table#type_config_table > tbody").html(str);
        closeSearchBox();
      //  $.each(json, function (index, item) { 
         //  $("#agentwhere").html($("#agentwhere").html()+"<span style='margin-left:5%'>Agent No.:</span>"+json[index].travel_agent_code+""+"<span style='margin-left:170px'>Agent Name:</span>"+json[index].travel_agent_name+"<button type='button' class='undelete' style='margin-left:40px' onclick='getagentid("+json[index].travel_agent_id+")'>submit</button><br/><br/>");
        	// $("#agentwnere").html($("#list").html() + "<br>"  + "<input type='text' id='"  + "' /><br/>");  
      //  $("#city_code").append($("<option/>").text(json[index].city_name).attr("value",json[index].city_code));
      //循环获取数据      
//             var Id = json[index].id;  
//             var Name = json[index].name;  
//             $("#gradevalue").html($("#list").html() + "<br>" + Name + "<input type='text' id='" + Id + "' /><br/>");  
      //  });  
        
      
    }  
};
$(function(){
   $("#recharge").focus(function(){
	   $("#isrecharge").css("display","none");
	   });
	/*   数据校验*/
	$("#confirm").click(function(){
	var m_code= $("input[name=m_code]").val();
	if(m_code==''){
	$("#isname").css("display","");
	return false;
	}
	var reg=/^\d+(\.\d{2})?$/;
	var recharge=$("#recharge").val();
	if(!reg.test(recharge)){
	$("#isrecharge").css("display","");
     return false;
		}
	
	});/* 数据校验 */
	$("#searchBox").css("display","none");
	$(".shadow").css("display","none");
	$("#selectmember").click(function(){//弹出框
		$("#searchBox").css("display","block");
		$(".shadow").css("display","block");
		});
	
	closeSearchBox();
});
function closeSearchBox() {
	$("#searchBox .close").click(function(){	
		$("#searchBox").css("display","none");
		$(".shadow").css("display","none");
		$("#isname").css("display","none");
	});
}

function getmemberid(id){//给充值框赋值
	
    $.ajax({  
        url: '<?php echo Url::toRoute(['member_recharge'])?>',  
        type: 'POST',  
        data:{memberid:id},
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
        //$("#gradevalue").html('');  
        var json = eval(tt); //数组
        $.each(json, function (index, item) { 
            $("#member_name2").val(json[index].m_name);
            $("#balance").val(json[index].balance);
            $("input[name=m_code]").val(json[index].m_code);
            $("#m_id").val(json[index].m_id);
          
        	// $("#agentwnere").html($("#list").html() + "<br>"  + "<input type='text' id='"  + "' /><br/>");  
      //  $("#city_code").append($("<option/>").text(json[index].city_name).attr("value",json[index].city_code));
      //循环获取数据      
//             var Id = json[index].id;  
//             var Name = json[index].name;  
//             $("#gradevalue").html($("#list").html() + "<br>" + Name + "<input type='text' id='" + Id + "' /><br/>");  
        });  
    	var m_code=$("input[name=m_code]").val();
		if(m_code!=''){
		$("input[name=proty_m_code]").val(m_code);
		$("form#member_list").submit();
		}   
      
    }  
}
</script>
<div class="shadow"></div>
	<div id="searchBox" class="pop-ups">
		<h3><?php echo yii::t('vcos','Search')?><a href="#" class="close r">&#10006;</a></h3>
		<div>
			<div>
				<label>
					<span><?php echo yii::t('vcos','Member No.:')?></span>
					<input type="text" id="mcode"></input>
				</label>
				<label>
					<span><?php echo yii::t('vcos','Member Name:')?></span>
					<input type="text" id="mname"></input>
				</label>
				<span class="btn">
					<input type="button" value="<?php echo yii::t('vcos','SEARCH')?>" onclick="mmember();"></input>
				</span>
			</div>
			<div>
				  <table id="type_config_table">
					<thead>
						<tr>
							
							<th><?php echo yii::t('vcos','Member No.')?></th>
							<th><?php echo yii::t('vcos','Member Name')?></th>
							<th><?php echo yii::t('vcos','Choose')?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>