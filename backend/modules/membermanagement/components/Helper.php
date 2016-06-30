<?php
namespace app\modules\membermanagement\components;
use Yii;
use yii\helpers\Url;
class Helper
{
	public static function GetCreateTime($create_time){
		$day=substr($create_time, 0,2);
		$month=substr($create_time, 3,2);
		$year=substr($create_time, 6,4);
		$time=substr($create_time,10,9);
		$data=$year.'-'.$month.'-'.$day.' '.$time;
		return $data;
	}
	public static function show_message($info, $url=''){//跳转
		header('Content-Type:text/html;charset=utf-8');
		?>
		<style>
	.pop-ups { position: fixed; top: 50%; left: 50%; background-color: #fff; border: 1px solid #e0e9f4; box-shadow: 1px 1px 1px #cbcbcb; box-sizing: border-box; overflow: hidden; }
	.pop-ups h3 { padding: 16px; margin: 0; background: #3f7fcf; text-align: center; color: #fff; }
	.pop-ups h3 a { display: inline-block; width: 28px; height: 28px; margin-top: -4px; background: url(img/lg_close.png) no-repeat; }
	#promptBox {
    position: absolute;
    top: 30%;
    left: 50%;
    width: 200px;
    font: 14px Arial;
    }
    .pop-ups {
    position: fixed;
    border: 1px solid #e0e9f4;
    box-shadow: 1px 1px 1px #cbcbcb;
    box-sizing: border-box;
    overflow: hidden;
	}
	div {
    display: block;
	}
	.shadow { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; opacity: 0.5; }
	#promptBox { position: absolute; top: 30%; left: 50%; width: 200px; }
	#promptBox p { text-align: center; }
	#promptBox .btn input { margin-right: 20px; background-color: #ffb752; border: none; color: #fff; }
		</style>
		<div class='ui-widget-overlay ui-front'></div>
		<div class="shadow"></div>
		<div id="promptBox" class="pop-ups write ui-dialog">
		<h3>Prompt</h3>
		<span class="op"><a class="close r"></a></span>
		<p><?php echo $info?></p>
		<p class="btn">
		<input type="button" style="margin-right:0;padding: 4px 10px;" onclick="showmessage();" class="cancel_but" value="OK"></input>
		</p></div>
	<script type="text/javascript">
		function showmessage(){
			
			document.getElementById("promptBox").style.display = "none";
				<?php
				if($url && $url !='#'){
				echo "location='{$url}'";
				}else{
					echo "history.back();";
				}
				?>
			
			}
			</script>
		
		
		<?php 		
	
	}
	
}
