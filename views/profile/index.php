<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
    <!--    --><?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Create Profile'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'options' => [
                    'width' => '5%',
                ],
            ],

//            'id',
            'name',
            [
                'label' => 'Кол-во шаблонов',
                'content' => function ($model) {
                    /* @var $model \app\models\Profile */
                    return Html::a($model->getProfileTemplates()->count(), ['/profile/view', 'id' => $model->id]);
                },
                'options' => ['width' => '15%'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => [
                    'width' => '10%',
                ],
//                'header' => Yii::t('app', 'Delete'),
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    <!--    --><?php //Pjax::end(); ?>
</div>
