<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Variable */

$this->title = 'Новая переменная';
$this->params['breadcrumbs'][] = ['label' => "Список переменных", 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variable-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
//        'template' => $template,
    ]) ?>

</div>
