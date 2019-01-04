<?php

namespace app\modules\gestion\models;

use Yii;

/**
 * This is the model class for table "festive".
 *
 * @property int $id
 * @property string $free_day
 * @property int $festive_type_id
 *
 * @property FestiveType $festiveType
 */
class Festive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'festive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['free_day', 'festive_type_id'], 'required'],
            [['free_day'], 'safe'],
            [['festive_type_id'], 'integer'],
            [['festive_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FestiveType::className(), 'targetAttribute' => ['festive_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'free_day' => Yii::t('user', 'Free Day'),
            'festive_type_id' => Yii::t('user', 'Festive Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFestiveType()
    {
        return $this->hasOne(FestiveType::className(), ['id' => 'festive_type_id']);
    }
}
