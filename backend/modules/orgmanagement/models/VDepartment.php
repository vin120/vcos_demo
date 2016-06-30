<?php

namespace app\modules\orgmanagement\models;

use Yii;

/**
 * This is the model class for table "v_department".
 *
 * @property string $department_id
 * @property string $department_name
 * @property integer $parent_department_id
 * @property string $remark
 */
class VDepartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_department_id'], 'integer'],
            [['department_name'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => 'Department ID',
            'department_name' => 'Department Name',
            'parent_department_id' => 'Parent Department ID',
            'remark' => 'Remark',
        ];
    }
}
