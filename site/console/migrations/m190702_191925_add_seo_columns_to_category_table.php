<?php

use yii\db\Migration;

/**
 * Handles adding seo to table `{{%category}}`.
 */
class m190702_191925_add_seo_columns_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%categories}}', 'seo_desc', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories}}', 'seo_desc');
    }
}
