<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage".
 *
 * @property integer $id
 * @property string $voyage_code
 * @property string $cruise_code
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property string $area_code
 * @property string $pdf_path
 * @property string $start_book_time
 * @property string $stop_book_time
 * @property double $ticket_price
 * @property integer $ticket_taxes
 * @property integer $harbour_taxes
 * @property integer $deposit_ratio
 */
class VCVoyage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'start_book_time', 'stop_book_time'], 'safe'],
            [['status', 'ticket_taxes', 'harbour_taxes', 'deposit_ratio'], 'integer'],
            [['ticket_price'], 'number'],
            [['voyage_code', 'cruise_code', 'area_code', 'pdf_path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'voyage_code' => Yii::t('app', 'Voyage Code'),
            'cruise_code' => Yii::t('app', 'Cruise Code'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'status' => Yii::t('app', 'Status'),
            'area_code' => Yii::t('app', 'Area Code'),
            'pdf_path' => Yii::t('app', 'Pdf Path'),
            'start_book_time' => Yii::t('app', 'Start Book Time'),
            'stop_book_time' => Yii::t('app', 'Stop Book Time'),
            'ticket_price' => Yii::t('app', 'Ticket Price'),
            'ticket_taxes' => Yii::t('app', 'Ticket Taxes'),
            'harbour_taxes' => Yii::t('app', 'Harbour Taxes'),
            'deposit_ratio' => Yii::t('app', 'Deposit Ratio'),
        ];
    }
}
