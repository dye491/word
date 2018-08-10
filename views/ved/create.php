<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ved */
/* @var $company app\models\Company */

$this->title = Yii::t('app', 'Create kind of activity');
$this->params['breadcrumbs'][] = ['label' => $company->name . ': ' . Yii::t('app', 'Kinds of activity'),
    'url' => ['index', 'company_id' => $company->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
