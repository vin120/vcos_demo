<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_shore_excursion_i18n".
 *
 * @property string $id
 * @property string $se_code
 * @property string $se_name
 * @property string $se_info
 * @property string $i18n
 */
class VCShoreExcursionI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_shore_excursion_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['se_info'], 'string'],
            [['se_code', 'se_name'], 'string', 'max' => 255],
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
            'se_code' => 'Se Code',
            'se_name' => 'Se Name',
            'se_info' => 'Se Info',
            'i18n' => 'I18n',
        ];
    }
}
