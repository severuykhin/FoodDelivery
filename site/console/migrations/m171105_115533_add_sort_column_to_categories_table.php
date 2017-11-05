<?php

use yii\db\Migration;

/**
 * Handles adding sort to table `categories`.
 */
class m171105_115533_add_sort_column_to_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('categories', 'sort', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('categories', 'sort');
    }
}
