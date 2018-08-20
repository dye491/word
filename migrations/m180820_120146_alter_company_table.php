<?php

use yii\db\Migration;

/**
 * Class m180820_120146_alter_company_table
 */
class m180820_120146_alter_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'branch', $this->string());
        $this->addColumn('company', 'is_new', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'branch');
        $this->dropColumn('company', 'is_new');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180820_120146_alter_company_table cannot be reverted.\n";

        return false;
    }
    */
}
