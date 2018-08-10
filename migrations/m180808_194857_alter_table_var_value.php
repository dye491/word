<?php

use yii\db\Migration;

/**
 * Class m180808_194857_alter_table_Var_value
 */
class m180808_194857_alter_table_var_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('var_value', 'value', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('var_value', 'value', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180808_194857_alter_table_Var_value cannot be reverted.\n";

        return false;
    }
    */
}
