<?php

namespace app\modules\ordermanagement\models;

use Yii;

/**
 * This is the model class for table "v_membership".
 *
 * @property string $m_id
 * @property string $smart_card_number
 * @property string $m_code
 * @property string $m_name
 * @property string $email
 * @property string $mobile_number
 * @property string $fixed_telephone
 * @property string $m_password
 * @property double $balance
 * @property double $max_overdraft_limit
 * @property double $curr_overdraft_limit
 * @property integer $points
 * @property integer $vip_grade
 * @property string $full_name
 * @property string $last_name
 * @property string $first_name
 * @property string $gender
 * @property string $birthday
 * @property string $birth_place
 * @property string $country_code
 * @property string $passport_number
 * @property string $resident_id_card
 * @property string $nation_code
 * @property integer $member_verification
 * @property integer $email_verification
 * @property integer $mobile_verification
 * @property string $create_by
 * @property string $create_time
 * @property string $remark
 * @property string $sign
 */
class VMembership extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_membership';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balance', 'max_overdraft_limit', 'curr_overdraft_limit'], 'number'],
            [['points', 'vip_grade', 'member_verification', 'email_verification', 'mobile_verification'], 'integer'],
            [['gender'], 'string'],
            [['birthday', 'create_time'], 'safe'],
            [['smart_card_number', 'm_name'], 'string', 'max' => 50],
            [['m_code', 'resident_id_card', 'create_by'], 'string', 'max' => 32],
            [['email', 'm_password', 'full_name', 'last_name', 'first_name'], 'string', 'max' => 100],
            [['mobile_number', 'fixed_telephone', 'passport_number'], 'string', 'max' => 20],
            [['birth_place'], 'string', 'max' => 250],
            [['country_code'], 'string', 'max' => 16],
            [['nation_code'], 'string', 'max' => 2],
            [['remark'], 'string', 'max' => 128],
            [['sign'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_id' => 'M ID',
            'smart_card_number' => 'Smart Card Number',
            'm_code' => 'M Code',
            'm_name' => 'M Name',
            'email' => 'Email',
            'mobile_number' => 'Mobile Number',
            'fixed_telephone' => 'Fixed Telephone',
            'm_password' => 'M Password',
            'balance' => 'Balance',
            'max_overdraft_limit' => 'Max Overdraft Limit',
            'curr_overdraft_limit' => 'Curr Overdraft Limit',
            'points' => 'Points',
            'vip_grade' => 'Vip Grade',
            'full_name' => 'Full Name',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'birth_place' => 'Birth Place',
            'country_code' => 'Country Code',
            'passport_number' => 'Passport Number',
            'resident_id_card' => 'Resident Id Card',
            'nation_code' => 'Nation Code',
            'member_verification' => 'Member Verification',
            'email_verification' => 'Email Verification',
            'mobile_verification' => 'Mobile Verification',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'remark' => 'Remark',
            'sign' => 'Sign',
        ];
    }
}
