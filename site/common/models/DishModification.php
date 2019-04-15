<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dish_modification".
 *
 * @property int $id
 * @property int $dish_id
 * @property string $value
 * @property string $price
 * @property string $price_old
 * @property string $weight
 */
class DishModification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dish_modification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dish_id'], 'integer'],
            [['price', 'price_old'], 'number'],
            [['dish_id', 'price', 'value'], 'required'],
            [['value', 'weight'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dish_id' => 'Блюдо',
            'value' => 'Значение',
            'price' => 'Цена',
            'price_old' => 'Старая цена',
            'weight' => 'Вес',
        ];
    }
}
