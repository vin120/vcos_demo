<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_cabin_type".
 *
 * @property integer $id
 * @property string $type_code
 * @property integer $live_number
 * @property string $room_area
 * @property integer $beds
 * @property integer $location
 * @property integer $type_status
 * @property string $cruise_code
 */
class VCCabinType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_cabin_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['live_number', 'beds', 'location', 'type_status'], 'integer'],
            [['type_code', 'room_area', 'cruise_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_code' => Yii::t('app', 'Type Code'),
            'live_number' => Yii::t('app', 'Live Number'),
            'room_area' => Yii::t('app', 'Room Area'),
            'beds' => Yii::t('app', 'Beds'),
            'location' => Yii::t('app', 'Location'),
            'type_status' => Yii::t('app', 'Type Status'),
            'cruise_code' => Yii::t('app', 'Cruise Code'),
        ];
    }
}
