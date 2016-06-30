<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_active_detail_i18n".
 *
 * @property integer $id
 * @property integer $active_detail_id
 * @property string $detail_title
 * @property string $detail_desc
 * @property string $i18n
 */
class VCActiveDetailI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_active_detail_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active_detail_id'], 'integer'],
            [['detail_title', 'detail_desc'], 'string', 'max' => 255],
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
            'active_detail_id' => Yii::t('app', 'Active Detail ID'),
            'detail_title' => Yii::t('app', 'Detail Title'),
            'detail_desc' => Yii::t('app', 'Detail Desc'),
            'i18n' => Yii::t('app', 'I18n'),
        ];
    }
}
