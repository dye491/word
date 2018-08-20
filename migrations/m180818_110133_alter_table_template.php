<?php

use yii\db\Migration;

/**
 * Class m180818_110133_alter_table_template
 */
class m180818_110133_alter_table_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('template', 'parent_id', $this->integer());
        $this->addColumn('template', 'is_dir', $this->boolean());

        $this->addForeignKey('fk_template_parent', 'template', 'parent_id', 'template', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_template_parent', 'template');
        $this->dropColumn('template','parent_id');
        $this->dropColumn('template','is_dir');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180818_110133_alter_table_template cannot be reverted.\n";

        return false;
    }
    */
}
