<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_active_detail".
 *
 * @property integer $id
 * @property integer $active_id
 * @property integer $day_from
 * @property integer $day_to
 * @property string $detail_img
 */
class VCActiveDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_active_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active_id', 'day_from', 'day_to'], 'integer'],
            [['detail_img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'active_id' => Yii::t('app', 'Active ID'),
            'day_from' => Yii::t('app', 'Day From'),
            'day_to' => Yii::t('app', 'Day To'),
            'detail_img' => Yii::t('app', 'Detail Img'),
        ];
    }
}
