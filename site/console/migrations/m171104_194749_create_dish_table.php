<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dish`.
 */
class m171104_194749_create_dish_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dish', [
            'id'           => $this->primaryKey(),
            'slug'         => $this->string(300)->notNull()->comment('Slug'),
            'title'        => $this->string(200)->notNull()->comment("Название блюда"),
            'weight'       => $this->string(50)->notNull()->comment("Вес блюда"),
            'description'  => $this->text()->notNUll()->comment("Описание блюда"),
            'pic'          => $this->string(300)->comment("Изображение блюда"),
            'price_actual' => $this->string(50)->notNull()->comment("Актуальная цена блюда"),
            'price_old'    => $this->string(50)->comment("Старая цена блюда"),
            'best'         => $this->smallInteger()->notNull()->defaultValue(0)->comment("Выводить в блок Лучшие"),
            'action'       => $this->smallInteger()->notNull()->defaultValue(0)->comment("Выводит в блок акции"),
            'created_at'   => $this->integer(11)->comment('Дата создания'), 
            'updated_at'   => $this->integer(11)->comment('Дата последнего обновления')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dish');
    }
}
