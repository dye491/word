<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileTemplate */
/* @var $form yii\widgets\ActiveForm */
/* @var $templates array */
?>

<div class="profile-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--    --><? //= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'template_id')->dropDownList($templates) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['/profile/view', 'id' => $model->profile_id],
            ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
