<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_port_i18n".
 *
 * @property integer $id
 * @property string $port_code
 * @property string $port_name
 * @property string $i18n
 */
class VCPortI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_port_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['port_code', 'i18n'], 'string', 'max' => 12],
            [['port_name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'port_code' => 'Port Code',
            'port_name' => 'Port Name',
            'i18n' => 'I18n',
        ];
    }
}
