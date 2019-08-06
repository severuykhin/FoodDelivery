<?php

use yii\db\Migration;

/**
 * Handles the creation of table `photo`.
 */
class m171111_174420_create_photo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('photo', [
            'id'   => $this->primaryKey(),
            'desc' => $this->text()->comment('Описание'),
            'date' => $this->integer(11)->comment('Дата'),
            'main' => $this->smallinteger()->notNull()->defaultValue(0)->comment('Выводить на главной'),
            'src'  => $this->string(150)->notNull()->comment('Изображение'),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('photo');
    }
}
