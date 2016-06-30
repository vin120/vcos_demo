<?php

namespace travelagent\models;

use Yii;

/**
 * This is the model class for table "v_voyage_order".
 *
 * @property string $id
 * @property string $cruise_code
 * @property string $voyage_code
 * @property string $order_serial_number
 * @property integer $order_type
 * @property string $travel_agent_code
 * @property string $create_order_time
 * @property double $total_pay_price
 * @property double $total_ticket_price
 * @property double $total_tax_pric
 * @property double $total_port_expenses
 * @property double $total_additional_price
 * @property integer $pay_type
 * @property string $pay_time
 * @property integer $pay_status
 * @property integer $order_status
 * @property string $source_code
 * @property integer $source_type
 */
class VVoyageOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_voyage_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_type', 'pay_type', 'pay_status', 'order_status', 'source_type'], 'integer'],
            [['create_order_time', 'pay_time'], 'safe'],
            [['total_pay_price', 'total_ticket_price', 'total_tax_pric', 'total_port_expenses', 'total_additional_price'], 'number'],
            [['cruise_code', 'voyage_code', 'travel_agent_code', 'source_code'], 'string', 'max' => 32],
            [['order_serial_number'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cruise_code' => 'Cruise Code',
            'voyage_code' => 'Voyage Code',
            'order_serial_number' => 'Order Serial Number',
            'order_type' => 'Order Type',
            'travel_agent_code' => 'Travel Agent Code',
            'create_order_time' => 'Create Order Time',
            'total_pay_price' => 'Total Pay Price',
            'total_ticket_price' => 'Total Ticket Price',
            'total_tax_pric' => 'Total Tax Pric',
            'total_port_expenses' => 'Total Port Expenses',
            'total_additional_price' => 'Total Additional Price',
            'pay_type' => 'Pay Type',
            'pay_time' => 'Pay Time',
            'pay_status' => 'Pay Status',
            'order_status' => 'Order Status',
            'source_code' => 'Source Code',
            'source_type' => 'Source Type',
        ];
    }
}
