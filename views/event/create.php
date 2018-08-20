<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = 'Новое событие';
$this->params['breadcrumbs'][] = ['label' => 'Внешние события', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box event-create">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
