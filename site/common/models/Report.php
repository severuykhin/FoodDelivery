<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $created_at
 * @property string $title
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['text'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'title' => 'Title',
        ];
    }
}
