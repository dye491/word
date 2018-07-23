<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProfileTemplate */
/* @var $templates array */

$this->title = Yii::t('app', 'Add Template');
$this->params['breadcrumbs'][] = ['label' => $model->profile->name . ': доступные шаблоны', 'url' => ['/profile/view', 'id' => $model->profile_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'templates' => $templates,
    ]) ?>

</div>
