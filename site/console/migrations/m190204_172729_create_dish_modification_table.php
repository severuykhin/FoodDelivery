<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dish_modification}}`.
 */
class m190204_172729_create_dish_modification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dish_modification}}', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer(),
            'value' => $this->string(),
            'price' => $this->decimal(10,2),
            'price_old' => $this->decimal(10,2),
            'weight' => $this->string()
        ]);

        // creates index for column `dish_id`
        $this->createIndex(
            'idx-modification_dish_id',
            'dish_modification',
            'dish_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dish_modification}}');
    }
}
