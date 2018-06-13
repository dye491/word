<?php

use yii\db\Migration;

/**
 * Class m180605_104516_insert_data_into_template
 */
class m180605_104516_insert_data_into_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('template', [
            'id' => 1,
            'name' => 'Заявление',
            'file_name' => 'claim.docx',
            'form_class' => 'app\\models\\ClaimEditForm',
        ]);
        $this->insert('template', [
            'id' => 2,
            'name' => 'Список сотрудников',
            'file_name' => 'employees.docx',
            'form_class' => 'app\\models\\EmployeesEditForm',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('template');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180605_104516_insert_data_into_template cannot be reverted.\n";

        return false;
    }
    */
}
