<?php

namespace common\models;

use Yii;
use yii\base\model;

class Image extends model
{
    public $image;

    public function attributeLabels()
    {
        return [
            'image' => 'Изображение'
        ];
    }

    public function upload($file, $id)
    {
        $fileName = $this->generateName($file->baseName) . '.' . $file->extension;
        $path = Yii::getAlias('@statics') . '/uploads/dishes/' . $id;
        $fullPath = $path . '/' . $fileName;

        if (file_exists($path)) {
            foreach (glob($path . '/*') as $f) {
                unlink($f);
            }
        } else {
            mkdir($path, 0777);
        }

        $file->saveAs($fullPath);

        return $fileName;
    }

    public function generateName($name)
    {
        return md5($name);
    }
}