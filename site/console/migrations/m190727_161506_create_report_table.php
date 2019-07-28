<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 */
class m190727_161506_create_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'title' => $this->char(200),
            'text' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report}}');
    }
}
