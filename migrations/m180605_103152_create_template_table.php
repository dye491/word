<?php

use yii\db\Migration;

/**
 * Handles the creation of table `template`.
 */
class m180605_103152_create_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('template', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'file_name' => $this->string(),
            'form_class' => $this->string(),
            'vars' => $this->string(),
        ]);
        $this->createIndex('idx_form_class', 'template', 'form_class');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_form_class', 'template');
        $this->dropTable('template');
    }
}
