<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $template app\models\Template|null */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
if ($template) {
    $this->title = $model->name . ', Шаблон: ' . $template->name . ': Переменные';
    $this->params['breadcrumbs'][] = ['label' => $model->name . ': Шаблоны', 'url' => ['template-index', 'id' => $model->id]];
} else {
    $this->title = $model->name . ': Переменные';
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <?php
    Pjax::begin(); ?>
    <div class="box-header">
        <?= Html::a('Редактировать', ['/var-value/edit', 'company_id' => $model->id],
            ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <?php echo GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            /*[
                'class' => 'yii\grid\SerialColumn',
                'header' => '№',
                'options' => ['width' => '5%'],
            ],*/
//            'var.name',
            'var.label:html:Переменная',
            /*[
                'attribute' => 'required',
                'value' => function ($model) {
                    return $model->required ? 'Да' : 'Нет';
                },
            ],*/
            [
//                'attribute' => 'value',
                'label' => 'Значение',
                'value' => function ($var) use ($model) {
                    return ($value = $var->var->getValue($model->id)) ? $value->value : null;
                },
                'contentOptions' => ['style' => 'width: 50%'],
            ],
            /*            [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{edit}',
                            'controller' => 'var-value',
                            'buttons' => [
                                'edit' => function ($url, $varModel, $key) use ($model) {
                                    if (!$varModel->var->group) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil">',
                                            ['var-value/edit', 'company_id' => $model->id, 'var_id' => $varModel->var->id],
                                            ['title' => 'Редактировать значение', 'aria-label' => 'Редактировать значение', 'data-pjax' => '0']);
                                    }

                                    return null;
                                },
                            ],
                        ],*/
        ],
    ]);
    Pjax::end();
    ?>
</div>
