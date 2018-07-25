<?php

use yii\db\Migration;

/**
 * Handles the creation of table `doc`.
 */
class m180725_090059_create_doc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'doc_path' => $this->string(),
            'pdf_path' => $this->string(),
            'status' => $this->string(),
            'sent_at' => $this->timestamp()->defaultValue(null),
        ]);

        $this->addForeignKey('fk_document_company_id', 'document', 'company_id', 'company', 'id');
        $this->addForeignKey('fk_document_template_id', 'document', 'template_id', 'template', 'id');
        $this->createIndex('company_template_date_unique', 'document', ['company_id', 'template_id', 'date'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('document');
    }
}
