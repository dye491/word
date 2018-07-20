<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateVar */
/* @var $form yii\widgets\ActiveForm */
/* @var $varList array */
?>

<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->controller->action->id == 'create')
        echo $form->field($model, 'var_id')->dropDownList($varList)->label('Переменная')
    ?>

    <!--    --><? //= $form->field($model, 'template_id')->textInput() ?>

    <?= $form->field($model, 'required')->checkbox() ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'php:d.m.Y',
        /*        'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true
                ],*/
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(DatePicker::class, [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'php:d.m.Y',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['/template/edit', 'id' => $model->template_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
