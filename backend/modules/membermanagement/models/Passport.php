<?php

namespace app\modules\membermanagement\models;

use Yii;

/**
 * This is the model class for table "v_m_passport".
 *
 * @property string $p_id
 * @property string $passport_number
 * @property string $type
 * @property string $date_issue
 * @property string $date_expire
 * @property string $place_issue
 * @property string $Authority
 * @property string $full_name
 * @property string $last_name
 * @property string $first_name
 * @property string $gender
 * @property string $birthday
 * @property string $birth_place
 * @property string $country_code
 * @property string $MRZ1
 * @property string $MRZ2
 */
class Passport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_m_passport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_issue', 'date_expire', 'birthday'], 'safe'],
            [['gender'], 'string'],
            [['passport_number', 'type'], 'string', 'max' => 20],
            [['place_issue', 'Authority', 'full_name', 'last_name', 'first_name'], 'string', 'max' => 100],
            [['birth_place'], 'string', 'max' => 250],
            [['country_code'], 'string', 'max' => 16],
            [['MRZ1', 'MRZ2'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'p_id' => 'P ID',
            'passport_number' => 'Passport Number',
            'type' => 'Type',
            'date_issue' => 'Date Issue',
            'date_expire' => 'Date Expire',
            'place_issue' => 'Place Issue',
            'Authority' => 'Authority',
            'full_name' => 'Full Name',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'birth_place' => 'Birth Place',
            'country_code' => 'Country Code',
            'MRZ1' => 'Mrz1',
            'MRZ2' => 'Mrz2',
        ];
    }
}
