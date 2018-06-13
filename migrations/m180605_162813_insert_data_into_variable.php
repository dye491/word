<?php

use yii\db\Migration;

/**
 * Class m180605_162813_insert_data_into_variable
 */
class m180605_162813_insert_data_into_variable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('variable', [
            'name',
            'label',
            'template_id',
            'group',
            'type',
        ],
            [
                [
                    'surname',
                    'Фамилия',
                    1,
                    null,
                    'string',
                ],
                [
                    'first_name',
                    'Имя',
                    '1',
                    null,
                    'string',
                ],
                [
                    'patronymic',
                    'Отчество',
                    1,
                    null,
                    'string',
                ],
                [
                    'position',
                    'Должность',
                    1,
                    null,
                    'string',
                ],
                [
                    'surname',
                    'Фамилия',
                    2,
                    'ФИО',
                    'string',
                ],
                [
                    'first_name',
                    'Имя',
                    2,
                    'ФИО',
                    'string',
                ],
                [
                    'patronymic',
                    'Отчество',
                    2,
                    'ФИО',
                    'string',
                ],
                [
                    'position',
                    'Должность',
                    2,
                    'ФИО',
                    'string',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('variable');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180605_162813_insert_data_into_variable cannot be reverted.\n";

        return false;
    }
    */
}
