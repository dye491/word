<?php

use yii\db\Migration;

/**
 * Class m180821_111245_alter_template_table
 */
class m180821_111245_alter_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('template', 'branch_id', $this->integer());
        $this->addColumn('company', 'branch_id', $this->integer());

        $this->addForeignKey('fk_template_branch', 'template', 'branch_id', 'branch', 'id', 'CASCADE');
        $this->addForeignKey('fk_company_branch', 'company', 'branch_id', 'branch', 'id', 'CASCADE');

        $this->dropColumn('template', 'branch');
        $this->dropColumn('company', 'branch');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('template', 'branch', $this->string());
        $this->addColumn('company', 'branch', $this->string());

        $this->dropForeignKey('fk_template_branch', 'template');
        $this->dropForeignKey('fk_company_branch', 'company');

        $this->dropColumn('template', 'branch_id');
        $this->dropColumn('company', 'branch_id');
    }
}
