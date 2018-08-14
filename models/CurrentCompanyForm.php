<?php

namespace app\models;

use yii\base\Model;

class CurrentCompanyForm extends Model
{
    public $company_id;

    public function rules()
    {
        return [
            ['company_id', 'required'],
            ['company_id', 'integer'],
            ['company_id', 'exist', 'targetAttribute' => 'id', 'targetClass' => Company::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'company_id' => 'Организация',
        ];
    }
}