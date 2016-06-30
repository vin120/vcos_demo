
<?php 

use yii\helpers\Html;
use yii\helpers\Url;

use travelagent\views\myasset\PublicAsset;
use travelagent\views\myasset\RemaininginfoAsset;
PublicAsset::register($this);
RemaininginfoAsset::register($this);
?>
<!-- 常量中英文切换 -->
<input type="hidden" value="<?php echo \Yii::t('app','First')?>" id="pagefirst"/>
<input type="hidden" value="<?php echo \Yii::t('app','Last')?>" id="pagelast"/>
<!-- main content start -->
<div id="remainingCabin" class="mainContent">
			<div id="topNav">
				<?php echo \Yii::t('app','Agent Ticketing')?>
				<span>>></span>
				<a href="#"><?php echo \Yii::t('app','Remaining Cabin')?></a>
			</div>
			<div id="mainContent_content">
				<!-- 请用ajax提交 -->
				<div class="pBox search">
					<label>
						<span><?php echo \Yii::t('app','Route')?>:</span>
						<span>
							<select class="doubleWidth" name="voyage_id">
							<option value=""><?php echo \Yii::t('app','NO')?></option>
							<?php foreach ($voyageinfo as $k=>$v):?>
								<option value="<?php echo $v['id']?>"> <?php echo $v['voyage_name']?></option>
								<?php endforeach;?>
							</select>
						</span>
					</label>
					<label>
						<span><?php echo \Yii::t('app','Cabin Type')?>:</span>
						<span>
							<select class="doubleWidth" name="type_code">
							<option value=""><?php echo \Yii::t('app','NO')?></option>
							</select>
						</span>
					</label>
					<input type="hidden" value="<?php echo Url::toRoute(['getremaininginfo']);?>" id="url"/>
					<input type="button" value="<?php echo \Yii::t('app','SEARCH')?>" id="search" class="btn1"></input>
				</div>
				<div class="pBox">
					<table id="remaining_page_table">
						<thead>
							<tr>
								<th><?php echo \Yii::t('app','Cabin Type')?></th>
								<th><?php echo \Yii::t('app','Deck')?></th>
								<th><?php echo \Yii::t('app','Quantity')?></th>
							</tr>
						</thead>
						<tbody>
							
							<!-- <tr>
								<td><p echo \Yii::t('app','Presidential Suite')?></td>
								<td><hp echo \Yii::t('app','10')?></td>
								<td><p echo \Yii::t('app','Enough')?></td>
							</tr> -->
						</tbody>
					</table>
						<p class="records"><?php echo yii::t('app','Records')?>:<span id="count">0</span></p>
					<input type="hidden" id="pageurl" value="<?php echo Url::toRoute(['getremaininginfo']);?>">
					<div  class="center" id="remaining_page_div"></div>
				</div>
			</div>
		</div>
<!-- main content end -->
		<input type="hidden" id="counturl" value="<?php echo Url::toRoute(['getremainingcount']);?>">
		<input type="hidden" id="voyageurl" value="<?php echo Url::toRoute(['getcabintype']);?>">
