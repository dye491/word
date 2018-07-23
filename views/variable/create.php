<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Variable */

$this->title = 'Новая переменная';
$this->params['breadcrumbs'][] = ['label' => "Список переменных", 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
