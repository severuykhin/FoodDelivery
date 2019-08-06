<?php

use yii\db\Migration;

/**
 * Handles the creation of table `review`.
 */
class m171109_204507_create_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('review', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(100)->comment('Имя'),
            'date'        => $this->string(100)->comment('Дата'),
            'text'        => $this->text()->comment('Текст отзыва'),
            'pic'         => $this->string(300)->comment('Изображение'),
            'created_at'  => $this->integer(11)->comment('Дата создания'),
            'updated_at'  => $this->integer(11)->comment('Дата последнего обновления')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('review');
    }
}
