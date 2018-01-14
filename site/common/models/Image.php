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

    public static function uploadFile($file, $dir, $oldName = null)
    {
        $fileName = self::generateName($file->baseName) . '.' . $file->extension;
        $path = Yii::getAlias('@statics') . '/uploads' . '/' . $dir;
        $fullPath = $path . '/' . $fileName;
        $oldPath = '';

        if ($oldName) {
            $oldPath = $path . '/' . $oldName;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }   
        }

        if ($file->saveAs($fullPath)) {
            return $fileName;
        } else {
            return false;
        }
    }

    public static function deleteFile($fileName, $dir)
    {
        $path = Yii::getAlias('@statics') . '/uploads' . '/' . $dir;
        $fullPath = $path . '/' . $fileName;

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return true;
        } else {
            return false;
        }
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

    public static function deleteDish($fileName, $id)
    {
        $path = Yii::getAlias('@statics') . '/uploads/dishes/' . $id;
        $fullPath = $path . '/' . $fileName;

        if (file_exists($path)) {
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // if (count(scandir($path)) === 2) {
            //     unlink($path);
            // } 
        }

        return true;
    }

    public static function generateName($name)
    {
        return md5($name);
    }
}