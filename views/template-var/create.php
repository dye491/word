<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TemplateVar */
/* @var $varList array */

$this->title = 'Новая переменная';
$this->params['breadcrumbs'][] = [
    'label' => 'Настройка шаблона ' . '"' . $model->template->name . '"',
    'url' => ['/template/edit', 'id' => $model->template_id],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-var-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'varList' => $varList,
    ]) ?>

</div>
