<?php

use yii\db\Migration;
use common\models\Dish;

/**
 * Handles adding sort to table `{{%dish}}`.
 */
class m190716_190740_add_sort_column_to_dish_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%dish}}', 'sort', $this->boolean());

        foreach(Dish::find()->each() as $item) 
        {
            $item->sort = $item->id;
            $item->save();
        }

        $this->createIndex('order_id_index', '{{%cart_order_item}}', 'order_id');
        $this->createIndex('phone_index', '{{%cart_order}}', 'phone');
        $this->createIndex('dish_category_index', '{{%dish}}', 'category_id');
        $this->createIndex('dish_modification_index', '{{%dish_modification}}', 'dish_id');

    }   

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%dish}}', 'sort');
    }
}
