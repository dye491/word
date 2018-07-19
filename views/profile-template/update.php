<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileTemplate */

$this->title = Yii::t('app', 'Update Profile Template: ' . $model->profile_id, [
    'nameAttribute' => '' . $model->profile_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile_id, 'url' => ['view', 'profile_id' => $model->profile_id, 'template_id' => $model->template_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="profile-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'templates' => $templates,
    ]) ?>

</div>
