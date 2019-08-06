<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m171104_202436_create_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('categories', [
            'id'          => $this->primaryKey(),
            'slug'        => $this->string(150)->comment('Slug категории'),
            'title'       => $this->string(150)->notNull()->comment('Название категории'),
            'description' => $this->string(300)->comment('Краткое описание категории'),
            'created_at'  => $this->integer(11)->comment('Дата создания'),
            'updated_at'  => $this->integer(11)->comment('Дата последнего обновления')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('categories');
    }
}
