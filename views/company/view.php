<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
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

</div>
