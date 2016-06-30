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
    <div class="topNav"><?php echo \Yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo \Yii::t('app','Surcharge Config')?></a></div>
   
    <div class="search">
 
    </div>
   
    <div class="searchResult">
    <?php
		$form = ActiveForm::begin([
			'method'=>'post',
			'enableClientValidation'=>false,
			'enableClientScript'=>false
		]); 
	?>
        <table>
      
            <thead>
            <tr>
                <th><?php echo \Yii::t('app','No.')?>No.</th>
                <th><?php echo \Yii::t('app','Surcharge Name')?></th>
                <th><?php echo \Yii::t('app','TSurcharge Price')?></th>
                <th><?php echo \Yii::t('app','Operate')?></th>
            </tr>
            </thead>
            <tbody>
          <?php foreach ($pagedata as $k=>$v):?>
            <tr>
                <td><?php echo $k+1?></td>
                <td><?php echo \Yii::t('app',$v['cost_name'])?></td>
                <td><?php echo \Yii::t('app',$v['cost_price'])?></td>
                <td class="op_btn">
                    <a href="<?php echo Url::toRoute(['surchargeoption','id'=>$v['id']]);?>"><img src="<?=$baseUrl ?>images/write.png"></a>
                    <a class="delete" style="cursor:pointer" id="<?php echo $v['id'];?>"><img src="<?=$baseUrl ?>images/delete.png"></a>
                </td>
            </tr>
         <?php endforeach;?>
            </tbody>
        </table>
       <?php 
		ActiveForm::end(); 
		?>
        <p class="records"><?php echo \Yii::t('app','Records:')?><span><?php echo $maxcount;?></span></p>
        <div class="btn">
            <input type="button" id="add" value="<?php echo \Yii::t('app','Add')?>"></input>
          
        </div>
<!--         <div class="pageNum"> -->
<!-- 					<span> -->
<!-- 						<a href="#" class="active">1</a> -->
<!-- 						<a href="#">2</a> -->
<!-- 						<a href="#">》</a> -->
<!-- 						<a href="#">Last</a> -->
<!-- 					</span> -->
<!--         </div> -->

        <!-- 分页 -->
        <form method="post" id="member_list">
        <input type='hidden' name='page' value="<?php echo $page;?>">
        <input type='hidden' name='isPage' value="1">
        <div class="center" id="surcharge_page"> </div>
        </form>
    </div>
</div>
<!-- content end -->



<script type="text/javascript">
$(function(){
    $("input#add").click(function(){
    	window.location="<?php echo Url::toRoute(['surchargeoption']);?>";
    });
});
window.onload = function(){ 
	/* 获取参数 */
	//分页
	var page = <?php echo $page;?>;
	$('#surcharge_page').jqPaginator({
	    totalPages: <?php echo $count;?>,
	    visiblePages: 5,
	    currentPage: page,
	    wrapper:'<ul class="pagination"></ul>',
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
	   location.href="<?php echo Url::toRoute(['surchargeconfig']);?>"+"&code="+val;
   });

 //delete删除确定but
   $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
	   $("form:first").submit();
   });
</script>