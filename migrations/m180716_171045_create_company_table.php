<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 */
class m180716_171045_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('company', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'employee_count' => $this->integer(),
            'org_form' => $this->string()->defaultValue('ip'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('company');
    }
}
