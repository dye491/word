<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?= GridView::widget([
        'layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterPosition' => GridView::FILTER_POS_HEADER,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => 'min-width: 33%;'],
            ],
            /*[
                'attribute' => 'employee_count',
//                'headerOptions' => ['style' => 'width: 5%;'],
            ],*/
            [
                'attribute' => 'org_form',
                'value' => function ($model) {
                    switch ($model->org_form) {
                        case 'ooo':
                            return 'ООО';
                        case 'ip':
                            return 'ИП';
                        default:
                            return null;
                    }

                },
                'filter' => [
                    'ip' => 'ИП',
                    'ooo' => 'ООО',
                ],
            ],
            [
                'attribute' => 'profile_id',
                'value' => function ($model) {
                    return $model->profile ? $model->profile->name : null;
                },
                'filter' => ArrayHelper::map(\app\models\Profile::find()->asArray()->all(), 'id', 'name'),
            ],
            [
                'label' => 'Срок действия дог.',
                'value' => function ($model) {
                    return (new DateTime($model->last_payment))
                        ->add(new DateInterval('P1Y'))
                        ->format('d.m.Y');
                },
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'last_payment',
                    'dateFormat' => 'php:d.m.Y',
                    'options' => ['class' => 'form-control'],
                ]),
            ],
            [
                'label' => 'Заполнение',
                'content' => function ($model) {
                    if ($varCount = $model->getVarsCount()) {
                        $varValuesCount = $model->getVarValuesCount();
                        $options = ['class' => 'badge'];
                        Html::addCssClass($options, ($varValuesCount == $varCount) ? 'bg-green' : 'bg-red');

                        return Html::tag('span',
                            Html::a(round(($varValuesCount * 100 / $varCount)) . '%', ['var-index', 'id' => $model->id], [
                                'style' => 'color: white;', 'data-pjax' => 0,
                                'title' => 'Редактировать значения переменных',
                                'aria-label' => 'Редактировать значения переменных',
                            ]),
                            $options);
                    }

                    return null;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => ['width' => '10%']],
//                'template' => '{var} {template} {doc} {update} {delete}',
                'template' => '{template} {doc} {set} {update} {delete}',
                'buttons' => [
                    'template' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['template-index', 'id' => $model->id],
                            ['title' => 'Шаблоны', 'aria-label' => 'Шаблоны', 'data-pjax' => '0']);
                    },
                    'var' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-at"></span>', ['var-index', 'id' => $model->id],
                            ['title' => 'Переменные', 'aria-label' => 'Переменные', 'data-pjax' => '0']);
                    },
                    'doc' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-file"></span>',
                            ['/document', 'company_id' => $key],
                            ['title' => 'Документы', 'aria-label' => 'Документы', 'data-pjax' => '0']);
                    },
                    'set' => function ($url, $model, $key) {
                        if ($model->id == \app\models\Company::getCurrent()) {
                            return '';
                        }

                        return Html::a('<span class="glyphicon glyphicon-log-in"></span>',
                            ['set', 'id' => $model->id],
                            ['title' => 'Сделать текущей', 'aria-label' => 'Сделать текущей', 'pjax' => 0]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
