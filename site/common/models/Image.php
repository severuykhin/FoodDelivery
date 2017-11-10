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

    public static function uploadReview($file, $oldName = null)
    {
        $fileName = self::generateName($file->baseName) . '.' . $file->extension;
        $path = Yii::getAlias('@statics') . '/uploads/reviews';
        $fullPath = $path . '/' . $fileName;
        $oldPath = '';

        if ($oldName) {
            $oldPath = $path . '/' . $oldName;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }   
        }

        $file->saveAs($fullPath);

        return $fileName;
    }

    public function upload($file, $id)
    {
        $fileName = self::generateName($file->baseName) . '.' . $file->extension;
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

    public static function generateName($name)
    {
        return md5($name);
    }
}