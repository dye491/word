<?php

use yii\db\Migration;

/**
 * Handles the creation of table `variable`.
 */
class m180605_103454_create_variable_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('variable', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'label'=> $this->string(),
            'template_id' => $this->integer(),
//            'dimension' => $this->integer(),
            'group' => $this->string(),
            'type' => $this->string()->defaultValue('string'),
        ]);

        $this->addForeignKey('fk_template_id', 'variable', 'template_id', 'template', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('variable');
    }
}
