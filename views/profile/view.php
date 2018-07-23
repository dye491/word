<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name . ': доступные шаблоны';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">


    <!--<p>
        <?/*= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?>
        <?/*= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */?>
    </p>-->

<!--    --><?/*= DetailView::widget([
        'options' => ['class' => 'table detail-view'],
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) */?>

<!--    <h2>Доступные шаблоны</h2>-->
    <?php Pjax::begin() ?>
    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Add Template'),
            ['/profile-template/create', 'profile_id' => $model->id],
            ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '№',
                'options' => ['width' => '5%'],
            ],
            'template.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => [
                    'width' => '10%',
                ],
                'header' => 'Действия',
                'template' => '{delete}',
                'controller' => 'profile-template',
            ],
        ],
    ]) ?>
    <?php Pjax::end() ?>

</div>
