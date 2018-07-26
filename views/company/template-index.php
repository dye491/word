<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;

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
                'headerOptions' => ['style' => 'width: 5%;'],
            ],
            'name',
            [
                'label' => 'Заполнение',
                'content' => function ($tplModel) use ($model) {
                    return ($varCount = $model->getVarsCount($tplModel->id)) ?
                        '<span class="badge">' . ($model->getVarValuesCount($tplModel->id) * 100 / $varCount) . ' %</span>' :
                        null;
                },
            ],
            [
                'label' => 'Документ',
                'content' => function ($template) use ($model) {
                    $status = ($doc = $template->getDocument($model->id)) ? $doc->status : null;
                    $valArr = ['new' => 'Новый', 'ready' => 'Подготовлен', 'sent' => 'Отправлен'];
                    $val = isset($valArr[$status]) ? $valArr[$status] : null;

                    return $val ? Html::a($val, ['document/view', 'id' => $doc->id],
                        ['title' => 'Просмотр документа', 'aria-label' => 'Просмотр документа', 'data-pjax' => 0])
                        : '<span class="not-set">(не задано)</span>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 5%;'],
                'template' => '{var}',
                'buttons' => [
                    'var' => function ($url, $tplModel, $key) use ($model) {
                        return Html::a('<span class="fa fa-at"></span>',
                            ['var-index', 'id' => $model->id, 'template_id' => $tplModel->id],
                            ['title' => 'Переменные', 'aria-label' => 'Переменные', 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]) ?>
    <?php Pjax::end() ?>
</div>
