<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateVar */
/* @var array $varList */

$this->title = 'Изменить переменную: ' . $model->var->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Настройка шаблона ' . '"' . $model->template->name . '"',
    'url' => ['/template/edit', 'id' => $model->template_id],
];
//$this->params['breadcrumbs'][] = ['label' => $model->var_id, 'url' => ['view', 'var_id' => $model->var_id, 'template_id' => $model->template_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?= $this->render('_form', [
        'model' => $model,
        'varList' => $varList,
    ]) ?>

</div>
