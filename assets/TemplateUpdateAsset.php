<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 08.06.18
 * Time: 10:56
 */

namespace app\assets;


use yii\web\AssetBundle;

class TemplateUpdateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/template/update.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}