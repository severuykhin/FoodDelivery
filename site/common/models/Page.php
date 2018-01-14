<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use common\models\Category;

class Page extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%page}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),

            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'content'    => 'Контент страницы',
            'title'      => 'Заголовок H1',
            'slug'       => 'Slug для ссылки',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего обновления'
        ];
    }

    public function rules()
    {
        return [
            [['content', 'title'], 'required'],
            [['content', 'title', 'slug'], 'string']
        ];
    }

    public static function getPages()
    {
        $pages = ArrayHelper::map(self::find()->asArray()->all(), 'slug', 'title');
        $categories = Category::find()->asArray()->all();

        $pages[Category::ROOT_MENU] = 'Меню';

        foreach($categories as $category) {
            $pages['menu#' . $category['slug']] = 'Меню: ' . $category['title'];
        }

        return $pages; 
    }
}