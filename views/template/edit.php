<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $model \app\models\Template */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = "Настройка шаблона \"{$model->name}\"";
//$this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => '/template'];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<h3>Переменные шаблона</h3>
<p>
    <?= Html::a('Добавить', ['template-var/create', 'template_id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => \yii\grid\SerialColumn::class,
        ],
        'var.name',
        'var.label',
        'var.group',
        [
            'attribute' => 'start_date',
            'value' => function ($model) {
                return $model->start_date ?
                    Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') :
                    $model->start_date;
            },
        ],
        [
            'attribute' => 'end_date',
            'value' => function ($model) {
                return $model->end_date ?
                    Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') :
                    $model->end_date;
            },
        ],
        [
            'attribute' => 'type',
            'label' => 'Тип',
            'value' => function ($model) {
                return $model->var->type === 'string' ? 'строка' : $model;
            },
        ],
        [
            'class' => \yii\grid\ActionColumn::class,
            'controller' => 'template-var',
            'template' => '{update} {delete}',
            'header' => 'Действия',
            'options' => ['width' => '10%'],
        ],
    ],
]) ?>

<h3>Параметры шаблона</h3>

<?= $this->render('_form', ['model' => $model]) ?>
