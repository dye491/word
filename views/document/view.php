<?php
/* @var $this yii\web\View */

/* @var $model \app\models\Document */

use yii\widgets\DetailView;
use yii\helpers\Html;
use app\models\Document;
use yii\helpers\Url;

$this->title = 'Документ';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => '/company'];
$this->params['breadcrumbs'][] = ['label' => $model->company->name, 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">
        <?php if ($model->status == Document::STATUS_NEW): ?>
            <?= Html::a('Сформировать', ['make', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?php if ($model->status >= Document::STATUS_READY): ?>
            <?= Html::a('Отправить', ['send', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => $model->status == Document::STATUS_SENT ? [
                    'confirm' => "Документ уже был отправлен $model->sent_at. Отправить повторно?",
                    'method' => 'post',
                ] : null]) ?>
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

