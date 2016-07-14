<?php
$this->title = 'Report Management';

use app\modules\reportmanagement\themes\basic\myasset\ThemeAsset;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

echo 1234;