<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_return_voyage".
 *
 * @property integer $id
 * @property integer $voyage_id
 * @property integer $return_voyage_id
 * @property integer $statue
 */
class VCReturnVoyage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_return_voyage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voyage_id', 'return_voyage_id', 'statue'], 'integer']
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
            'return_voyage_id' => Yii::t('app', 'Return Voyage ID'),
            'statue' => Yii::t('app', 'Statue'),
        ];
    }
}
