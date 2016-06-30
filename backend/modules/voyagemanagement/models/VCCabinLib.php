<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_cabin_lib".
 *
 * @property integer $id
 * @property string $cruise_code
 * @property integer $cabin_type_id
 * @property string $cabin_name
 * @property integer $deck_num
 * @property integer $max_check_in
 * @property integer $ieast_aduits_num
 * @property integer $status
 */
class VCCabinLib extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_cabin_lib';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cabin_type_id', 'deck_num', 'max_check_in', 'ieast_aduits_num', 'status'], 'integer'],
            [['cruise_code', 'cabin_name'], 'string', 'max' => 255]
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
            'cabin_type_id' => Yii::t('app', 'Cabin Type ID'),
            'cabin_name' => Yii::t('app', 'Cabin Name'),
            'deck_num' => Yii::t('app', 'Deck Num'),
            'max_check_in' => Yii::t('app', 'Max Check In'),
            'ieast_aduits_num' => Yii::t('app', 'Ieast Aduits Num'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
