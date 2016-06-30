<?php

use yii\widgets\LinkPager;
foreach ($query as $row) {
	// 在这里显示 $model
	
	foreach ($row as $value) {
		echo $value;
	}
	
	
}

// 显示分页
echo LinkPager::widget([
		'pagination' => $pages,
]);


?>

<style type="text/css">
.pagination{
  list-style: none;

}

 .pagination li{
  float: left;
    
  }