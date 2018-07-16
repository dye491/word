<?php

use yii\db\Migration;

/**
 * Class m180716_172116_alter_template_table
 */
class m180716_172116_alter_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('template', 'start_date', $this->date());
        $this->addColumn('template', 'end_date', $this->date());
        $this->addColumn('template', 'is_active', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('template','start_date');
        $this->dropColumn('template','end_date');
        $this->dropColumn('template','is_active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180716_172116_alter_template_table cannot be reverted.\n";

        return false;
    }
    */
}
