<?php

namespace app\modules\membermanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_country".
 *
 * @property string $id
 * @property string $country_code
 * @property string $counry_short_code
 * @property integer $status
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['country_code', 'counry_short_code'], 'string', 'max' => 12]
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
            'counry_short_code' => 'Counry Short Code',
            'status' => 'Status',
        ];
    }
}
