<style type="text/css">
	
a{
	text-decoration: none;
}

</style>



<?php
$this->title = 'Membership';
use app\modules\membermanagement\themes\basic\myasset\ThemeAsset;
ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
use yii\helpers\Url;

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);
?>
 <script type="text/javascript" src="<?php echo $baseUrl;?>js/jqPaginator.js"></script>
 <!-- content start -->
<div class="r content" id="user_content">
<div class="topNav"><?= \Yii::t('app', 'Membership Manage') ?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?= \Yii::t('app', 'Membership') ?></a></div>
<form id="member_list" method="post">
<div id="country"   style="display: none;"><?php echo $Searchdata ['country_code']?></div>
      <div class="search">
        <label>
          <span><?= \Yii::t('app', 'Member Code') ?>:</span>
          <input type="text" name="m_code" value="<?php echo $Searchdata ['m_code']?>">
        </label>
        <label>
            <span><?= \Yii::t('app', 'Country') ?>:</span>
              <select name="country_code" id="country_code">
              <option value=''><?= \Yii::t('app', 'All') ?></option>
                <?php  
                foreach ($country as $row) {
              ?>

              <!-- 国家编号 -->

              <!-- 国家名字 -->
                <option value="<?php echo $row['country_code']; ?>"><?php echo $row['country_name']; ?></option>
              <?php
                   }
                   ?>
              </select>
        </label>
        <label>
          <span><?= \Yii::t('app', 'Name') ?>:</span>
          <input type="text" name="m_name" value="<?php echo $Searchdata ['m_name']?>">
        </label>
        <span class="btn"><input value="<?= \Yii::t('app', 'SEARCH') ?>" style="cursor:pointer;" type="submit"></span>
      </div>
   <div class="table-responsive">
        <table id="sample-table-2" >
            <thead>
                <tr>
                    <th> <input class="ace" id="checkALL" type="checkbox">
                    </th>
                    <th><?= \Yii::t('app', 'NO') ?></th>
                    <th><?= \Yii::t('app', 'Member Code') ?></th>
                    <th><?= \Yii::t('app', 'Name') ?></th>
                    <th><?= \Yii::t('app', 'Gender') ?></th>
                    <th><?= \Yii::t('app', 'Country Name') ?></th>
                    <th><?= \Yii::t('app', 'Passport Number') ?></th>
                    <th><?= \Yii::t('app', 'point') ?></th>
                    <th><?= \Yii::t('app', 'operation') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i=0;
            foreach ($member as $key => $value) {
            	$i++;
            ?>
				<tr>
                    <td> <input class="checkbox_button" name="ids[]" value="<?php echo $value['m_id']?>" type="checkbox"> 
                    </td>
                    <td><?php echo $i?></td>
                    <td><?php echo $value['m_code']?></td>
                    <td><?php echo $value['m_name']?></td>
                    <td><?php echo $value['gender']?></td>
                    <td><?php echo $value['country_name']?></td>
                    <td><?php echo $value['passport_number']?></td>
                    <td><?php echo $value['points']?></td>
                    <td>
                    <div>
                     <a href="<?= Url::to(['member/member_read']);?>&id=<?php echo $value['m_id']?>"title="edit"> <img src="<?php echo  $baseUrl; ?>images/text.png"></a>
                    <a href="<?= Url::to(['member/member_edit']);?>&id=<?php echo $value['m_id']?>"title="edit"> <img src="<?php echo  $baseUrl; ?>images/write.png"></a>
                    <a class="delete" id="<?php echo $value['m_id']?>"  style="text-align: center;cursor:pointer;"> <img src="<?php echo  $baseUrl; ?>images/delete.png"></a>
                     </div>
                    </td>
                </tr>
                <?php 
				}
				?>
			</tbody>
       		</table>
       		 <p class="records"><?php echo yii::t('app', 'Records')?>:<span><?php echo $maxcount;?></span></p>
       		  <div class="btn">
            <input type="button" value="<?= \Yii::t('app', 'Add') ?>" id="member_add"></input>
            <input type="button" value="<?= \Yii::t('app', 'Del Selected') ?>"  id="del_submit" ></input>
       		 </div>
             <div class="pageNum" style="margin-left:43%">
 			<input type='hidden' name='page' value="<?php echo $page?>">
              <input type='hidden' name='isPage' value="1">
              <div class="center" id="page_div"></div> 
            </div>
</div>
<input type="hidden" name="seleteselect" id="seleteselect"><!--识别是否按批量删除提交  -->
</form>
	</div>
	
<!-- content end -->


<script type="text/javascript">
jQuery(function($) {
	/* 获取参数 */
	//分页
	var page = <?php echo $page;?>;
	$('#page_div').jqPaginator({
	            totalPages: <?php echo $count;?>,
	            visiblePages: 5,
	            currentPage: page,
	         
	            first:  '<a href="javascript:void(0);"><?= \Yii::t('app', 'First') ?></a>',
	            prev:   '<a href="javascript:void(0);">«</a>',
	            next:   '<a href="javascript:void(0);">»</a>',
	            last:   '<a href="javascript:void(0);"><?= \Yii::t('app', 'Last') ?></a>',
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
window.onload=function () {



           $("#country_code option").each(function()
           {

              if ($.trim($(this).val())==$.trim($('#country').text())) {
                 $(this).prop('selected', 'selected');

              }
          });

       	//delete删除确定but
           $(document).on('click',"#promptBox > .btn .confirm_but",function(){
        	   var a = $(this).attr('id');
        	   location.href="<?= Url::to(['member/index']);?>"+'&id='+a;
           });

         //delete删除确定but
           $(document).on('click',"#promptBox > .btn .confirm_but_more",function(){
        	   $("#seleteselect").val("1");
        	   $("form:first").submit();
           });
           $(document).on('click',"#promptBox > .btn .cancel_but",function(){
        	   $("#seleteselect").val("");
        	   $(".ui-widget-overlay").removeClass("ui-widget-overlay");//移除遮罩效果
        	   $("#promptBox").hide();
        	 
        	   
        	 
           });


	/* $('.delete').click(function(event) {

		var $a = $.trim($(this).attr("id"));
		            
        	       if(confirm("Sure to delete? Record cannot be recovered after deletion"))

        	      {




        	      	var url=
        	      	
                   location.href=url;

                 
  
                  return false;



        	      	

         		    
         		  }
         		  else{

      		   
         		  }


	}); */
	
	$('#checkALL').click(function(event) {


		if ($(this).prop('checked')==true) 
		{

			$('.checkbox_button').prop('checked', true);
		}
		else {
			$('.checkbox_button').prop('checked', false);
			
		}
		
	});



	//批量删除

/* 	 $( "#Batch_delete" ).on('click', function(e) {
        var ischeckbox=false;
        $(".checkbox_button").each(function(){
          if($(this).prop('checked')==true)
          {
              ischeckbox=true;
          }
        });

        if(ischeckbox==false)
        {
            alert("Please select Delete item");
        	
        }


        if(ischeckbox==true)
        {

        	 if(confirm("Sure to delete? Record cannot be recovered after deletion"))

        	      {

        	      	var url=" Url::to(['member/index']);?>";
        	      	$('form').attr('action', url);
        	      	$('form').submit();


         		    
         		  }
         		  else{

      		   
         		  }
        }
    }); */
   $('#member_add').click(function(event) {


	var url="<?= Url::to(['member/add_member']);?>";	
    location.href=url;
    return false;
    
   });
}
	

</script>





	
		

