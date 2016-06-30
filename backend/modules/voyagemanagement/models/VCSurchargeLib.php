<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_surcharge_lib".
 *
 * @property string $id
 * @property integer $cost_price
 * @property integer $status
 */
class VCSurchargeLib extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_surcharge_lib';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cost_price', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cost_price' => 'Cost Price',
            'status' => 'Status',
        ];
    }
}
