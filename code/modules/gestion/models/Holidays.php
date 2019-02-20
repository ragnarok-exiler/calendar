<?php

namespace app\modules\gestion\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property int $id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property int $holiday_type
 * @property string $days_number
 * @property int $departmen_responsable_accepted
 * @property int $boss_accepted
 *
 * @property HolidayType $holidayType
 * @property User $user
 */
class Holidays extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'holidays';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'start_date', 'end_date'], 'required'],
            [['user_id', 'holiday_type', 'departmen_responsable_accepted', 'boss_accepted'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['days_number'], 'number'],
            [['holiday_type'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayType::className(), 'targetAttribute' => ['holiday_type' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('holiday_typeuser', 'ID'),
            'user_id' => Yii::t('holiday_typeuser', 'User ID'),
            'start_date' => Yii::t('holiday_typeuser', 'Start Date'),
            'end_date' => Yii::t('holiday_typeuser', 'End Date'),
            'holiday_type' => Yii::t('holiday_typeuser', 'Holiday Type'),
            'days_number' => Yii::t('holiday_typeuser', 'Days Number'),
            'departmen_responsable_accepted' => Yii::t('holiday_typeuser', 'Departmen Responsable Accepted'),
            'boss_accepted' => Yii::t('holiday_typeuser', 'Boss Accepted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayType()
    {
        return $this->hasOne(HolidayType::className(), ['id' => 'holiday_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
