<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Variable */
/* @var $template app\models\Template */

$this->title = "Изменить переменную \"{$model->name}\"";
//$this->params['breadcrumbs'][] = ['label' => 'Variables', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => "Настройка шаблона \"{$template->name}\"",
    'url'   => [
        'template/edit', 'id' => $template->id,
    ],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variable-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'    => $model,
        'template' => $template,
    ]) ?>

</div>
