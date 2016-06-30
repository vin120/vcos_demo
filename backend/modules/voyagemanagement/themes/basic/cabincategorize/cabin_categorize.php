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
<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.2.min.js"></script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo \Yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo \Yii::t('app','Cabin  Category')?></a></div>
   <div class="tab">
				<ul class="tab_title">
				<?php $t=isset($_GET['t'])?$_GET['t']:0?>
					<li <?php echo $t!=1?"class='active'":''?> id="bigclass"><?php echo \Yii::t('app','Big Class')?></li>
					<li <?php echo  $t==1?"class='active'":''?>><?php echo \Yii::t('app','Cabin Classified')?></li>
				
				</ul>
				<div class="tab_content">
					<div  <?php echo $t!=1?"class='active'":''?>>
					 <form method="post" id="member_list">
						<div class="search">
							<label>
								<span><?php echo \Yii::t('app','Cabin Name:')?></span>
								<input type="text" name="class_name" value="<?php echo isset($class_name)?$class_name:''?>">
							</label>
							<span class="btn">
								<input type="submit" value="<?php echo \Yii::t('app','Select')?>"></input>
								<input type="button"  value="<?php echo \Yii::t('app','Insert')?>" id="cabininsert"></input>
							</span>
						</div>
						<div class="searchResult">
							<table>
								<thead>
									<tr>
										<th><?php echo \Yii::t('app','No.')?></th>
										<th><?php echo \Yii::t('app','Cabin Name')?></th>
										<th><?php echo \Yii::t('app','Reference Price')?></th>
										<th><?php echo \Yii::t('app','Status')?></th>
										<th><?php echo \Yii::t('app','Operation')?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($pagedata as $k=>$v):?>
									<tr>
										<td><?php echo $k+1?></td>
										<td><?php echo \Yii::t('app',$v['class_name'])?></td>
										<td><?php echo \Yii::t('app',$v['price'])?></td>
										<td><?php echo \Yii::t('app',$v['status']==1?'Avaliable':'Unavaliable')?></td>
										<td>
											<a href="<?php echo Url::toRoute(['cabincategorize_option','class_id'=>$v['class_id']]);?>"><img src="<?=$baseUrl ?>images/write.png" class="btn1"></a>
											<a class="delete" id="<?php echo $v['class_id'];?>"><img src="<?=$baseUrl ?>images/delete.png" class="btn2"></a>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							 <p class="records"><?php echo yii::t('app', 'Records:')?><span><?php echo $maxcount;?></span></p>
						</div>
						
					        <input type='hidden' name='page' value="<?php echo $page;?>">
					        <input type='hidden' name='isPage' value="1">
					        <div class="center" id="cabinpage"> </div>
					        </form>
					</div>
					<div  <?php echo  $t==1?"class='active'":''?>>
					<div class="search">
							<label>
								<span><?php echo \Yii::t('app','Cabin Type:')?></span>
								<input type="text" name="class_name" id="typeclass_name">
							</label>
							<span class="btn">
								<input type="button" value="<?php echo \Yii::t('app','Select')?>" onclick="cabintypeselect();"></input>
							</span>
						</div>
						<div>
						<form method="post" action="<?php echo Url::toRoute(['settypeclass'])?>">
							<table id="type_config_table">
								<thead>
									<tr>
										<th><input type="checkbox"></input></th>
										<th><?php echo \Yii::t('app','Type Name')?></th>
										<th><?php echo \Yii::t('app','Num People')?></th>
										<th><?php echo \Yii::t('app','Classify')?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($typedata as $k=>$v):?>
									<tr>
										<td><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $v['id']?>"></input></td>
										<td><?php echo \Yii::t('app',$v['type_name'])?></td>
										<td><?php echo \Yii::t('app',$v['live_number'])?></td>
										<td><?php echo \Yii::t('app',$v['class_name'])?></td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							<p class="records"><?php echo \Yii::t('app','Records:')?><span><?php echo sizeof($typedata)?></span></p>
							
							<div class="search">
							<label>
								<span><?php echo \Yii::t('app','Classify:')?></span>
								<select  name="class_id" id="classify_class_id">
								<?php foreach ($classinfo as $k=>$v):?>
								<option value="<?php echo $v['class_id']?>"><?php echo $v['class_name']?></option>
								<?php endforeach;?>
								</select>
							</label>
							<span class="btn">
								<input type="submit" id="setup" value="<?php echo \Yii::t('app','Set Up')?>"></input>
							</span>
						</div>
						</form>
						</div>
					</div>
				</div>
			</div>
</div>
<!-- content end -->
<input id="t" type="hidden" value="<?php echo isset($_GET['t'])?$_GET['t']:''?>"><!--清除地址栏t参数  -->
<script type="text/javascript">
$(function(){
   var t=$("input#t").val();
   if(t!=''){/*清除地址栏t参数  */
$("#bigclass").click(function(){
	location.href="<?php echo Url::toRoute(['cabin_categorize']);?>";
});
	   }
	$("input#cabininsert").click(function(){
		 location.href="<?php echo Url::toRoute(['cabincategorize_option']);?>";

		});
});
function cabintypeselect() {//ajax提交查询数据
	
    var typeclass_name = $('#typeclass_name').val(); 
    $.ajax({  
        url: '<?php echo Url::toRoute(['typeclass'])?>',  
        type: 'POST', 
        async:false, 
        data:{name:typeclass_name},
        dataType: 'json',  
        timeout: 3000,  
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
        	str += "<td><input type='checkbox' name=checkbox[]  class='checkbox' value='"+data[key]['id']+"'></input></td>";
            str += "<td>"+data[key]['type_name']+"</td>";
            str += "<td>"+data[key]['live_number']+"</td>";  
            str += "<td>"+data[key]['class_name']+"</td>";     
            str += "</tr>";
          });
        $("table#type_config_table > tbody").html(str);
    }  
};
// function cabinclassset() {//ajax提交设置数据
// 	var classify_class=$("#classify_class_id").val();
// 	var cval='';
//     $("input[name=checkbox]:checked").each(function(){
//        cval+=$(this).val()+"/";
//         });
//   alert(cval);
//     $.ajax({  
//        url: 
//         type: 'POST',  
//         data:{type:classify_class,classval:cval},
//         dataType: 'json',  
//         timeout: 3000,  
//         cache: false,  
//         beforeSend: LoadFunction, //加载执行方法      
//         error: erryFunction,  //错误执行方法      
//         success: succFunction //成功执行方法      
//     })  
//     function LoadFunction() {  
//         $("#list").html('加载中...');  
//     }  
//     function erryFunction() {  
//         alert("error");  
//     }  
//     function succFunction(data) {  
//         //$("#gradevalue").html('');  
//          var json = eval(data); //数组
//      	var str='';
//         $.each(data,function(key){
//         	str += "<tr>";
//         	str += "<td><input type='checkbox'></input></td>";
//             str += "<td>"+data[key]['type_name']+"</td>";
//             str += "<td>"+data[key]['live_number']+"</td>";  
//             str += "<td>"+data[key]['class_name']+"</td>";     
//             str += "</tr>";
//           });
//         $("table#type_config_table > tbody").html(str); 
//     }  
// };
window.onload = function(){ 

		<?php $type_config_total = (int)ceil(sizeof($typedata)/7);
		if ($type_config_total==0){
			$type_config_total=1;
		}
		?>
			$('#type_config_page_div').jqPaginator({
			    totalPages: <?php echo $type_config_total;?>,
			    visiblePages: 5,
			    currentPage: 1,
			    first: '<a href="javascript:void(0);"><?php echo yii::t('app', 'First')?></a>',
			    prev: '<a href="javascript:void(0);">«</a>',
			    next: '<a href="javascript:void(0);">»</a>',
			    last: '<a href="javascript:void(0);"><?php echo yii::t('app', 'Last')?></a>',
			    page: '<a href="javascript:void(0);">{{page}}</a>',
			    onPageChange: function (num, type) {
			    	var this_page = $("input#type_config_page").val();
			    	var typeclass_name=$("input[name=typeclass_name]").val();
			    	if(this_page==num){$("input#type_config_page").val('fail');return false;}
			    	
			    	$.ajax({
		                url:"<?php echo Url::toRoute(['get_cabinclass_page']);?>",
		                type:'get',
		                data:{num:num,typeclass_name:typeclass_name},
		             	dataType:'json',
		            	success:function(data){
		                	var str = '';
		            		if(data != 0){
		    	                $.each(data,function(key){
		                        	str += "<tr>";
		                            str += "<td><input name='ids[]' class='checkall' type='checkbox' value='"+data[key]['id']+"'></input></td>";
		                            str += "<td>"+(key+1)+"</td>";
		                            str += "<td>"+data[key]['travel_agent_level']+'  Grade'+"</td>";
		                            var higher_level = data[key]['travel_agent_higher_level']==''?'no':data[key]['travel_agent_higher_level']+' Grade';
		                            str += "<td>"+higher_level+"</td>";
		                            if(data[key]['status']==1)
		                            	var status = "Usable";
		                            else if(data[key]['status']==0)
		                            	var status = "Disabled";
		                            str += "<td>"+status+"</td>";
		                            str += "<td  class='op_btn'>";
		                            str += "<a href=type_config_edit?id="+data[key]['id']+"><img src='<?=$baseUrl ?>images/write.png'></a>";
		                            str += "<a style='margin-left:3px' class='delete' id='"+data[key]['id']+"'><img src='<?=$baseUrl ?>images/delete.png'></a>";
			                        str += "</td>";
		                            str += "</tr>";
		                          });
		    	                $("table#type_config_table > tbody").html(str);
		    	            }
		            	}      
		            });
		    	
		       	// $('#text').html('当前第' + num + '页');
		    	}
		
	/* 获取参数 */
	//分页
	var page = <?php echo $page;?>;
	$('#cabinpage').jqPaginator({
	    totalPages: <?php echo $count;?>,
	    visiblePages: 5,
	    currentPage: page,
	    wrapper:'<ul class="pagination" style="display: inline-flex;"></ul>',
	    first: '<li class="first"><a href="javascript:void(0);"><?php echo \Yii::t('app','First')?></a></li>',
	    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
	    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
	    last: '<li class="last"><a href="javascript:void(0);"><?php echo \Yii::t('app','Last')?></a></li>',
	    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
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
};  
	//delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but",function(){
	   var val = $(this).attr('id');
	   location.href="<?php echo Url::toRoute(['cabin_categorize']);?>"+"&code="+val;
   });

 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form:first").submit();
   });
</script>
