<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_cabin".
 *
 * @property integer $id
 * @property integer $voyage_id
 * @property integer $cabin_type_id
 * @property integer $deck
 * @property integer $cabin_lib_id
 * @property integer $status
 */
class VCCabin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_cabin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voyage_id', 'cabin_type_id', 'deck', 'cabin_lib_id', 'status'], 'integer']
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
            'cabin_type_id' => Yii::t('app', 'Cabin Type ID'),
            'deck' => Yii::t('app', 'Deck'),
            'cabin_lib_id' => Yii::t('app', 'Cabin Lib ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
