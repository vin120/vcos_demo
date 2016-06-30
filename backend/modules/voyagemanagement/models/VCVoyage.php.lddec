<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage".
 *
 * @property string $id
 * @property string $cruise_code
 * @property string $voyage_code
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 */
class VCVoyage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time'], 'safe'],
            [['status'], 'integer'],
            [['cruise_code', 'voyage_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cruise_code' => 'Cruise Code',
            'voyage_code' => 'Voyage Code',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'status' => 'Status',
        ];
    }
}
