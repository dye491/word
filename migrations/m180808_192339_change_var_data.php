<?php

use yii\db\Migration;

/**
 * Class m180808_192339_change_var_data
 */
class m180808_192339_change_var_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('variable', ['name' => 'OKVED', 'group' => 'okved'], ['name' => 'OKVED1']);
        $this->update('variable', ['name' => 'company_member_name_ip', 'group' => 'employee'], ['name' => 'company_member_name_ip_1']);
        $this->update('variable', ['name' => 'company_member_name_rp', 'group' => 'employee'], ['name' => 'company_member_name_rp_1']);
        $this->update('variable', ['name' => 'company_member_post_ip', 'group' => 'employee'], ['name' => 'company_member_post_ip_1']);
        $this->update('variable', ['name' => 'company_member_post_rp', 'group' => 'employee'], ['name' => 'company_member_post_rp_1']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update('variable', ['name' => 'OKVED1', 'group' => null], ['name' => 'OKVED']);
        $this->update('variable', ['name' => 'company_member_name_ip_1', 'group' => null], ['name' => 'company_member_name_ip']);
        $this->update('variable', ['name' => 'company_member_name_rp_1', 'group' => null], ['name' => 'company_member_name_rp']);
        $this->update('variable', ['name' => 'company_member_post_ip_1', 'group' => null], ['name' => 'company_member_post_ip']);
        $this->update('variable', ['name' => 'company_member_post_rp_1', 'group' => null], ['name' => 'company_member_post_rp']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180808_192339_change_var_data cannot be reverted.\n";

        return false;
    }
    */
}
