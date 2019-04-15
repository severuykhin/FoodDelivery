<?php

use yii\db\Migration;

/**
 * Handles adding status to table `{{%cart_order}}`.
 */
class m190323_103506_add_status_column_to_cart_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cart_order', 'status', $this->integer()->defaultValue(0)->comment('Статус заказа'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cart_order', 'status');
    }
}
