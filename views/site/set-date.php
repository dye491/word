<?php
/* @var $this yii\web\View */

/* @var $model \app\models\CurrentDateForm */

use yii\widgets\ActiveForm;

$this->title = 'Установить дату';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin();
        echo $form->field($model, 'curDate')->widget(\kartik\date\DatePicker::class, [
            'pluginOptions' => ['autoclose' => true],
        ]);
        echo \yii\helpers\Html::submitButton('Установить', ['class' => 'btn btn-success']);
        ActiveForm::end();
        ?>
    </div>
</div>
