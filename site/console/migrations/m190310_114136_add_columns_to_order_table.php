<?php

use yii\db\Migration;

/**
 * Class m190310_114136_add_columns_to_order_table
 */
class m190310_114136_add_columns_to_order_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('cart_order', 'name', $this->string()->comment('Контактоное лицо'));
        $this->addColumn('cart_order', 'change', $this->string()->comment('С какой суммы подготовить сдачу'));
    }

    public function down()
    {
        $this->dropColumn('cart_order', 'name');
        $this->dropColumn('cart_order', 'chnage');
    }
}
