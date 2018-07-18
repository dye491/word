<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $profiles array */

$this->title = 'Новая организация';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'profiles' => $profiles,
    ]) ?>

</div>
