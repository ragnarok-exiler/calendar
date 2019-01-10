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
 * @property string $range_date
 * @property float $days_number
 * @property int $holiday_type
 * @property boolean departmen_responsable_accepted
 * @property boolean boss_accepted
 *
 * @property User $user
 */
class Holidays extends \yii\db\ActiveRecord
{
    public $range_date;

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
            [['user_id', 'start_date', 'end_date', 'days_number'], 'required'],
            [['user_id', 'days_number'], 'integer'],
            [['user_id', 'departmen_responsable_accepted', 'boss_accepted', 'holiday_type'], 'integer'],
            [['days_number'], 'number'],
            [['start_date', 'end_date'], 'safe'],

            [['start_date'], 'date', 'format' => 'php:Y-m-d'],
            [['end_date'], 'date', 'format' => 'php:Y-m-d'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('calendario', 'ID'),
            'user_id' => Yii::t('calendario', 'ID de usuario'),
            'start_date' => Yii::t('calendario', 'Fecha inicio'),
            'end_date' => Yii::t('calendario', 'Fecha fin'),
            'days_number' => Yii::t('calendario', 'Numero de días'),
            'holiday_type' => Yii::t('calendario', 'Tipo de vcaciones'),
            'departmen_responsable_accepted' => Yii::t('calendario', 'Aceptado responsable departamento'),
            'boss_accepted' => Yii::t('calendario', 'Aceptado jefe'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
