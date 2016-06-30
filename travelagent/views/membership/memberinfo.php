
<?php 

use yii\helpers\Html;
use yii\helpers\Url;

use travelagent\views\myasset\PublicAsset;
use travelagent\views\myasset\MemberinfoAsset;
PublicAsset::register($this);
MemberinfoAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';
?>
<!-- 常量中英文切换 -->
<input type="hidden" value="<?php echo \Yii::t('app','First')?>" id="pagefirst"/>
<input type="hidden" value="<?php echo \Yii::t('app','Last')?>" id="pagelast"/>
<!-- main content start -->
<div id="memberShip" class="mainContent">
			<div id="topNav">
				<?php echo \Yii::t('app','Agent Ticketing')?>
				<span>>></span>
				<a href="#"><?php echo \Yii::t('app','MemberShip')?></a>
			</div>
			<div id="mainContent_content">
				<!-- 请用ajax提交 -->
			    <input type="hidden" id="datacount" value="<?php echo isset($datacount)?$datacount:''?>">
				<input type="hidden" id="p" value="0">
				<input type="hidden" id="page_url" value="<?php echo Url::toRoute(['getmemberpage']);?>">
				<input type="hidden" value="<?php echo $baseUrl?>" id="baseurl">
				<input type="hidden" value="<?php echo Url::toRoute(['getmemberserch']);?>" id="serchurl">
				<div class="pBox search">
					<p>
						<label>
							<span><?php echo \Yii::t('app','Name')?>:</span>
							<span>
							<input type="text" name="full_name" >
							</span>
						</label>
						<label>
							<span><?php echo \Yii::t('app','PassportNum')?>:</span>
							<input name="passport_num" type="text"></input>
						</label>
						<input type="button" value="<?php echo \Yii::t('app','SEARCH')?>" id="searchmember" class="btn1"></input>
					</p>
				
				</div>
				<div class="pBox">
					<table id="member_page_table">
						<thead>
							<tr>
								<th><?php echo \Yii::t('app','No.')?></th>
								<th><?php echo \Yii::t('app','Name')?></th>
								<th><?php echo \Yii::t('app','Gender')?></th>
								<th><?php echo \Yii::t('app','Birthday')?></th>
								<th><?php echo \Yii::t('app','PassportNum')?></th>
								<th><?php echo \Yii::t('app','DateExpire')?></th>
								<th><?php echo \Yii::t('app','Email')?></th>
								<th><?php echo \Yii::t('app','Phone')?></th>
								<th><?php echo \Yii::t('app','Operation')?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($data as $k=>$v):?>
							<tr>
								<td><?php echo $k+1?></td>
								<td><?php echo $v['full_name']?></td>
								<td><?php echo $v['gender']?></td>
								<td><?php echo $v['birthday']?></td>
								<td><?php echo $v['passport_num']?></td>
								<td><?php echo $v['date_expire']?></td>
								<td><?php echo $v['email']?></td>
								<td><?php echo $v['phone']?></td>
								<td>
								<button class="btn1"><img src="<?=$baseUrl ?>images/write.png"></button><button class="btn2"><img src="<?=$baseUrl ?>images/delete.png"></button>
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<div class="center" id="member_page_div"></div>
				</div>
			</div>
		</div>
<!-- main content end -->
		