<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateVar */

$this->title = $model->var_id;
$this->params['breadcrumbs'][] = ['label' => 'Template Vars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-var-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'var_id' => $model->var_id, 'template_id' => $model->template_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'var_id' => $model->var_id, 'template_id' => $model->template_id], [
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
            'var_id',
            'template_id',
            'required',
            'start_date',
            'end_date',
        ],
    ]) ?>

</div>
