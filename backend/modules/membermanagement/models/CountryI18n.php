<?php

namespace app\modules\membermanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_country_i18n".
 *
 * @property string $id
 * @property string $country_code
 * @property string $country_name
 * @property string $i18n
 */
class CountryI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_country_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code', 'i18n'], 'string', 'max' => 12],
            [['country_name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
            'i18n' => 'I18n',
        ];
    }
}
