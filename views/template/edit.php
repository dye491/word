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
    <?= Html::a('Добавить', ['variable/create', 'template_id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'class' => \yii\grid\SerialColumn::class,
        ],
        'name',
        'label',
        'group',
        [
            'attribute' => 'type',
            'value'     => function ($item) {
                return $item->type === 'string' ? 'строка' : $item;
            },
        ],
        [
            'class'      => \yii\grid\ActionColumn::class,
            'controller' => 'variable',
            'template'   => '{update} {delete}',
            'header'     => 'Действия',
            'options'    => ['width' => '10%'],
        ],
    ],
]) ?>

<h3>Параметры шаблона</h3>

<?= $this->render('_form', ['model' => $model]) ?>
