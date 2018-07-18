<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m180718_173101_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->addColumn('company', 'profile_id', $this->integer());
        $this->addForeignKey('fk_company_profile', 'company', 'profile_id', 'profile', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'profile_id');
        $this->dropTable('profile');
    }
}
