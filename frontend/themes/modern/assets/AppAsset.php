<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\themes\modern\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/modern/web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/site.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'yii\bootstrap\BootstrapThemeAsset',
    ];
}