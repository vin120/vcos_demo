<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage_active".
 *
 * @property integer $id
 * @property integer $voyage_id
 * @property integer $curr_active_id
 * @property integer $statue
 */
class VCVoyageActive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voyage_id', 'curr_active_id', 'statue'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'voyage_id' => Yii::t('app', 'Voyage ID'),
            'curr_active_id' => Yii::t('app', 'Curr Active ID'),
            'statue' => Yii::t('app', 'Statue'),
        ];
    }
}
