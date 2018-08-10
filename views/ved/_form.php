<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ved */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body ved-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::class, [
        'options' => ['class' => 'form-control', 'placeholder' => 'дд.мм.гггг'],
        'dateFormat' => 'php:d.m.Y',
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::class, [
        'options' => ['class' => 'form-control', 'placeholder' => 'дд.мм.гггг'],
        'dateFormat' => 'php:d.m.Y',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
