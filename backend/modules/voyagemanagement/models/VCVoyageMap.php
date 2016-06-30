<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage_map".
 *
 * @property integer $id
 * @property integer $voyage_id
 * @property integer $status
 */
class VCVoyageMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voyage_id', 'status'], 'integer']
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
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
