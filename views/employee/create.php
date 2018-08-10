<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $company app\models\Company */

$this->title = Yii::t('app', 'Create Employee');
$this->params['breadcrumbs'][] = ['label' => $company->name . ': ' . Yii::t('app', 'Employees'),
    'url' => ['index', 'company_id' => $company->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
