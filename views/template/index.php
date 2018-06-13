<?php
/* @var $this yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список шаблонов';

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
<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'class'   => 'yii\grid\SerialColumn',
            'header'  => '№',
            'options' => ['width' => '5%'],
        ],
        'name',
        [
            'class'      => 'yii\grid\ActionColumn',
            'template'   => '{update} {edit}',
            'options'    => ['width' => '10%'],
            'header'     => 'Действия',
            'buttons'    => [
                'edit' => function ($url, $model, $key) {
                    return Html::a(Html::tag('span', '', [
                        'class' => 'glyphicon glyphicon-wrench',
                    ]), $url, [
                        'title'      => 'Настройка шаблона',
                        'aria-label' => 'Настройка шаблона',
                        'data-pjax'  => '0',
                    ]);
                },
                'update' => function($url) {
                    return Html::a(Html::tag('span', '', [
                        'class' => 'glyphicon glyphicon-pencil',
                    ]), $url, [
                        'title'      => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax'  => '0',
                    ]);

                }
            ],
        ],
    ],
]) ?>
