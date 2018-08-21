<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сферы деятельности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box branch-index">

    <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->
    <?php Pjax::begin(); ?>

    <p class="box-header">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'headerOptions' => ['style' => 'width: 7%;'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
