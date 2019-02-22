<?php

namespace app\modules\gestion\models;

use Yii;

/**
 * This is the model class for table "holiday_type".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property string $color
 * @property string $calendar_pin
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
            [['class'], 'string', 'max' => 20],
            [['color'], 'string', 'max' => 7],
            [['calendar_pin'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('holiday_type', 'ID'),
            'name' => Yii::t('holiday_type', 'Name'),
            'class' => Yii::t('holiday_type', 'Class'),
            'color' => Yii::t('holiday_type', 'Color'),
            'calendar_pin' => Yii::t('holiday_type', 'Calendar Pin'),
            'requestable' => Yii::t('holiday_type', 'Requestable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidays()
    {
        return $this->hasMany(Holidays::className(), ['holiday_type' => 'id']);
    }


    public static function getAssocHolidayTypes()
    {
        $datas = self::find()->where(['requestable' => 1])->asArray()->all();
        $holidayTypes = [];
        foreach ($datas as $data) {
            $holidayTypes[$data['id']] = $data;
        }
        return $holidayTypes;
    }
}
