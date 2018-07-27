<?php
/* @var $this yii\web\View */

/* @var $model \app\models\Document */

use yii\widgets\DetailView;
use yii\helpers\Html;

$this->title = 'Документ';
$this->params['breadcrumbs'][] = [
    'label' => $model->company->name . ': Шаблоны',
    'url' => ['company/template-index', 'id' => $model->company->id],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">
                <?php if (!$model->template->hasDocument($model->company, $model)): ?>
        <?= Html::a('Сформировать', ['document/make-doc', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'options' => ['class' => 'table detail-view'],
            'model' => $model,
            'attributes' => [
                'company.name:text:Организация',
                'template.name:text:Шаблон',
                'date',
                [
                    'attribute' => 'doc_path',
                    'label' => Yii::t('app', 'Doc Path'),
                    'value' => function ($model) {
                        return $model->doc_path ? Html::a($model->doc_path, ['download', 'id' => $model->id])
                            : '<span class="not-set">(не задано)</span>';
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'pdf_path',
                    'value' => function ($model) {
                        return $model->pdf_path ? Html::a($model->pdf_path, ['download-pdf', 'id' => $model->id])
                            : '<span class="not-set">(не задано)</span>';
                    },
                    'format' => 'html',
                ],
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

