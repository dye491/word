<?php

/* @var $this yii\web\View */
/* @var $values app\models\VarValue[] */
/* @var $company app\models\Company */

$this->title = $company->name . ': ' . Yii::t('app', 'Edit Var Values');
$this->params['breadcrumbs'][] = ['label' => $company->name . ': Переменные', 'url' => ['company/var-index', 'id' => $company->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?= $this->render('_form', [
        'values' => $values,
    ]) ?>

</div>
