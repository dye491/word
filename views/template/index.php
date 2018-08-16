<?php
/* @var $this yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $parent_parent_id integer|null */

/* @var $path array */

use yii\helpers\Html;
use yii\grid\GridView;

if ($path) {
    $this->title = $path[count($path) - 1]['name'];
    $this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => ['index']];
    for ($i = 0; $i < count($path) - 1; $i++) {
        $this->params['breadcrumbs'][] = ['label' => $path[$i]['name'],
            'url' => ['index', 'parent_id' => $path[$i]['parent_id']]];
    }
} else {
    $this->title = 'Список шаблонов';
}
$this->params['breadcrumbs'][] = $this->title;

/*function urlCreator($action, $model, $key, $index, \yii\grid\ActionColumn $column)
{
    switch ($action) {
        case 'edit':
            return '/template/edit?id=' . $model->id;
        default:
            return $column->createUrl($action, $model, $key, $index);
    }
}*/

?>
<div class="box">
    <?php \yii\widgets\Pjax::begin() ?>
    <div class="box-header">
        <?php if (Yii::$app->request->get('parent_id')): ?>
            <?= Html::a('<span class="glyphicon glyphicon-level-up"></span>',
                ['index', 'parent_id' => $parent_parent_id ?: null],
                ['class' => 'btn btn-primary', 'title' => 'Наверх', 'aria-label' => 'Наверх', 'data-pjax' => 0]) ?>
        <?php endif; ?>
        <?= Html::a('Добавить', [
            'create',
            'parent_id' => isset(Yii::$app->request->queryParams['parent_id'])
                ? Yii::$app->request->queryParams['parent_id']
                : null,
        ],
            ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?= GridView::widget([//    'caption'      => Html::a('Добавить', '/template/create', ['class' => 'btn btn-primary']),
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [['class' => 'yii\grid\SerialColumn',
            'header' => '№',
            'options' => ['width' => '5%'],],
            ['attribute' => 'name',
                'content' => function ($model) {
                    if ($model->is_dir) {
                        return Html::a('<span class="glyphicon glyphicon-folder-open"> ' . $model->name . '</span>',
                            ['index', 'parent_id' => $model->id], ['data-pjax' => 0]);
                    }

                    return $model->name;

                },],
            ['attribute' => 'file_name',
                'content' => function ($model) {
                    return $model->file_name ?
                        Html::a($model->file_name, "/template/download?id={$model->id}&template=yes", ['data-pjax' => 0])
                        : null;
                },],
            'start_date:text:Начало действия',
            'end_date:text:Начало действия',
            ['class' => 'yii\grid\ActionColumn',
                //                    'template' => '{update} {edit} {download} {download-pdf}',
                'template' => '{edit}',
                //                    'options' => ['width' => '10%'],
                'headerOptions' => ['style' => 'width: 5%;',],
                //                    'header' => 'Действия',
                'buttons' => ['edit' => function ($url, $model, $key) {
                    return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-wrench',]), $url, ['title' => 'Настройка шаблона',
                        'aria-label' => 'Настройка шаблона',
                        'data-pjax' => '0',]);
                },
                    'update' => function ($url) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil',]), $url, ['title' => 'Редактировать значения переменных',
                            'aria-label' => 'Редактировать значения переменных',
                            'data-pjax' => '0',]);

                    },
                    'download' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-download-alt',]), $url, ['title' => 'Загрузить документ (.docx)',
                            'aria-label' => 'Загрузить документ (.docx)',
                            'data-pjax' => '0',]);
                    },
                    'download-pdf' => function ($url) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-text-color',]), $url, ['title' => 'Загрузить документ (.pdf)',
                            'aria-label' => 'Загрузить документ (.pdf)',
                            'data-pjax' => '0',]);
                    },],
                'visibleButtons' => ['update' => true,
                    'edit' => true,
                    'download' => function ($model) {
                        return $model->hasDocument();
                    },
                    'download-pdf' => function ($model) {
                        return $model->hasPdf();
                    },],],],]) ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>