<?php

use yii\db\Migration;

/**
 * Class m190702_192632_add_top_title_to_categories_table
 */
class m190702_192632_add_top_title_to_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%categories}}', 'seo_page_title', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories}}', 'seo_page_title', $this->string());
    }
}
