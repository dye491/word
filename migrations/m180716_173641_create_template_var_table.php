<?php

use yii\db\Migration;

/**
 * Handles the creation of table `template_var`.
 */
class m180716_173641_create_template_var_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('template_var', [
            'id' => $this->primaryKey(),
            'required' => $this->boolean(),
            'var_id' => $this->integer()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
        ]);

        $this->addForeignKey('fk_template_var_var_id', 'template_var', 'var_id', 'variable', 'id');
        $this->addForeignKey('fk_template_var_template_id', 'template_var', 'template_id', 'template', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('template_var');
    }
}
