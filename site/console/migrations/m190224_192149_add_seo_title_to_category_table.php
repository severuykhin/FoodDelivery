<?php

use yii\db\Migration;

/**
 * Class m190224_192149_add_seo_title_to_category_table
 */
class m190224_192149_add_seo_title_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%categories}}', 'seo_title', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories}}', 'seo_title');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190224_192149_add_seo_title_to_category_table cannot be reverted.\n";

        return false;
    }
    */
}
