<?php

use yii\db\Migration;

/**
 * Class m190914_141040_alter_cart_order_item_table
 */
class m190914_141040_alter_cart_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%cart_order_item}}', 'quantity', $this->smallInteger(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190914_141040_alter_cart_order_item_table cannot be reverted.\n";

        return false;
    }
}
