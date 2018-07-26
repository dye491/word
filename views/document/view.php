<?php
/* @var $this yii\web\View */
/* @var $model \app\models\Document */

use yii\widgets\DetailView;

$this->title = 'Документ';
$this->params['breadcrumbs'][] = [
    'label' => $model->company->name . ': Шаблоны',
    'url' => ['company/template-index', 'id' => $model->company->id],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'options' => ['class' => 'table detail-view'],
            'model' => $model,
            'attributes' => [
                'company.name:text:Организация',
                'template.name:text:Шаблон',
                'date',
                'doc_path',
                'pdf_path',
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        $arr = ['new' => 'Новый', 'ready' => 'Подготовлен', 'sent' => 'Отправлен'];
                        return isset($arr[$model->status]) ? $arr[$model->status] : null;
                    },
                ],
                'sent_at',
            ],
        ]) ?>
    </div>
</div>

