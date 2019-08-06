<?php

use yii\db\Migration;

/**
 * Class m190806_190140_create_bonus_tables
 */
class m190806_190140_create_bonus_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart_bonus', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer(),
            'cart_item_id' => $this->integer(),
            'product_id' => $this->smallInteger(),
            'modification_id' => $this->smallInteger()
        ]);

        $this->createTable('cart_order_bonus', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer(),
            'order_id' => $this->integer(),
            'product_id' => $this->smallInteger(),
            'modification_id' => $this->smallInteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cart_bonus');
        $this->dropTable('cart_order_bonus');
    }
}
