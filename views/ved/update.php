<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ved */
/* @var $company app\models\Company */

$this->title = Yii::t('app', 'Update kind of activity');
$this->params['breadcrumbs'][] = ['label' => $company->name . ': ' . Yii::t('app', 'Kinds of activity'),
    'url' => ['index', 'company_id' => $company->id]];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box">

    <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
