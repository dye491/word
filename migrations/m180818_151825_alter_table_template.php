<?php

use yii\db\Migration;

/**
 * Class m180818_151825_alter_table_template
 */
class m180818_151825_alter_table_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('template', 'org_form', $this->string());
        $this->addColumn('template', 'emp_count', $this->integer());
        $this->addColumn('template', 'branch', $this->string());
        $this->addColumn('template', 'is_new', $this->boolean());
        $this->addColumn('template', 'short_name', $this->string());
        $this->addColumn('template', 'event_id', $this->integer());

        $this->addForeignKey('fk_template_event', 'template', 'event_id', 'event', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_template_event','template');
        $this->dropColumn('template', 'event_id');
        $this->dropColumn('template', 'org_form');
        $this->dropColumn('template', 'emp_count');
        $this->dropColumn('template', 'branch');
        $this->dropColumn('template', 'is_new');
        $this->dropColumn('template', 'short_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180818_151825_alter_table_template cannot be reverted.\n";

        return false;
    }
    */
}
