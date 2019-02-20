<?php

namespace app\modules\gestion\models;

use Yii;

/**
 * This is the model class for table "holiday_type".
 *
 * @property int $id
 * @property string $name
 * @property int $requestable
 *
 * @property Holidays[] $holidays
 */
class HolidayType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'holiday_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['requestable'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('holiday_typeuser', 'ID'),
            'name' => Yii::t('holiday_typeuser', 'Name'),
            'requestable' => Yii::t('holiday_typeuser', 'Requestable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidays()
    {
        return $this->hasMany(Holidays::className(), ['holiday_type' => 'id']);
    }
}
