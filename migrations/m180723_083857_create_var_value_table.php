<?php

use yii\db\Migration;

/**
 * Class m180723_083857_create
 */
class m180723_083857_create_var_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('var_value', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'var_id' => $this->integer(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'value' => $this->string(),
        ]);

        $this->createIndex('company_var_start_date_unique', 'var_value', [
            'company_id', 'var_id', 'start_date',
        ], true);
        $this->addForeignKey('fk_var_value_company', 'var_value', 'company_id', 'company', 'id');
        $this->addForeignKey('fk_var_value_var', 'var_value', 'var_id', 'variable', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('var_value');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180723_083857_create cannot be reverted.\n";

        return false;
    }
    */
}
