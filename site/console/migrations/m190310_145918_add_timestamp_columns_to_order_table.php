<?php

use yii\db\Migration;

/**
 * Handles adding timestamp to table `{{%order}}`.
 */
class m190310_145918_add_timestamp_columns_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cart_order', 'created_at', $this->integer());
        $this->addColumn('cart_order', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cart_order', 'created_at');
        $this->dropColumn('cart_order', 'updated_at');
    }
}
