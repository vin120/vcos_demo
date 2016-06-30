<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_cruise".
 *
 * @property integer $id
 * @property string $cruise_code
 * @property integer $deck_number
 * @property integer $status
 */
class VCruise extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_cruise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deck_number', 'status'], 'integer'],
            [['cruise_code'], 'string', 'max' => 255]
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
            'deck_number' => Yii::t('app', 'Deck Number'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
