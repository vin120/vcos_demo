<?php
$this->title = 'Travelagent Management';


use app\modules\travelagentmanagement\themes\basic\myasset\ThemeAsset;
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
		#searchBox { width: 800px; margin: -200px 0 0 -400px; }
		#searchBox div { padding: 10px 20px; }
		#searchBox label { margin-right: 20px; }
		#searchBox .red { color: red; }
	 .point { outline-color: red; border: 2px solid red; }
	 .error { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    .error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
	</style>
<!-- content start -->
<div class="r content">
			<div class="topNav"><?php echo yii::t('vcos', 'Route Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('vcos', 'Recharge')?></a></div>
			
			<div class="search">
				<label>
					<span><?php echo yii::t('vcos', 'Agent No.')?>:</span>
					<input type="text" id="travel_agent_code"></input>
				</label>
				<label>
					<span><?php echo yii::t('vcos', 'Agent Name')?>:</span>
					<input type="text" id="travel_agent_name"></input>
				</label>
				 <label>
            <span><?php echo yii::t('vcos', 'Status')?>:</span>
            <select name="travel_agent_status" id="travel_agent_status">
                <option value="2"><?php echo yii::t('vcos','All')?></option>
                <option value="1"  ><?php echo yii::t('vcos','Usable')?></option>
                <option value="0" ><?php echo yii::t('vcos','Disabled')?></option>
            </select>
        </label>
				<span class="btn"><input type="button" id="selectagent" value="<?php echo yii::t('vcos', 'SEARCH')?>" onclick="selectagent();"></input></span>
			</div>
			<div class="searchResult">
			<form method="post">
				<div>
					<div>
						<label>
						<input type="hidden" name="travel_agent_id" id="travel_agent_id" value="<?php echo isset($proty_agent_id)?$proty_agent_id:''?>">
							<span><?php echo yii::t('vcos', 'Agent Name')?>:</span>
							<input type="text" style="border:#B0B0B0 1px solid"  name="travel_agent_name" value="<?php echo isset($travel_agent_name)?$travel_agent_name:'' ?>"  readonly="readonly" class="doubleWidth"></input>
						</label>
						<span class="error"   id="isname" style="display:none"><?php echo yii::t('app','Please select to top-up agents')?></span>
						<label>
							<span><?php echo yii::t('vcos', 'Balance')?>:</span>
							<input type="text"  name="current_amount" value="<?php echo isset($current_amount)?$current_amount:''?>" style="border:#B0B0B0 1px solid" readonly="readonly"></input>
						</label>
					</div>
					<div>
						<label>
							<span><?php echo yii::t('vcos', 'Recharge')?>:</span>
							<input type="text" name="recharge" id='recharge'></input>
						</label>
						<span class="error"   id="isrecharge" style="display:none"><?php echo yii::t('app','Recharge must be Num and only two decimal')?></span>
						<label>
							<span><?php echo yii::t('vcos', 'Remarks')?>:</span>
							<input type="text" name="remarks" class="doubleWidth"></input>
						</label>
						<span class="btn">
							<input type="submit" value="<?php echo yii::t('vcos', 'CONFIRM')?>" id="confirm"></input>
						</span>
					</div>
					<div>
					</form>
						<p><?php echo yii::t('vcos', 'Recharge Records')?>:</p>
						<table>
							<thead>
								<tr>
									<th><?php echo yii::t('vcos', 'No.')?></th>
									<th><?php echo yii::t('vcos', 'Agent No.')?></th>
									<th><?php echo yii::t('vcos', 'Agent Name')?></th>
									<th><?php echo yii::t('vcos', 'Recharge')?></th>
									<th><?php echo yii::t('vcos', 'Recharge Name')?></th>
									<th><?php echo yii::t('vcos', 'Time')?></th>
								</tr>
							</thead>
							<tbody>
							<?php
							if (!empty($pagedata)){
							foreach ($pagedata as $k=>$v):?>
								<tr>
									<td><?php echo $k+1?></td>
									<td><span style="cursor:pointer;" title="<?php echo $v['remarks']?>"><?php echo $v['travel_agent_code']?></span></td>
									<td><span style="cursor:pointer;" title="<?php echo  $v['remarks']?>"><?php echo  $v['travel_agent_name']?></span></td>
									<td><?php echo $v['recharge_amount']?></td>
								    <td><?php echo  $v['username']?></td>
									<td><?php echo date("d/m/Y H:i:s",strtotime($v['recharge_time']))?></td>
									<?php endforeach;}?>
								</tr>
							</tbody>
						</table>
						<form id="member_list" method="post">
						<input type="hidden" name="proty_agent_id" id="proty_agent_id" value="<?php echo isset($proty_agent_id)?$proty_agent_id:''?>">
						<input type="hidden" id="travel_agent_name2" name="travel_agent_name" value="<?php echo isset($travel_agent_name)?$travel_agent_name:''?>">
						<input type="hidden" id="current_amount" name="current_amount" value="<?php echo isset($current_amount)?$current_amount:''?>">
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
         
            first:  '<a href="javascript:void(0);"><?php echo yii::t('vcos', 'First')?></a>',
            prev:   '<a href="javascript:void(0);">«</a>',
            next:   '<a href="javascript:void(0);">»</a>',
            last:   '<a href="javascript:void(0);"><?php echo yii::t('vcos', 'Last')?></a>',
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
function selectagent() { 
    var travel_agent_code = $('#travel_agent_code').val();  
    var travel_agent_name = $('#travel_agent_name').val(); 
    var travel_agent_status = $('#travel_agent_status').val(); 
    $.ajax({  
        url: '<?php echo Url::toRoute(['travel_recharge'])?>',  
        type: 'POST',  
        data:{code:travel_agent_code,name:travel_agent_name,status:travel_agent_status},
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
            str += "<td>"+data[key]['travel_agent_code']+"</td>";
            str += "<td>"+data[key]['travel_agent_name']+"</td>";     
            str += "<td class='btn'><input type='button' class='close' onclick='getagentid("+data[key]['travel_agent_id']+")' value='choose'></input></td>";
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

function aagent() {
    var travel_agent_code = $('#acode').val();  
    var travel_agent_name = $('#aname').val(); 
    $.ajax({  
        url: '<?php echo Url::toRoute(['travel_recharge'])?>',  
        type: 'POST',  
        data:{code:travel_agent_code,name:travel_agent_name},
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
            str += "<td>"+data[key]['travel_agent_code']+"</td>";
            str += "<td>"+data[key]['travel_agent_name']+"</td>";     
            str += "<td class='btn'><input type='button' class='close' onclick='getagentid("+data[key]['travel_agent_id']+")' value='choose'></input></td>";
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
	/*   数据校验*/
	 $("#recharge").focus(function(){
	   $("#isrecharge").css("display","none");
	   });
	$("#confirm").click(function(){
	var travel_agent_id=$("#travel_agent_id").val();
	if(travel_agent_id==''){
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
	$("#selectagent").click(function(){
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

function getagentid(id){//给充值框赋值
	
    $.ajax({  
        url: '<?php echo Url::toRoute(['travel_agen_recharge'])?>',  
        type: 'POST',  
        data:{agenid:id},
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
            $("#travel_agent_name2").val(json[index].travel_agent_name);
            $("#current_amount").val(json[index].current_amount);
            $("#travel_agent_id").val(json[index].travel_agent_id);
            $("input[name=proty_agent_id]").val(json[index].travel_agent_id);
        	// $("#agentwnere").html($("#list").html() + "<br>"  + "<input type='text' id='"  + "' /><br/>");  
      //  $("#city_code").append($("<option/>").text(json[index].city_name).attr("value",json[index].city_code));
      //循环获取数据      
//             var Id = json[index].id;  
//             var Name = json[index].name;  
//             $("#gradevalue").html($("#list").html() + "<br>" + Name + "<input type='text' id='" + Id + "' /><br/>");  
        });  
        var proty_agent_id=$("input[name=proty_agent_id]").val();
		if(proty_agent_id!=''){
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
					<span><?php echo yii::t('vcos','Agent No.:')?></span>
					<input type="text" id="acode"></input>
				</label>
				<label>
					<span><?php echo yii::t('vcos','Agent Name:')?></span>
					<input type="text" id="aname"></input>
				</label>
				<span class="btn">
					<input type="button" value="<?php echo yii::t('vcos','SEARCH')?>" onclick="aagent();"></input>
				</span>
			</div>
			<div>
				  <table id="type_config_table">
					<thead>
						<tr>
							
							<th><?php echo yii::t('vcos','Agent No.')?></th>
							<th><?php echo yii::t('vcos','Agent Name')?></th>
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