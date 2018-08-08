<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee`.
 */
class m180808_133244_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employee', [
            'id' => $this->primaryKey(),
            'fio_ip' => $this->string()->notNull(),
            'fio_rp' => $this->string()->notNull(),
            'position_ip' => $this->string()->notNull(),
            'position_rp' => $this->string()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->defaultValue(null),
        ]);

        $this->addForeignKey('fk_employee_company', 'employee', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employee');
    }
}
