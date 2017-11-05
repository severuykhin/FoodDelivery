<?php

use yii\db\Migration;

/**
 * Handles adding categoryid to table `dish`.
 */
class m171105_125805_add_categoryid_column_to_dish_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('dish', 'category_id', 
            $this->integer()->notNull()->defaultValue(0)->comment('Id категории'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('dish', 'category_id');
    }
}
