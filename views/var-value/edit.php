<?php

/* @var $this yii\web\View */
/* @var $model app\models\VarValue */

$this->title = $model->company->name . ': ' . Yii::t('app', 'Edit Var Value: ') . $model->var->name;
$this->params['breadcrumbs'][] = ['label' => $model->company->name . ': Переменные', 'url' => ['company/var-index', 'id' => $model->company_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
