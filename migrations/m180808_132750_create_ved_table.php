<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ved`.
 */
class m180808_132750_create_ved_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ved', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'text' => $this->string()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->defaultValue(null),
        ]);

        $this->addForeignKey('fk_ved_company', 'ved', 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ved');
    }
}
