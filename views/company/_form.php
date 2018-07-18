<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */
/* @var $profiles array */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employee_count')->textInput() ?>

    <?= $form->field($model, 'org_form')->dropDownList([
        'ip' => 'ИП',
        'ooo' => 'ООО',
    ]) ?>

    <?= $form->field($model, 'profile_id')->dropDownList($profiles) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>