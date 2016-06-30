<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_active".
 *
 * @property integer $active_id
 * @property integer $status
 */
class VCActive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active_id' => Yii::t('app', 'Active ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
    public function getActivei18n()
    {
    	return $this->hasOne(VCActiveI18n::className(),['active_id'=>'active_id'])->onCondition(['v_c_active_i18n.i18n'=>'en']);
    }
    
    

}
