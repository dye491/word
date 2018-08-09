<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $company \app\models\Company */

$this->title = $company->name . ': ' . Yii::t('app', 'Kinds of activity');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?php Pjax::begin(); ?>

    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Create kind of activity'), ['create', 'company_id' => $company->id],
            ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            'text',
            'start_date',
            'end_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
