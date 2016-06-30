<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_country".
 *
 * @property string $id
 * @property string $country_code
 * @property string $counry_short_code
 * @property string $area_code
 * @property integer $status
 */
class VCCountry extends \yii\db\ActiveRecord
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
            [['country_code', 'counry_short_code'], 'string', 'max' => 12],
            [['area_code'], 'string', 'max' => 255]
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
            'area_code' => 'Area Code',
            'status' => 'Status',
        ];
    }
}
