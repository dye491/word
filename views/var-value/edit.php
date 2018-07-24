<?php

//use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VarValue */

$this->title = $model->company->name . ': ' . Yii::t('app', 'Edit Var Value: ') . $model->var->name;
$this->params['breadcrumbs'][] = ['label' => $model->company->name . ': Переменные', 'url' => ['company/var-index', 'id' => $model->company_id]];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
