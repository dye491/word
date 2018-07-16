<?php

use yii\db\Migration;

/**
 * Class m180716_181809_drop_fk_template_id
 */
class m180716_181809_drop_fk_template_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_template_id', 'variable');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey('fk_template_id', 'variable', 'template_id', 'template', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180716_181809_drop_fk_template_id cannot be reverted.\n";

        return false;
    }
    */
}
