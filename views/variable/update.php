<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Variable */

$this->title = "Изменить переменную \"{$model->name}\"";
$this->params['breadcrumbs'][] = ['label' => "Список переменных", 'url' => ['variable']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variable-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
