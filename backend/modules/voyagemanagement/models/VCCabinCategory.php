<?php

namespace app\modules\voyagemanagement\models;
use Yii;

/**
 * This is the model class for table "v_c_cabin_category".
 *
 * @property string $id
 * @property integer $cabin_type_id
 * @property integer $class_id
 */
class VCCabinCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_cabin_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cabin_type_id', 'class_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cabin_type_id' => 'Cabin Type ID',
            'class_id' => 'Class ID',
        ];
    }
}
