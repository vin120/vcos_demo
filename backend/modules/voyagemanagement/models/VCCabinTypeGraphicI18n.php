<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_cabin_type_graphic_i18n".
 *
 * @property string $id
 * @property integer $graphic_id
 * @property string $graphic_desc
 * @property string $graphic_img
 * @property string $i18n
 */
class VCCabinTypeGraphicI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_cabin_type_graphic_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['graphic_id'], 'integer'],
            [['graphic_desc', 'graphic_img'], 'string', 'max' => 255],
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
            'graphic_id' => 'Graphic ID',
            'graphic_desc' => 'Graphic Desc',
            'graphic_img' => 'Graphic Img',
            'i18n' => 'I18n',
        ];
    }
}
