<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_cabin_type_i18n".
 *
 * @property string $id
 * @property string $type_code
 * @property string $type_name
 * @property string $floor
 * @property string $i18n
 */
class VCCabinTypeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_cabin_type_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_code', 'type_name', 'floor'], 'string', 'max' => 255],
            [['i18n'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_code' => 'Type Code',
            'type_name' => 'Type Name',
            'floor' => 'Floor',
            'i18n' => 'I18n',
        ];
    }
}
