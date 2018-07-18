<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile_template`.
 */
class m180718_193056_create_profile_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('profile_template', [
            'profile_id' => $this->integer(),
            'template_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_profile_template', 'profile_template', ['profile_id', 'template_id']);
        $this->addForeignKey('fk_profile_template_profile', 'profile_template', 'profile_id', 'profile', 'id');
        $this->addForeignKey('fk_profile_template_template', 'profile_template', 'template_id', 'template', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('profile_template');
    }
}
