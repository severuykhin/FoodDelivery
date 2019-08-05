<?php

use yii\db\Migration;

/**
 * Class m190804_124715_alter_dish_table
 */
class m190804_124715_alter_dish_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cart_item', 'bonus', $this->tinyInteger()->defaultValue(0)->comment('Идет как бонус'));
        $this->addColumn('cart_item', 'bonus_type', $this->tinyInteger()->defaultValue(0)->comment('Тип бонуса'));
        $this->addColumn('cart_order_item', 'bonus', $this->tinyInteger()->defaultValue(0)->comment('Идет как бонус'));
        $this->addColumn('cart_order_item', 'bonus_type', $this->tinyInteger()->defaultValue(0)->comment('Тип бонуса'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cart_item', 'bonus');
        $this->dropColumn('cart_item', 'bonus_type');
        $this->dropColumn('cart_order_item', 'bonus');
        $this->dropColumn('cart_order_item', 'bonus_type');
    }
}
