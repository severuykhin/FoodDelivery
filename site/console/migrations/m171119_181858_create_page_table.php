<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m171119_181858_create_page_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('page', [
            'id'         => $this->primaryKey(),
            'title'      => $this->string(200)->notNull()->comment('Заголовок H1'),
            'slug'       => $this->string()->comment('Слаг на сайт'), 
            'content'    => $this->text()->notNull()->comment('Контент страницы'),
            'created_at' => $this->integer(11)->comment('Дата создания'), 
            'updated_at' => $this->integer(11)->comment('Дата последнего обновления')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('page');
    }
}
