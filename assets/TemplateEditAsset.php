<?php
namespace app\assets;

use yii\web\AssetBundle;

class TemplateEditAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/template/edit.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}