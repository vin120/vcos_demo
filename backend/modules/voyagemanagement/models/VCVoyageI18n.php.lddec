<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage_i18n".
 *
 * @property string $id
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
            'id' => 'ID',
            'voyage_code' => 'Voyage Code',
            'voyage_name' => 'Voyage Name',
            'voyage_desc' => 'Voyage Desc',
            'i18n' => 'I18n',
        ];
    }
}
