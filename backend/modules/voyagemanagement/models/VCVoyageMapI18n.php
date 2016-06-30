<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage_map_i18n".
 *
 * @property integer $id
 * @property integer $map_id
 * @property string $map_img
 * @property string $i18n
 */
class VCVoyageMapI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage_map_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id'], 'integer'],
            [['map_img'], 'string', 'max' => 255],
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
            'map_id' => Yii::t('app', 'Map ID'),
            'map_img' => Yii::t('app', 'Map Img'),
            'i18n' => Yii::t('app', 'I18n'),
        ];
    }
}
