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
            [
                'attribute' => 'employee_count',
//                'headerOptions' => ['style' => 'width: 5%;'],
            ],
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
                'label' => 'Заполнение',
                'content' => function ($model) {
                    return ($varCount = $model->getVarsCount()) ?
                        '<span class="badge">' . ($model->getVarValuesCount() * 100 / $varCount) . ' %</span>' :
                        null;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => ['width' => '10%']],
                'template' => '{var} {template} {update} {delete}',
                'buttons' => [
                    'template' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['template-index', 'id' => $model->id],
                            ['title' => 'Шаблоны', 'aria-label' => 'Шаблоны', 'data-pjax' => '0']);
                    },
                    'var' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-at"></span>', ['var-index', 'id' => $model->id],
                            ['title' => 'Переменные', 'aria-label' => 'Переменные', 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
