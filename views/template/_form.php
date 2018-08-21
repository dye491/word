<?php
/* @var $this \yii\web\View */

/* @var $model \app\models\Template */
/* @var $branches array */

/* @var $events array */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\assets\TemplateEditAsset;

TemplateEditAsset::register($this);
?>
<div class="box-body">
    <?php $form = ActiveForm::begin(['options' => [/*'class' => 'form-horizontal'*/]]) ?>
    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:d.m.Y',
        'options' => ['class' => 'form-control'],
    ]) ?>
    <?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:d.m.Y',
        'options' => ['class' => 'form-control'],
    ]) ?>
    <?= $form->field($model, 'short_name') ?>
    <?= $form->field($model, 'name', ['inputOptions' => ['readonly' => 1, 'class' => 'form-control']]) ?>
    <?= $form->field($model, 'branch_id')->dropDownList(array_merge([null => ''], $branches)) ?>
    <?= $form->field($model, 'org_form')->dropDownList([null => '', 'ooo' => 'ООО', 'ip' => 'ИП']) ?>
    <?= $form->field($model, 'emp_count')->dropDownList([null => '', 1 => '1 сотр.', 2 => '>1 сотр.']) ?>
    <?= $form->field($model, 'is_new')->dropDownList([null => '', 1 => 'Новый', 0 => 'Действующий']) ?>
    <?= $form->field($model, 'event_id')->widget(\kartik\select2\Select2::class, [
        'data' => array_merge([null => 'нет'], $events),
    ]) ?>

    <!--<div class="form-group well">
    <? /*= Html::label('Файл шаблона', null, []) */ ?>
    <p class="form-control-static">
        <? /*= $model->file_name ?
            Html::a($model->file_name, "/template/download?id={$model->id}&template=yes")
            : '---' */ ?>
    </p>
</div>-->
    <?= $form->field($model, 'file_name', ['inputOptions' => ['readonly' => 1, 'class' => 'form-control']]) ?>
    <?= $form->field($model, 'templateFile', [])->fileInput()->label('Загрузить шаблон') ?>
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
    ]) ?>
    <span>&nbsp;</span>
    <?= Html::a('Отменить', \yii\helpers\Url::previous()/*'/template'*/, [
        'class' => 'btn btn-default',
    ]) ?>
    <?php ActiveForm::end() ?>
</div>