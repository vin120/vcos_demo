<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_area_i18n".
 *
 * @property integer $id
 * @property string $area_code
 * @property string $area_name
 * @property string $i18n
 */
class VCAreaI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_area_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_code', 'area_name'], 'string', 'max' => 255],
            [['i18n'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area_code' => Yii::t('app', 'Area Code'),
            'area_name' => Yii::t('app', 'Area Name'),
            'i18n' => Yii::t('app', 'I18n'),
        ];
    }
}
