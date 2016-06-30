<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_active_i18n".
 *
 * @property integer $id
 * @property integer $active_id
 * @property string $name
 * @property string $i18n
 */
class VCActiveI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_active_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'active_id' => Yii::t('app', 'Active ID'),
            'name' => Yii::t('app', 'Name'),
            'i18n' => Yii::t('app', 'I18n'),
        ];
    }
    
    public function getActive()
    {
    	return $this->hasOne(VCActive::className(),['active_id'=>'active_id']);
    }
}
