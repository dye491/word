<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\Template */
/* @var $events array */
/* @var $branches array */

$this->title = 'Новый шаблон';
$this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <?= $this->render('_form', ['model' => $model, 'events' => $events, 'branches' => $branches]) ?>
</div>
