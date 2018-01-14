<?php

use yii\db\Migration;

class m171119_082409_add_column_to_photo_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('photo', 'title', 
            $this->string(200)->comment('Заголовок для фотографии')
        );
        $this->addColumn('photo', 'feed', 
            $this->smallinteger()->notNull()->defaultValue(0)->comment('Выводить в фото-ленту')
        );
        $this->addColumn('photo', 'about__block', 
            $this->smallinteger()->notNull()->defaultValue(0)->comment('Верхний блок на странице о нас')
        );
        $this->addColumn('photo', 'banner', 
            $this->smallinteger()->notNull()->defaultValue(0)->comment('Выводить в блок с баннерами')
        );
        $this->addColumn('photo', 'url', 
            $this->string(200)->comment('Ссылка на страницу')
        );
    }

    public function safeDown()
    {
        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171119_082409_add_column_to_photo_table cannot be reverted.\n";

        return false;
    }
    */
}
