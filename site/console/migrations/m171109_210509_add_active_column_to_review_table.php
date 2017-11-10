<?php

use yii\db\Migration;

/**
 * Handles adding active to table `review`.
 */
class m171109_210509_add_active_column_to_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('review', 'active', $this->smallInteger()->notNull()->defaultValue(0)->comment("Выводить на главной"));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('review', 'active');
    }
}
