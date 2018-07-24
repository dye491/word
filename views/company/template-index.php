<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name . ': Шаблоны';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '№',
                'options' => ['width' => '5%'],
            ],
            'name',
        ],
    ]) ?>
    <?php Pjax::end() ?>
</div>
