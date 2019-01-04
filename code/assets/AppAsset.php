<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/app/main.js',
        'js/app/classie.js',
        'js/app/side-menu.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {

        $this->css = [
            'css/app/layout.css',
            'css/app/side-menu.css',
            'css/app/main.css',
            'css/app/factor.css',
            'css/app/materialize-colors.css',
        ];

    }
}
