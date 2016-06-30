<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_shore_excursion_lib".
 *
 * @property string $id
 * @property string $se_code
 * @property integer $status
 */
class VCShoreExcursionLib extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_shore_excursion_lib';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['se_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'se_code' => 'Se Code',
            'status' => 'Status',
        ];
    }
}
