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
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'employee_count',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
