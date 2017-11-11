<?php

namespace common\models;

use Yii;

use common\models\Image;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Photo extends ActiveRecord
{

    public $image;
    public $tempDate;

    const ON_MAIN     = 1;
    const UPLOAD_DIR  = 'photos';
    const DATE_FORMAT = 'd.m.Y'; 

    public static function tableName()
    {
        return '{{%photo}}';
    }

    public function rules()
    {
        return [
            [['src', 'date', 'tempDate'], 'required'],
            [['desc', 'src'], 'string'],
            [['date'], 'integer'],
            [['main'], 'boolean']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'desc'     => 'Краткое описание',
            'date'     => 'Дата',
            'src'      => 'Фото',
            'image'    => 'Фото',
            'main'     => 'Выводить на главной',
            'tempDate' => 'Дата'
        ];
    }

    public function setDate()
    {
        $this->date = strtotime($this->tempDate);

        return true;
    }

    public function getDate()
    {
        $this->tempDate = date(self::DATE_FORMAT, $this->date);

        return true;
    }

    public function deletePhoto()
    {
        return Image::deleteFile($this->src, self::UPLOAD_DIR);
    }
}