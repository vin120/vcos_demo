<?php

namespace app\modules\orgmanagement\models;

use Yii;

/**
 * This is the model class for table "v_employment_profiles".
 *
 * @property string $id
 * @property string $employee_code
 * @property integer $ship_id
 * @property integer $department_id
 * @property integer $post_id
 * @property integer $employee_type
 * @property integer $employee_source
 * @property integer $employee_status
 * @property string $bank_name
 * @property string $bank_card_number
 * @property string $date_of_entry
 * @property string $date_of_positive
 * @property string $date_of_departure
 */
class VEmploymentProfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_employment_profiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ship_id', 'department_id', 'post_id', 'employee_type', 'employee_source', 'employee_status'], 'integer'],
            [['date_of_entry', 'date_of_positive', 'date_of_departure'], 'safe'],
            [['employee_code'], 'string', 'max' => 32],
            [['bank_name'], 'string', 'max' => 50],
            [['bank_card_number'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_code' => 'Employee Code',
            'ship_id' => 'Ship ID',
            'department_id' => 'Department ID',
            'post_id' => 'Post ID',
            'employee_type' => 'Employee Type',
            'employee_source' => 'Employee Source',
            'employee_status' => 'Employee Status',
            'bank_name' => 'Bank Name',
            'bank_card_number' => 'Bank Card Number',
            'date_of_entry' => 'Date Of Entry',
            'date_of_positive' => 'Date Of Positive',
            'date_of_departure' => 'Date Of Departure',
        ];
    }
}
