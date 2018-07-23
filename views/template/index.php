<?php
/* @var $this yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список шаблонов';
$this->params['breadcrumbs'][] = $this->title;

function urlCreator($action, $model, $key, $index, \yii\grid\ActionColumn $column)
{
    switch ($action) {
        case 'edit':
            return '/template/edit?id=' . $model->id;
        default:
            return $column->createUrl($action, $model, $key, $index);
    }
}

?>
<div class="box">
    <div class="box-header">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?= GridView::widget([
//    'caption'      => Html::a('Добавить', '/template/create', ['class' => 'btn btn-primary']),
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '№',
                'options' => ['width' => '5%'],
            ],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
//                    'template' => '{update} {edit} {download} {download-pdf}',
                'template' => '{edit}',
//                    'options' => ['width' => '10%'],
                'headerOptions' => [
                    'style' => 'width: 5%;',
                ],
//                    'header' => 'Действия',
                'buttons' => [
                    'edit' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'glyphicon glyphicon-wrench',
                        ]), $url, [
                            'title' => 'Настройка шаблона',
                            'aria-label' => 'Настройка шаблона',
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'glyphicon glyphicon-pencil',
                        ]), $url, [
                            'title' => 'Редактировать значения переменных',
                            'aria-label' => 'Редактировать значения переменных',
                            'data-pjax' => '0',
                        ]);

                    },
                    'download' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'glyphicon glyphicon-download-alt',
                        ]), $url, [
                            'title' => 'Загрузить документ (.docx)',
                            'aria-label' => 'Загрузить документ (.docx)',
                            'data-pjax' => '0',
                        ]);
                    },
                    'download-pdf' => function ($url) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'glyphicon glyphicon-text-color',
                        ]), $url, [
                            'title' => 'Загрузить документ (.pdf)',
                            'aria-label' => 'Загрузить документ (.pdf)',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'update' => true,
                    'edit' => true,
                    'download' => function ($model) {
                        return $model->hasDocument();
                    },
                    'download-pdf' => function ($model) {
                        return $model->hasPdf();
                    },
                ],
            ],
        ],
    ]) ?>
</div>