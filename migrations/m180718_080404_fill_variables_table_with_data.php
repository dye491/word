<?php

use yii\db\Migration;

/**
 * Class m180718_080404_fill_variables_table_with_data
 */
class m180718_080404_fill_variables_table_with_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('variable', [
            'label',
            'name',
            'type',
        ], [
            ['Контактное лицо', 'contact_name', 'string'],
            ['Телефон', 'telefon', 'string'],
            ['эл. почта', 'e-mail', 'string'],
            ['Должность руководителя', 'post_chief', 'string'],
            ['Форма собственности', 'form_org', 'string'],
            ['Наименование организации', 'Company_name', 'string'],
            ['ФИО руководителя', 'FIO_chief', 'string'],
            ['Юр.адрес', 'Ur_address', 'string'],
            ['ИНН', 'INN', 'string'],
            ['Перечень должностей', 'list_of_post', 'string'],
            ['Перечень должностей, целевой инструктаж', 'list_tsi', 'string'],
            ['Место хранение документов', 'Bis_address', 'string'],
            ['ОКВЭД1', 'OKVED1', 'string'],
            ['ОКВЭД2', 'OKVED2', 'string'],
            ['ОКВЭД3', 'OKVED3', 'string'],
            ['ОКВЭД4', 'OKVED4', 'string'],
            ['ОКВЭД5', 'OKVED5', 'string'],
            ['ОКВЭД6', 'OKVED6', 'string'],
            ['ОКВЭД7', 'OKVED7', 'string'],
            ['ОКВЭД8', 'OKVED8', 'string'],
            ['ОКВЭД9', 'OKVED9', 'string'],
            ['ОКВЭД10', 'OKVED10', 'string'],
            ['ОКВЭД11', 'OKVED11', 'string'],
            ['ОКВЭД12', 'OKVED12', 'string'],
            ['ОКВЭД13', 'OKVED13', 'string'],
            ['ОКВЭД14', 'OKVED14', 'string'],
            ['ОКВЭД15', 'OKVED15', 'string'],
            ['ОКВЭД16', 'OKVED16', 'string'],
            ['ФИО руководителя в им. п.', 'fio_director_ip', 'string'],
            ['ФИО руководителя в р. п.', 'fio_director_rp', 'string'],
            ['ФИО руководителя в в. п.', 'fio_director_vp', 'string'],
            ['ФИО руководителя в д. п.', 'fio_director_dp', 'string'],
            ['ФИО руководителя в т. п.', 'fio_director_tp', 'string'],
            ['Должность руководителя им. п.', 'director_post_ip', 'string'],
            ['Должность руководителя р. п.', 'director_post_rp', 'string'],
            ['Должность руководителя д. п.', 'director_post_dp', 'string'],
            ['Должность руководителя в. п.', 'director_post_vp', 'string'],
            ['Должность руководителя т. п.', 'director_post_tp', 'string'],
            ['ФИО_СДЛ им. п.', 'fio_sdl_ip', 'string'],
            ['ФИО_СДЛ р. п.', 'fio_sdl_rp', 'string'],
            ['ФИО_СДЛ в. п.', 'fio_sdl_vp', 'string'],
            ['ФИО_СДЛ д. п.', 'fio_sdl_dp', 'string'],
            ['ФИО_СДЛ т. п.', 'fio_sdl_tp', 'string'],
            ['Должность СДЛ в именительном падеже', 'post_sdl_ip', 'string'],
            ['Должность СДЛ в винительном падеже', 'post_sdl_vp', 'string'],
            ['Фамилия И. О. сотрудника 1 в именительном падеже', 'company_member_name_ip_1', 'string'],
            ['Фамилия И. О. сотрудника 1 в родительном падеже', 'company_member_name_rp_1', 'string'],
            ['Должность сотрудника 1 в именительном падеже', 'company_member_post_ip_1', 'string'],
            ['Должность сотрудника 1 в родительном падеже', 'company_member_post_rp_1', 'string'],

            ['Фамилия И. О. сотрудника 2 в именительном падеже', 'company_member_name_ip_2', 'string'],
            ['Фамилия И. О. сотрудника 2 в родительном падеже', 'company_member_name_rp_2', 'string'],
            ['Должность сотрудника 2 в именительном падеже', 'company_member_post_ip_2', 'string'],
            ['Должность сотрудника 2 в родительном падеже', 'company_member_post_rp_2', 'string'],

            ['Фамилия И. О. сотрудника 3 в именительном падеже', 'company_member_name_ip_3', 'string'],
            ['Фамилия И. О. сотрудника 3 в родительном падеже', 'company_member_name_rp_3', 'string'],
            ['Должность сотрудника 3 в именительном падеже', 'company_member_post_ip_3', 'string'],
            ['Должность сотрудника 3 в родительном падеже', 'company_member_post_rp_3', 'string'],

            ['Фамилия И. О. сотрудника 4 в именительном падеже', 'company_member_name_ip_4', 'string'],
            ['Фамилия И. О. сотрудника 4 в родительном падеже', 'company_member_name_rp_4', 'string'],
            ['Должность сотрудника 4 в именительном падеже', 'company_member_post_ip_4', 'string'],
            ['Должность сотрудника 4 в родительном падеже', 'company_member_post_rp_4', 'string'],

            ['Фамилия И. О. сотрудника 5 в именительном падеже', 'company_member_name_ip_5', 'string'],
            ['Фамилия И. О. сотрудника 5 в родительном падеже', 'company_member_name_rp_5', 'string'],
            ['Должность сотрудника 5 в именительном падеже', 'company_member_post_ip_5', 'string'],
            ['Должность сотрудника 5 в родительном падеже', 'company_member_post_rp_5', 'string'],

            ['Фамилия И. О. сотрудника 6 в именительном падеже', 'company_member_name_ip_6', 'string'],
            ['Фамилия И. О. сотрудника 6 в родительном падеже', 'company_member_name_rp_6', 'string'],
            ['Должность сотрудника 6 в именительном падеже', 'company_member_post_ip_6', 'string'],
            ['Должность сотрудника 6 в родительном падеже', 'company_member_post_rp_6', 'string'],

            ['Фамилия И. О. сотрудника 7 в именительном падеже', 'company_member_name_ip_7', 'string'],
            ['Фамилия И. О. сотрудника 7 в родительном падеже', 'company_member_name_rp_7', 'string'],
            ['Должность сотрудника 7 в именительном падеже', 'company_member_post_ip_7', 'string'],
            ['Должность сотрудника 7 в родительном падеже', 'company_member_post_rp_7', 'string'],

            ['Фамилия И. О. сотрудника 8 в именительном падеже', 'company_member_name_ip_8', 'string'],
            ['Фамилия И. О. сотрудника 8 в родительном падеже', 'company_member_name_rp_8', 'string'],
            ['Должность сотрудника 8 в именительном падеже', 'company_member_post_ip_8', 'string'],
            ['Должность сотрудника 8 в родительном падеже', 'company_member_post_rp_8', 'string'],

            ['Фамилия И. О. сотрудника 9 в именительном падеже', 'company_member_name_ip_9', 'string'],
            ['Фамилия И. О. сотрудника 9 в родительном падеже', 'company_member_name_rp_9', 'string'],
            ['Должность сотрудника 9 в именительном падеже', 'company_member_post_ip_9', 'string'],
            ['Должность сотрудника 9 в родительном падеже', 'company_member_post_rp_9', 'string'],

            ['Фамилия И. О. сотрудника 10 в именительном падеже', 'company_member_name_ip_10', 'string'],
            ['Фамилия И. О. сотрудника 10 в родительном падеже', 'company_member_name_rp_10', 'string'],
            ['Должность сотрудника 10 в именительном падеже', 'company_member_post_ip_10', 'string'],
            ['Должность сотрудника 10 в родительном падеже', 'company_member_post_rp_10', 'string'],

            ['Фамилия И. О. сотрудника 11 в именительном падеже', 'company_member_name_ip_11', 'string'],
            ['Фамилия И. О. сотрудника 11 в родительном падеже', 'company_member_name_rp_11', 'string'],
            ['Должность сотрудника 11 в именительном падеже', 'company_member_post_ip_11', 'string'],
            ['Должность сотрудника 11 в родительном падеже', 'company_member_post_rp_11', 'string'],

            ['Фамилия И. О. сотрудника 12 в именительном падеже', 'company_member_name_ip_12', 'string'],
            ['Фамилия И. О. сотрудника 12 в родительном падеже', 'company_member_name_rp_12', 'string'],
            ['Должность сотрудника 12 в именительном падеже', 'company_member_post_ip_12', 'string'],
            ['Должность сотрудника 12 в родительном падеже', 'company_member_post_rp_12', 'string'],

            ['Фамилия И. О. сотрудника 13 в именительном падеже', 'company_member_name_ip_13', 'string'],
            ['Фамилия И. О. сотрудника 13 в родительном падеже', 'company_member_name_rp_13', 'string'],
            ['Должность сотрудника 13 в именительном падеже', 'company_member_post_ip_13', 'string'],
            ['Должность сотрудника 13 в родительном падеже', 'company_member_post_rp_13', 'string'],

            ['Фамилия И. О. сотрудника 14 в именительном падеже', 'company_member_name_ip_14', 'string'],
            ['Фамилия И. О. сотрудника 14 в родительном падеже', 'company_member_name_rp_14', 'string'],
            ['Должность сотрудника 14 в именительном падеже', 'company_member_post_ip_14', 'string'],
            ['Должность сотрудника 14 в родительном падеже', 'company_member_post_rp_14', 'string'],

            ['Фамилия И. О. сотрудника 15 в именительном падеже', 'company_member_name_ip_15', 'string'],
            ['Фамилия И. О. сотрудника 15 в родительном падеже', 'company_member_name_rp_15', 'string'],
            ['Должность сотрудника 15 в именительном падеже', 'company_member_post_ip_15', 'string'],
            ['Должность сотрудника 15 в родительном падеже', 'company_member_post_rp_15', 'string'],

            ['Фамилия И. О. сотрудника 16 в именительном падеже', 'company_member_name_ip_16', 'string'],
            ['Фамилия И. О. сотрудника 16 в родительном падеже', 'company_member_name_rp_16', 'string'],
            ['Должность сотрудника 16 в именительном падеже', 'company_member_post_ip_16', 'string'],
            ['Должность сотрудника 16 в родительном падеже', 'company_member_post_rp_16', 'string'],

            ['Фамилия И. О. сотрудника 17 в именительном падеже', 'company_member_name_ip_17', 'string'],
            ['Фамилия И. О. сотрудника 17 в родительном падеже', 'company_member_name_rp_17', 'string'],
            ['Должность сотрудника 17 в именительном падеже', 'company_member_post_ip_17', 'string'],
            ['Должность сотрудника 17 в родительном падеже', 'company_member_post_rp_17', 'string'],

            ['Фамилия И. О. сотрудника 18 в именительном падеже', 'company_member_name_ip_18', 'string'],
            ['Фамилия И. О. сотрудника 18 в родительном падеже', 'company_member_name_rp_18', 'string'],
            ['Должность сотрудника 18 в именительном падеже', 'company_member_post_ip_18', 'string'],
            ['Должность сотрудника 18 в родительном падеже', 'company_member_post_rp_18', 'string'],

            ['Фамилия И. О. сотрудника 19 в именительном падеже', 'company_member_name_ip_19', 'string'],
            ['Фамилия И. О. сотрудника 19 в родительном падеже', 'company_member_name_rp_19', 'string'],
            ['Должность сотрудника 19 в именительном падеже', 'company_member_post_ip_19', 'string'],
            ['Должность сотрудника 19 в родительном падеже', 'company_member_post_rp_19', 'string'],

            ['Фамилия И. О. сотрудника 20 в именительном падеже', 'company_member_name_ip_20', 'string'],
            ['Фамилия И. О. сотрудника 20 в родительном падеже', 'company_member_name_rp_20', 'string'],
            ['Должность сотрудника 20 в именительном падеже', 'company_member_post_ip_20', 'string'],
            ['Должность сотрудника 20 в родительном падеже', 'company_member_post_rp_20', 'string'],

            ['Фамилия И. О. сотрудника 21 в именительном падеже', 'company_member_name_ip_21', 'string'],
            ['Фамилия И. О. сотрудника 21 в родительном падеже', 'company_member_name_rp_21', 'string'],
            ['Должность сотрудника 21 в именительном падеже', 'company_member_post_ip_21', 'string'],
            ['Должность сотрудника 21 в родительном падеже', 'company_member_post_rp_21', 'string'],

            ['Фамилия И. О. сотрудника 22 в именительном падеже', 'company_member_name_ip_22', 'string'],
            ['Фамилия И. О. сотрудника 22 в родительном падеже', 'company_member_name_rp_22', 'string'],
            ['Должность сотрудника 22 в именительном падеже', 'company_member_post_ip_22', 'string'],
            ['Должность сотрудника 221 в родительном падеже', 'company_member_post_rp_22', 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('set foreign_key_checks=0');
        $this->delete('variable');
        $this->execute('set foreign_key_checks=1');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180718_080404_fill_variables_table_with_data cannot be reverted.\n";

        return false;
    }
    */
}
