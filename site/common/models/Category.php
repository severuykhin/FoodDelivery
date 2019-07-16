<?php

namespace common\models;

use Yii;
use common\models\Dish;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use himiklab\sortablegrid\SortableGridBehavior;

class Category extends ActiveRecord
{
    const ROOT_MENU = 'menu#all';
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),

            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                // 'slugAttribute' => 'slug',
            ],
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sort'
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%categories}}';
    }

    public function rules()
    {
        return [
            [['title', 'seo_title', 'seo_page_title', 'seo_desc'], 'required'],
            [['title', 'description', 'seo_page_title', 'seo_title', 'seo_desc'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title'       => 'Название',
            'seo_title'   => 'h1',
            'seo_page_title'   => 'title',
            'seo_desc'   => 'description',
            'description' => 'Описание',
            'created_at'  => 'Дата создания',
            'updated_at'  => 'Дата последнего обновления',
        ];
    }

    public static function findBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one();
    }

    public static function findWithDishes($slug)
    {   
        return self::find()->where(['slug' => $slug])->with(['dishes']);
    }

    public static function getTitlesArray()
    {
        $categories = self::find()->orderBy(['sort' => SORT_DESC])->asArray()->all();

        return ArrayHelper::map($categories, 'id', 'title');
    }

    public function getDishes()
    {
        return $this->hasMany(Dish::className(), ['category_id' => 'id'])->orderBy('sort');
    }
}