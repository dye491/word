<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $company app\models\Company */

$this->title = Yii::t('app', 'Update Employee: {nameAttribute}' /*. $model->fio_ip*/, [
    'nameAttribute' => '' . $model->fio_ip,
]);
$this->params['breadcrumbs'][] = ['label' => $company->name . ': ' . Yii::t('app', 'Employees'),
    'url' => ['index', 'company_id' => $company->id]];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box-body employee-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
