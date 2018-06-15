<?php
/* @var $this yii\web\View */
/* @var $vars array */

/* @var $model \app\models\Template */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\TemplateUpdateAsset;

TemplateUpdateAsset::register($this);
$this->title = "Заполните переменные шаблона \"{$model->name}\"";
//$this->params['breadcrumbs'][] = ['label' => 'Список шаблонов', 'url' => '/template'];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php ActiveForm::begin(['options' => ['class' => 'form-horizontal']]) ?>
<?php foreach ($vars as $group => $items): ?>
    <?php if ($group): ?>
        <?php $first = true ?>
        <?php foreach ($items['rows'] as $rowNum => $row): ?>
            <div class="<?= $group ?>">
                <?php if (!$first) echo "<hr>\n" ?>
                <h4>Группа <?= $group ?>, cтрока <?= $rowNum + 1 ?></h4>
                <?php foreach ($row as $key => $value): ?>
                    <div class="form-group">
                        <?= Html::label($items['cols'][$key]['label'], $items['cols'][$key]['name'] . $rowNum, ['
                        class' => 'control-label col-sm-2',
                        ]) ?>
                        <div class="col-sm-10">
                            <?= Html::textInput($items['cols'][$key]['name'] . '[]', $items['rows'][$rowNum][$key], [
                                'id'    => $items['cols'][$key]['name'] . $rowNum,
                                'class' => 'form-control',
                            ]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (!$first) {
                    echo Html::a('Удалить поля', 'javascript:void(0)', [
                        'id'      => "delete-field-group-{$rowNum}",
                        'class'   => 'btn btn-danger',
                        'onclick' => "deleteFieldGroup(\"delete-field-group-{$rowNum}\")",
                        'style'   => 'margin-bottom: 15px',
                    ]);
                }
                $first = false;
                ?>
            </div>
        <?php endforeach; ?>
        <?= Html::button('Добавить поля', [
            'class'   => 'btn btn-info',
            'id'      => 'add-field-group',
            'onclick' => "addFieldGroup('" . $group . "')",
        ]) ?>
        <hr>

    <?php else: ?>
        <?php foreach ($items as $var): ?>
            <div class="form-group">
                <?= Html::label($var['label'], $var['name'], ['class' => 'control-label col-sm-2']) ?>
                <div class="col-sm-10">
                    <?= Html::textInput($var['name'], $var['values'], ['id' => $var['name'], 'class' => 'form-control']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>
<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-success',
]) ?>
<span>&nbsp;</span>
<?= Html::a('Отмена', '/template', [
    'class' => 'btn btn-default',
]) ?>
<?php ActiveForm::end() ?>
