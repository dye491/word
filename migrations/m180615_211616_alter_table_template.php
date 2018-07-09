<?php

use yii\db\Migration;

/**
 * Class m180615_211616_alter_table_template
 */
class m180615_211616_alter_table_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('template', 'vars', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180615_211616_alter_table_template cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180615_211616_alter_table_template cannot be reverted.\n";

        return false;
    }
    */
}
