<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 15.08.18
 * Time: 12:20
 */

namespace app\models;


use yii\base\Model;

class CurrentDateForm extends Model
{
    public $curDate;

    public function rules()
    {
        return [
            ['curDate', 'date', 'format' => 'php:d.m.Y'],
        ];
    }
}