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

    const ON_MAIN       = 1;
    const STATUS_ACTIVE = 1;
    const UPLOAD_DIR    = 'photos';
    const DATE_FORMAT   = 'd.m.Y'; 

    public static function tableName()
    {
        return '{{%photo}}';
    }

    public function rules()
    {
        return [
            [['src', 'date', 'tempDate'], 'required'],
            [['desc', 'src', 'url', 'title'], 'string'],
            [['date'], 'integer'],
            [['main', 'banner', 'feed', 'about__block'], 'boolean']
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
            'desc'         => 'Краткое описание',
            'title'        => 'Заголовок', 
            'date'         => 'Дата',
            'src'          => 'Фото',
            'image'        => 'Фото',
            'main'         => 'Выводить на главной',
            'banner'       => 'Выводить в баннер',
            'about__block' => 'Выводить в верхний блок на странице о нас',
            'feed'         => 'Выводить в фото-ленту',
            'url'          => 'Связанная страница',
            'tempDate'     => 'Дата'
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