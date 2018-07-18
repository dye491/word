<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Variable */
/* @var $template app\models\Template */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="variable-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'labelOptions' => [
                'class' => 'control-label col-sm-2 col-xs-12',
            ],
            'inputOptions' => [
                'class' => 'col-sm-10 col-xs-12',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['string' => 'строка', 'number' => 'число']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отменить', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
