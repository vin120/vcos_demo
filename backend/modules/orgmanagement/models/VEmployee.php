<?php

namespace app\modules\orgmanagement\models;

use Yii;

/**
 * This is the model class for table "v_employee".
 *
 * @property string $employee_id
 * @property string $employee_code
 * @property string $employee_card_number
 * @property integer $employee_status
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string $country_code
 * @property string $nation_code
 * @property integer $political_status
 * @property string $gender
 * @property string $date_of_birth
 * @property string $birth_place
 * @property integer $card_type
 * @property string $resident_id_card
 * @property string $passport_number
 * @property string $other_card_number
 * @property integer $marry_status
 * @property integer $health_status
 * @property string $height
 * @property string $weight
 * @property string $shoe_size
 * @property integer $blood_type
 * @property string $working_life
 * @property string $major
 * @property integer $education
 * @property string $foreign_language
 * @property string $mailing_address
 * @property string $dormitory_num
 * @property string $telephone_num
 * @property string $mobile_num
 * @property string $emergency_contact
 * @property string $emergency_contact_phone
 */
class VEmployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_status', 'political_status', 'card_type', 'marry_status', 'health_status', 'blood_type', 'education'], 'integer'],
            [['gender'], 'string'],
            [['date_of_birth'], 'safe'],
            [['employee_code', 'employee_card_number', 'resident_id_card', 'other_card_number'], 'string', 'max' => 32],
            [['full_name', 'first_name', 'last_name', 'emergency_contact'], 'string', 'max' => 100],
            [['country_code'], 'string', 'max' => 16],
            [['nation_code'], 'string', 'max' => 2],
            [['birth_place', 'mailing_address'], 'string', 'max' => 250],
            [['passport_number', 'telephone_num', 'mobile_num', 'emergency_contact_phone'], 'string', 'max' => 20],
            [['height', 'weight', 'shoe_size', 'working_life'], 'string', 'max' => 5],
            [['major', 'foreign_language', 'dormitory_num'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Employee ID',
            'employee_code' => 'Employee Code',
            'employee_card_number' => 'Employee Card Number',
            'employee_status' => 'Employee Status',
            'full_name' => 'Full Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'country_code' => 'Country Code',
            'nation_code' => 'Nation Code',
            'political_status' => 'Political Status',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'birth_place' => 'Birth Place',
            'card_type' => 'Card Type',
            'resident_id_card' => 'Resident Id Card',
            'passport_number' => 'Passport Number',
            'other_card_number' => 'Other Card Number',
            'marry_status' => 'Marry Status',
            'health_status' => 'Health Status',
            'height' => 'Height',
            'weight' => 'Weight',
            'shoe_size' => 'Shoe Size',
            'blood_type' => 'Blood Type',
            'working_life' => 'Working Life',
            'major' => 'Major',
            'education' => 'Education',
            'foreign_language' => 'Foreign Language',
            'mailing_address' => 'Mailing Address',
            'dormitory_num' => 'Dormitory Num',
            'telephone_num' => 'Telephone Num',
            'mobile_num' => 'Mobile Num',
            'emergency_contact' => 'Emergency Contact',
            'emergency_contact_phone' => 'Emergency Contact Phone',
        ];
    }
}
