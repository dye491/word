<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $model \app\models\Template */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = "Настройка шаблона \"{$model->name}\"";
$this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => '/template'];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<h3>Переменные шаблона</h3>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'class' => \yii\grid\SerialColumn::class,
        ],
        'name',
        'label',
        'group',
        'type',
        [
            'class' => \yii\grid\ActionColumn::class,

        ],
    ],
]) ?>

<h3>Параметры шаблона</h3>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]) ?>
<?= $form->field($model, 'name', [
    'inputOptions' => [
        'class' => 'col-sm-10 col-xs-12',
    ],
    'labelOptions' => [
        'class' => 'control-label col-sm-2 col-xs-12',
    ],
]) ?>
<?= $form->field($model, 'file_name', [
    'inputOptions' => [
        'readonly' => true,
        'class'    => 'col-sm-10 col-xs-12',
    ],
    'labelOptions' => [
        'class' => 'control-label col-sm-2 col-xs-12',
    ],
]) ?>
<?= $form->field($model, 'templateFile', [
    'labelOptions' => [
        'class' => 'control-label col-sm-2 col-xs-12',
    ],
])->fileInput()->label('Загрузить шаблон') ?>
<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-success',
]) ?>
<span>&nbsp;</span>
<?= Html::a('Сохранить', '/template', [
    'class' => 'btn btn-default',
]) ?>
<?php ActiveForm::end() ?>
