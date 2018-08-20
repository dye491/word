<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $model \app\models\Template */

/* @var $undefinedVars string */

/* @var $events array */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = "Настройка шаблона \"{$model->name}\"";
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<ul class="nav nav-tabs">
    <li role="presentation" class=""><a href="#template-params">Параметры</a></li>
    <li role="presentation"><a href="#template-vars">Переменные </a></li>
</ul>-->
<div id="template-params" class="box">
    <div class="box-header">
        <h3>Параметры шаблона</h3>
    </div>
    <div class="box-body">

        <?= $this->render('_form', ['model' => $model, 'events' => $events]) ?>
    </div>
</div>

<div id="template-vars" class="box">
    <div class="box-header">
        <span class="h3">Переменные шаблона</span>
        <?= Html::a('Добавить', ['template-var/create', 'template_id' => $model->id],
            ['class' => 'btn btn-success pull-right']) ?>
        <?php if ($undefinedVars): ?>
            <p class="bg-warning" style="margin-top: 16px; margin-bottom: 0;">
                Внимание! Не определены следующие переменные шаблона: <?= $undefinedVars ?>
            </p>
        <?php endif; ?>
    </div>

    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => \yii\grid\SerialColumn::class,
            ],
            'var.name',
            'var.label',
            'var.group',
            [
                'attribute' => 'start_date',
                'value' => function ($model) {
                    return $model->start_date ?
                        Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') :
                        $model->start_date;
                },
            ],
            [
                'attribute' => 'end_date',
                'value' => function ($model) {
                    return $model->end_date ?
                        Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') :
                        $model->end_date;
                },
            ],
            [
                'attribute' => 'type',
                'label' => 'Тип',
                'value' => function ($model) {
                    return $model->var->type === 'string' ? 'строка' : $model;
                },
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'controller' => 'template-var',
                'template' => '{update} {delete}',
                'header' => 'Действия',
                'options' => ['width' => '10%'],
            ],
        ],
    ]) ?>
</div>
