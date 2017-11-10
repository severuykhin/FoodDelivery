<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use common\models\Image;

class Review extends ActiveRecord
{
    const STATUS_ACTIVE = 1;

    public $image;

    public static function tableName()
    {
        return '{{%review}}';
    } 

    public function behaviours()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['name', 'date'], 'required'],
            [['name', 'date', 'text', 'pic'], 'string'],
            [['active'], 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'text'   => 'Текст отзыва',
            'name'   => 'Имя автора',
            'date'   => 'Дата',
            'active' => 'На главной',
            'pic'    => 'Изображение',
            'image'  => 'Изображение'
        ];
    }
}