<?php

namespace app\modules\travelagentmanagement\models;

use Yii;

/**
 * This is the model class for table "v_travel_agent_type".
 *
 * @property string $id
 * @property string $travel_agent_level
 * @property integer $travel_agent_higher_level_id
 * @property integer $status
 */
class VTravelAgentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_travel_agent_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_agent_higher_level_id', 'status'], 'integer'],
            [['travel_agent_level'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'travel_agent_level' => 'Travel Agent Level',
            'travel_agent_higher_level_id' => 'Travel Agent Higher Level ID',
            'status' => 'Status',
        ];
    }
}
