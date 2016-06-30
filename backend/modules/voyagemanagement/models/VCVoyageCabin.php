<?php

namespace app\modules\voyagemanagement\models;

use Yii;

/**
 * This is the model class for table "v_c_voyage_cabin".
 *
 * @property string $id
 * @property integer $voyage_id
 * @property integer $cabin_type_id
 * @property string $cabin_name
 * @property integer $deck_num
 * @property integer $cabin_lib_id
 * @property integer $max_check_in
 * @property integer $last_aduits_num
 * @property integer $cabin_status
 */
class VCVoyageCabin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_c_voyage_cabin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voyage_id', 'cabin_type_id', 'deck_num', 'cabin_lib_id', 'max_check_in', 'last_aduits_num', 'cabin_status'], 'integer'],
            [['cabin_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'voyage_id' => 'Voyage ID',
            'cabin_type_id' => 'Cabin Type ID',
            'cabin_name' => 'Cabin Name',
            'deck_num' => 'Deck Num',
            'cabin_lib_id' => 'Cabin Lib ID',
            'max_check_in' => 'Max Check In',
            'last_aduits_num' => 'Last Aduits Num',
            'cabin_status' => 'Cabin Status',
        ];
    }
}
