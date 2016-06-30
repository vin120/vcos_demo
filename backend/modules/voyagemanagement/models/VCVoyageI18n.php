<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage_i18n".
 *
 * @property integer $id
 * @property string $voyage_code
 * @property string $voyage_name
 * @property string $voyage_desc
 * @property string $i18n
 */
class VCVoyageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voyage_code', 'voyage_name', 'voyage_desc'], 'string', 'max' => 255],
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
            'voyage_code' => Yii::t('app', 'Voyage Code'),
            'voyage_name' => Yii::t('app', 'Voyage Name'),
            'voyage_desc' => Yii::t('app', 'Voyage Desc'),
            'i18n' => Yii::t('app', 'I18n'),
        ];
    }
}
