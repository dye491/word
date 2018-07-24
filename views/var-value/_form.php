<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\VarValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="var-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--    --><? //= $form->field($model, 'company_id')->textInput() ?>

    <!--    --><? //= $form->field($model, 'var_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?/*= $form->field($model, 'start_date')->widget(DatePicker::class, [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'php:d.m.Y',
    ]) */?><!--

    --><?/*= $form->field($model, 'end_date')->widget(DatePicker::class, [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'php:d.m.Y',
    ]) */?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
