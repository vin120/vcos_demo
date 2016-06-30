<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_surcharge_lib_i18n".
 *
 * @property string $id
 * @property integer $cost_id
 * @property string $cost_name
 * @property string $cost_desc
 * @property string $i18n
 */
class VCSurchargeLibI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_surcharge_lib_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cost_id'], 'integer'],
            [['cost_name', 'cost_desc'], 'string', 'max' => 255],
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
            'cost_id' => 'Cost ID',
            'cost_name' => 'Cost Name',
            'cost_desc' => 'Cost Desc',
            'i18n' => 'I18n',
        ];
    }
}
