<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "issue".
 *
 * @property integer $id
 * @property string $name
 * @property string $solution
 * @property integer $rating
 */
class Issue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rating'], 'integer'],
            [['name', 'solution'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Проблема',
            'solution' => 'Решение',
            'rating' => 'Оценка',
        ];
    }
}
