<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_port".
 *
 * @property string $id
 * @property string $port_code
 * @property string $port_short_code
 * @property string $country_code
 * @property integer $status
 */
class VCPort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_port';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['port_code', 'country_code'], 'string', 'max' => 255],
            [['port_short_code'], 'string', 'max' => 2]
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
            'port_short_code' => 'Port Short Code',
            'country_code' => 'Country Code',
            'status' => 'Status',
        ];
    }
}
