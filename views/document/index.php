<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $company \app\models\Company */

use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $company->name . ': Документы';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => '/company'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <?php
    Pjax::begin();
    echo GridView::widget(['layout' => '<div class="box-body no-padding table-responsive">{items}</div><div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header' => '№',
                'headerOptions' => ['style' => 'width: 5%;'],
            ],
            'template.name',
            'date',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    $arr = [
                        'new' => 'Новый',
                        'ready' => 'Подготовлен',
                        'sent' => 'Отправлен',
                    ];

                    return $arr[$model->status];
                },
            ],
            'sent_at',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view}',
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>

