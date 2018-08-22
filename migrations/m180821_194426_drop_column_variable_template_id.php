<?php

use yii\db\Migration;

/**
 * Class m180821_194426_drop_column_variable_template_id
 */
class m180821_194426_drop_column_variable_template_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('variable','template_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180821_194426_drop_column_variable_template_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180821_194426_drop_column_variable_template_id cannot be reverted.\n";

        return false;
    }
    */
}
