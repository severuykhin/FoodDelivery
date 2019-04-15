<?php

use yii\db\Migration;

/**
 * Class m190214_191429_create_cart_tables
 */
class m190214_191429_create_cart_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart', [
            'id'         => $this->primaryKey(),
            'session_id' => $this->string()
        ]);

        $this->createTable('cart_item', [
            'id'              => $this->primaryKey(),
            'cart_id'         => $this->integer(),
            'product_id'      => $this->integer(),
            'modification_id' => $this->integer(),
            'quantity'        => $this->integer(),
        ]);

        $this->createTable('cart_order', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'payment' => $this->integer(),
            'street' => $this->string(),
            'house' => $this->string(),
            'code' => $this->string(),
            'apartment' => $this->string(),
            'floor' => $this->string(),
            'entrance' => $this->string(),
            'comment' => $this->string()
        ]);

        $this->createTable('cart_order_item', [
            'id'              => $this->primaryKey(),
            'cart_id'         => $this->integer(),
            'order_id'        => $this->integer(),
            'product_id'      => $this->integer(),
            'modification_id' => $this->integer(),
            'quantity'        => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cart');
        $this->dropTable('cart_item');
        $this->dropTable('cart_order');
        $this->dropTable('cart_order_item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190214_191429_create_cart_tables cannot be reverted.\n";

        return false;
    }
    */
}
