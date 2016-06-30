<?php 
namespace app\modules\ordermanagement\components;
use Yii;
class CreateMember
{
    /**
     * 创建会员号
     */
    public static function createMemberNumber()
    {
        $sql_value = 'SELECT m_id FROM v_membership ORDER BY m_id DESC LIMIT 1 ' ;
        $member_id_value = Yii::$app->db->createCommand($sql_value)->queryScalar();

        if (empty($member_id_value))
        {
            $member_id_value = 1;
        }
        else
        {
            $member_id_value++;
        }
        $infix_no = str_pad($member_id_value,8,'0',STR_PAD_LEFT);
        $prefix_no = '01';
        $suffix_no = self::createCheckValue($prefix_no.$infix_no);
        $member_no = $prefix_no.$infix_no.$suffix_no;

        return $member_no;
    }
    
    //判断是否大于10，如果大于10则调用getOneValue，小于10则返回
    private  static function createCheckValue($member_no)
    {
        $odd_value = 0;//奇数
        $even_value = 0;//偶数
        for ($i = 0; $i<10; $i++)
        {
            //下标0开始，所以奇数是被2整除
            if (0 == $i%2)
            {
                $odd_value += $member_no[$i];
            }
            else
            {
                $even_value += $member_no[$i];
            }
        }
        
        if (9 < $odd_value)
        {
            $odd_value = self::getOneValue($odd_value);
        }
        
        if (9 < $even_value)
        {
            $even_value = self::getOneValue($even_value);
        }
        return $odd_value.''.$even_value;
    }
    
    //得到一位数
    private static function getOneValue($value)
    {
        $len = strlen($value);
        $temp_value = 0;    

        for($i=0; $i<$len; $i++)
        {
            $temp_value += substr($value, $i,1);
        }

        if (10<=$temp_value)
        {
            return self::getOneValue($temp_value);
        }
        else
        {
            return $temp_value;
        }
    }
}