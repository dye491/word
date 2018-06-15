<?php
/* @var $this \yii\web\View */

/* @var $model \app\models\Template */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]) ?>
<?= $form->field($model, 'name', [
    'inputOptions' => [
        'class' => 'col-sm-10 col-xs-12',
    ],
    'labelOptions' => [
        'class' => 'control-label col-sm-2 col-xs-12',
    ],
]) ?>
<div class="form-group">
    <?= Html::label('Файл шаблона', null, [
        'class' => 'control-label col-sm-2 col-xs-12',
    ]) ?>
    <div class="col-sm-10 col-xs-12">
        <p class="form-control-static">
            <?= $model->file_name ?
                Html::a($model->file_name, "/template/download?id={$model->id}&template=yes")
                : '---' ?>
        </p>
    </div>
</div>
<?= $form->field($model, 'templateFile', [
    'labelOptions' => [
        'class' => 'control-label col-sm-2 col-xs-12',
    ],
])->fileInput()->label('Загрузить шаблон') ?>
<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-success',
]) ?>
<span>&nbsp;</span>
<?= Html::a('Отменить', '/template', [
    'class' => 'btn btn-default',
]) ?>
<?php ActiveForm::end() ?>
