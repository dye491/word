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
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-primary']) ?>
</p>

<?= GridView::widget([
//    'caption'      => Html::a('Добавить', '/template/create', ['class' => 'btn btn-primary']),
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'class'   => 'yii\grid\SerialColumn',
            'header'  => '№',
            'options' => ['width' => '5%'],
        ],
        'name',
        [
            'class'          => 'yii\grid\ActionColumn',
            'template'       => '{update} {edit} {download}',
            'options'        => ['width' => '10%'],
            'header'         => 'Действия',
            'buttons'        => [
                'edit'     => function ($url, $model, $key) {
                    return Html::a(Html::tag('span', '', [
                        'class' => 'glyphicon glyphicon-wrench',
                    ]), $url, [
                        'title'      => 'Настройка шаблона',
                        'aria-label' => 'Настройка шаблона',
                        'data-pjax'  => '0',
                    ]);
                },
                'update'   => function ($url) {
                    return Html::a(Html::tag('span', '', [
                        'class' => 'glyphicon glyphicon-pencil',
                    ]), $url, [
                        'title'      => 'Редактировать значения переменных',
                        'aria-label' => 'Редактировать значения переменных',
                        'data-pjax'  => '0',
                    ]);

                },
                'download' => function ($url, $model, $key) {
                    return Html::a(Html::tag('span', '', [
                        'class' => 'glyphicon glyphicon-download-alt',
                    ]), $url, [
                        'title'      => 'Загрузить документ',
                        'aria-label' => 'Загрузить документ',
                        'data-pjax'  => '0',
                    ]);
                },
            ],
            'visibleButtons' => [
                'update'   => true,
                'edit'     => true,
                'download' => function ($model) {
                    return $model->hasDocument();
                },
            ],
        ],
    ],
]) ?>
