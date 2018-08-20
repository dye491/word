<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\Template */
/* @var $events array */

$this->title = 'Новый шаблон';
//$this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<h1>--><? //= $this->title ?><!--</h1>-->
<div class="box">
    <?= $this->render('_form', ['model' => $model, 'events' => $events]) ?>
</div>
