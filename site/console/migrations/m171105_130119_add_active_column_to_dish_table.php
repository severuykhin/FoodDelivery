<?php

use yii\db\Migration;

/**
 * Handles adding active to table `dish`.
 */
class m171105_130119_add_active_column_to_dish_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('dish', 'active', 
            $this->integer()->notNull()->defaultValue(0)->comment('Активен да\нет')    
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('dish', 'active');
    }
}
