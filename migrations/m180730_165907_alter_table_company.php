<?php

use yii\db\Migration;

/**
 * Class m180730_165907_alter_table_company
 */
class m180730_165907_alter_table_company extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'last_payment', $this->date()->defaultValue(null));
        $this->addColumn('company', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company','last_payment');
        $this->dropColumn('company','email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180730_165907_alter_table_company cannot be reverted.\n";

        return false;
    }
    */
}
