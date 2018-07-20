<?php
/* @var $this \yii\web\View */

/* @var $model \app\models\Template */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['options' => [/*'class' => 'form-horizontal'*/]]) ?>
<?= $form->field($model, 'name', []) ?>
<div class="form-group">
    <?= Html::label('Файл шаблона', null, []) ?>
    <div class="">
        <p class="form-control-static">
            <?= $model->file_name ?
                Html::a($model->file_name, "/template/download?id={$model->id}&template=yes")
                : '---' ?>
        </p>
    </div>
</div>
<?= $form->field($model, 'templateFile', [])->fileInput()->label('Загрузить шаблон') ?>
<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-success',
]) ?>
<span>&nbsp;</span>
<?= Html::a('Отменить', '/template', [
    'class' => 'btn btn-default',
]) ?>
<?php ActiveForm::end() ?>
