<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name . ': Переменные';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <?php
    Pjax::begin();
    echo GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '№',
                'options' => ['width' => '5%'],
            ],
            'var.name',
            'var.label',
            [
                'attribute' => 'value',
                'label' => 'Значение',
                'value' => function ($var) use ($model) {
                    return ($value = $var->var->getValue($model->id)) ? $value->value : null;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}',
                'controller' => 'var-value',
                'buttons' => [
                    'edit' => function ($url, $varModel, $key) use ($model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil">',
                            ['var-value/edit', 'company_id' => $model->id, 'var_id' => $varModel->var->id],
                            ['title' => 'Редактировать значение', 'aria-label' => 'Редактировать значение', 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>
