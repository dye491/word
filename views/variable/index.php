<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VariableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список переменных';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?php Pjax::begin(); ?>
    <!--    --><?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header">
        <?= Html::a('Новая переменная ', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{summary}{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterPosition'=>GridView::FILTER_POS_HEADER,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'label',
//            'group',
            [

                'attribute' => 'type',
                'value' => function ($model) {
                    switch ($model->type) {
                        case 'string':
                            return 'Строка';
                        case 'number':
                            return 'Число';
                        default:
                            return null;
                    }
                },
                'filter' => [
                    'string' => 'Строка',
                    'number' => 'Число',
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => 'Действия',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
