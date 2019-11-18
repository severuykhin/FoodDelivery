<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use himiklab\sortablegrid\SortableGridBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use common\models\Category;
use common\models\DishModification;


class Dish extends ActiveRecord
{
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

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
        return '{{%dish}}';
    }

    public function rules()
    {
        return [
            [['title', 'weight', 'price_actual', 'category_id'], 'required'],
            [['title', 'description', 'weight', 'price_actual', 'price_old'], 'string'],
            [['sort'], 'integer'],
            [['active', 'action', 'best'], 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title'        => 'Название',
            'description'  => 'Описание',
            'weight'       => 'Вес',
            'category_id'  => 'Категория',
            'active'       => 'Активно',
            'action'       => 'Акция',
            'best'         => 'Лучшие',
            'pic'          => 'Изображение',
            'price_actual' => 'Текущая цена',
            'price_old'    => 'Старая цена (для акций)',
            'created_at'   => 'Дата создания',
            'updated_at'   => 'Дата последнего обновления',
        ];
    }

    public static function findBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getModifications()
    {
        return $this->hasMany(DishModification::class, ['dish_id' => 'id']);
    }

    public function saveImage($fileName)
    {
        $this->pic = $fileName;

        return $this->save(false);
    }

    public static function getBest()
    {
        return self::find()
                ->where(['best' => self::STATUS_ACTIVE])
                ->with(['category', 'modifications'])
                ->orderBy('sort')
                ->all();
    }
}