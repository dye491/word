<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\Template */

$this->title = 'Новый шаблон';
//$this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
