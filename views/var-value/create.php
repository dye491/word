<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VarValue */

$this->title = Yii::t('app', 'Create Var Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Var Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="var-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
