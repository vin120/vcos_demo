
<style type="text/css">

		#issueTicket_info .form { padding: 1em; border: 1px solid #e0e9f4; background: #fff; }
		#issueTicket_info label span { display: inline-block; width: 100px; text-align: right; }
		#issueTicket_info select { width: 184px; height: 24px; }
		#issueTicket_info .lineSelect select { width: 478px; }
		#issueTicket_info .table { width: 48%; margin-bottom: 1em; }
		#issueTicket_info .btn { margin-top: 1em; }
		#memberInfo label span { width: 140px; }
	</style>

<?php
$this->title = 'Add Membership';


use app\modules\membermanagement\themes\basic\myasset\ThemeAsset;

ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
	
<!-- content start -->
		<div class="r content" id="issueTicket_info">
			<div class="topNav">Route Manage&nbsp;&gt;&gt;&nbsp;<a href="#">Scenic Route</a></div>
			<div id="">
				<h3>Booking person</h3>
				<div class="form">
					<p>
						<label>
							<span>Memeber No.:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>ID No.:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Membership Grade:</span>
							<select>
								<option></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Member ID:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Country</span>
							<select>
								<option>中国</option>
							</select>
						</label>
						<label>
							<span>Membership Status:</span>
							<select>
								<option>未激活</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Chinese Name:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Nation:</span>
							<select>
								<option>汉族</option>
							</select>
						</label>
						<label>
							<span>Balance:</span>
							<input type="text"></input>
						</label>
					</p>
					<p>
						<label>
							<span>First Name:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Landline Telephone:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Integral:</span>
							<input type="text"></input>
						</label>
					</p>
					<p>
						<label>
							<span>Last Name:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Phone No.:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Verify Phone No.:</span>
							<select>
								<option>未验证</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Birthday:</span>
							<input type="date"></input>
						</label>
						<label>
							<span>E-mail:</span>
							<input type="email"></input>
						</label>
						<label>
							<span>Verity E-mail:</span>
							<select>
								<option>未验证</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span>Gender:</span>
							<select>
								<option>男</option>
							</select>
						</label>
						<label>
							<span>Login Name:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Registration IP:</span>
							<input type="text"></input>
						</label>
					</p>
					<p>
						<label>
							<span>Birthplace:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Password:</span>
							<input type="password"></input>
						</label>
						<label>
							<span>Registration Date:</span>
							<input type="date"></input>
						</label>
					</p>
				</div>
				<h3>Passport</h3>
				<div class="form">
					<p>
						<label>
							<span>Passport No:</span>
							<input type="text"></input>
						</label>
						<label>
							<span>Issuing Country:</span>
							<select>
								<option>中国</option>
							</select>
						</label>
						<label>
							<span>Issue Place:</span>
							<input type="text"></input>
						</label>
					</p>
					<p>
						<label>
							<span>Issue Date:</span>
							<input type="date"></input>
						</label>
						<label>
							<span>Closing Date:</span>
							<input type="date"></input>
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="button" value="Add"></input>
					<input type="button" value="Del Selected"></input>
				</div>
			</div>
		</div>
		<!-- content end -->
