<?php

use yii\db\Migration;

/**
 * Class m200402_173134_add_column_to_category_table
 */
class m200402_173134_add_column_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('dish', 'act_in_action', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('dish', 'act_in_action');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200402_173134_add_column_to_category_table cannot be reverted.\n";

        return false;
    }
    */
}
