<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-header">
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Изменить', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary pull-right',
            'style' => 'margin-right: 15px;',
        ]) ?>
    </div>

    <div class="box-body">
        <?= DetailView::widget([
            'options' => ['class' => 'table detail-view'],
            'model' => $model,
            'attributes' => [
//            'id',
//            'name',
                'employee_count',
                [
                    'attribute' => 'org_form',
                    'value' => function ($model) {
                        switch ($model->org_form) {
                            case 'ip':
                                return 'ИП';
                            case 'ooo':
                                return 'ООО';
                            default:
                                return null;
                        }
                    },
                ],
                [
                    'attribute' => 'profile_id',
                    'value' => function ($model) {
                        return isset($model->profile) ? $model->profile->name : null;
                    },
                ],
            ],
        ]) ?>

        <h3>Шаблоны</h3>
        <?php Pjax::begin() ?>
        <!--<p>
        <? /*= Html::a(Yii::t('app', 'Create Profile Template'),
            ['/profile-template/create', 'profile_id' => $model->profile_id],
            ['class' => 'btn btn-success']) */ ?>
    </p>-->
        <?= GridView::widget([
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
</div>
