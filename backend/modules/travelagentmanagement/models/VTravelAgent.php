<?php

namespace app\modules\travelagentmanagement\models;

use Yii;

/**
 * This is the model class for table "v_travel_agent".
 *
 * @property integer $travel_agent_id
 * @property string $travel_agent_code
 * @property string $travel_agent_name
 * @property string $travel_agent_address
 * @property string $travel_agent_phone
 * @property string $travel_agent_post_code
 * @property string $travel_agent_email
 * @property string $travel_agent_fax
 * @property string $travel_agent_bank_holder
 * @property string $travel_agent_account_bank
 * @property string $travel_agent_account
 * @property string $travel_agent_contact_name
 * @property string $travel_agent_contact_phone
 * @property string $travel_agent_admin
 * @property string $travel_agent_password
 * @property string $pay_password
 * @property string $travel_agent_last_login_time
 * @property string $travel_agent_last_change_password_time
 * @property integer $sort_order
 * @property integer $travel_agent_status
 * @property string $contract_start_time
 * @property string $contract_end_time
 * @property integer $overdraft_amount
 * @property integer $current_amount
 * @property string $create_by
 * @property string $create_time
 * @property string $country_code
 * @property string $city_code
 * @property integer $is_online_booking
 * @property integer $commission_percent
 * @property integer $travel_agent_level
 */
class VTravelAgent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_travel_agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_agent_code', 'travel_agent_name', 'travel_agent_phone'], 'required'],
            [['travel_agent_last_login_time', 'travel_agent_last_change_password_time', 'contract_start_time', 'contract_end_time', 'create_time'], 'safe'],
            [['sort_order', 'travel_agent_status', 'overdraft_amount', 'current_amount', 'is_online_booking', 'commission_percent', 'travel_agent_level'], 'integer'],
            [['travel_agent_code', 'travel_agent_phone', 'travel_agent_post_code', 'travel_agent_fax', 'travel_agent_account', 'travel_agent_contact_name', 'travel_agent_contact_phone', 'travel_agent_admin', 'travel_agent_password', 'pay_password', 'create_by'], 'string', 'max' => 32],
            [['travel_agent_name', 'travel_agent_bank_holder'], 'string', 'max' => 64],
            [['travel_agent_address', 'travel_agent_email', 'travel_agent_account_bank'], 'string', 'max' => 128],
            [['country_code', 'city_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'travel_agent_id' => 'Travel Agent ID',
            'travel_agent_code' => 'Travel Agent Code',
            'travel_agent_name' => 'Travel Agent Name',
            'travel_agent_address' => 'Travel Agent Address',
            'travel_agent_phone' => 'Travel Agent Phone',
            'travel_agent_post_code' => 'Travel Agent Post Code',
            'travel_agent_email' => 'Travel Agent Email',
            'travel_agent_fax' => 'Travel Agent Fax',
            'travel_agent_bank_holder' => 'Travel Agent Bank Holder',
            'travel_agent_account_bank' => 'Travel Agent Account Bank',
            'travel_agent_account' => 'Travel Agent Account',
            'travel_agent_contact_name' => 'Travel Agent Contact Name',
            'travel_agent_contact_phone' => 'Travel Agent Contact Phone',
            'travel_agent_admin' => 'Travel Agent Admin',
            'travel_agent_password' => 'Travel Agent Password',
            'pay_password' => 'Pay Password',
            'travel_agent_last_login_time' => 'Travel Agent Last Login Time',
            'travel_agent_last_change_password_time' => 'Travel Agent Last Change Password Time',
            'sort_order' => 'Sort Order',
            'travel_agent_status' => 'Travel Agent Status',
            'contract_start_time' => 'Contract Start Time',
            'contract_end_time' => 'Contract End Time',
            'overdraft_amount' => 'Overdraft Amount',
            'current_amount' => 'Current Amount',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'country_code' => 'Country Code',
            'city_code' => 'City Code',
            'is_online_booking' => 'Is Online Booking',
            'commission_percent' => 'Commission Percent',
            'travel_agent_level' => 'Travel Agent Level',
        ];
    }
}
