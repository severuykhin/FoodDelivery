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
    const INDEX_LIMIT   = 3;
    const UPLOAD_DIR    = 'reviews';   

    public $image;

    public static function tableName()
    {
        return '{{%review}}';
    } 

    public function behaviors()
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

    public static function getBest()
    {
        return self::find()
            ->where(['active' => self::STATUS_ACTIVE])
            ->limit(self::INDEX_LIMIT)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }
}