<?php

namespace travelagent\models;

use Yii;

/**
 * This is the model class for table "v_travelagent_membership".
 *
 * @property string $m_id
 * @property string $full_name
 * @property string $last_name
 * @property string $first_name
 * @property string $gender
 * @property string $birthday
 * @property string $birth_place
 * @property string $country_code
 * @property string $passport_num
 * @property string $date_issue
 * @property string $date_expire
 * @property string $email
 * @property string $phone
 * @property string $create_by
 * @property string $create_time
 */
class VTravelagentMembership extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_travelagent_membership';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender'], 'string'],
            [['birthday', 'date_issue', 'date_expire', 'create_time'], 'safe'],
            [['full_name', 'last_name', 'first_name', 'email'], 'string', 'max' => 100],
            [['birth_place'], 'string', 'max' => 250],
            [['country_code'], 'string', 'max' => 16],
            [['passport_num', 'create_by'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_id' => 'M ID',
            'full_name' => 'Full Name',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'birth_place' => 'Birth Place',
            'country_code' => 'Country Code',
            'passport_num' => 'Passport Num',
            'date_issue' => 'Date Issue',
            'date_expire' => 'Date Expire',
            'email' => 'Email',
            'phone' => 'Phone',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
        ];
    }
}
