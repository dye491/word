<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fio_rp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_rp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:d.m.Y',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:d.m.Y',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
