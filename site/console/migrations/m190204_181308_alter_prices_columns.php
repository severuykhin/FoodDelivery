<?php

use yii\db\Migration;

/**
 * Class m190204_181308_alter_prices_columns
 */
class m190204_181308_alter_prices_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('dish', 'price_actual', $this->decimal(10,2));
        $this->alterColumn('dish', 'price_old', $this->decimal(10,2));
    }
}
