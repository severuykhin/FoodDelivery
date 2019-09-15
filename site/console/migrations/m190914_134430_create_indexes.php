<?php

use yii\db\Migration;

/**
 * Class m190914_134430_create_indexes
 */
class m190914_134430_create_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('dish_id_index', '{{%cart_order_item}}', 'product_id');
        $this->createIndex('dish_modification_id', '{{%dish_modification}}', 'dish_id');
        $this->createIndex('cart_session_id', '{{%cart}}', 'session_id');

    }

    public function down() 
    {
        return false;
    }
}
