<?php
/* @var $this yii\web\View */
/* @var $model \app\models\CurrentCompanyForm */

/* @var $companies array */

use yii\widgets\ActiveForm;

$this->title = 'Текущая организация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin();
        echo $form->field($model, 'company_id')->widget(\kartik\select2\Select2::class, [
            'data' => $companies,
            'options' => ['class' => 'form-control'],
        ]);
        echo \yii\helpers\Html::submitButton('Установить', ['class' => 'btn btn-success']);
        $form = ActiveForm::end();
        ?>
    </div>
</div>
