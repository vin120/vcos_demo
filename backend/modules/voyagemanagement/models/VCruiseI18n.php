<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_cruise_i18n".
 *
 * @property integer $id
 * @property string $cruise_code
 * @property string $cruise_name
 * @property string $cruise_desc
 * @property string $cruise_img
 * @property string $i18n
 */
class VCruiseI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_cruise_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cruise_code', 'cruise_name', 'cruise_desc', 'cruise_img'], 'string', 'max' => 255],
            [['i18n'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cruise_code' => Yii::t('app', 'Cruise Code'),
            'cruise_name' => Yii::t('app', 'Cruise Name'),
            'cruise_desc' => Yii::t('app', 'Cruise Desc'),
            'cruise_img' => Yii::t('app', 'Cruise Img'),
            'i18n' => Yii::t('app', 'I18n'),
        ];
    }
}
