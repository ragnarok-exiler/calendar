<?php

namespace app\modules\gestion;

use Yii;

/**
 * gestion module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\gestion\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * Registers a CSS file from module.
     *
     * @param $filename
     * @param array $options the HTML attributes for the link tag. Please refer to [[Html::cssFile()]] for
     * the supported options. The following options are specially handled and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this CSS file depends on.
     *
     * @param string $key the key that identifies the CSS script file. If null, it will use
     * $url as the key. If two CSS files are registered with the same key, the latter
     * will overwrite the former.
     */
    public function registerCssFile($filename, $options = [], $key = null)
    {
        $file = $this->basePath . DIRECTORY_SEPARATOR . "web/css/" . $filename;
        Yii::$app->getAssetManager()->publish($file);
        $url = Yii::$app->getAssetManager()->getPublishedUrl($file, $options, $key);
        Yii::$app->view->registerCssFile($url);
    }

    /**
     * Registers a JS file from module.
     *
     * @param $filename
     * @param string $url the JS file to be registered.
     * @param array $options the HTML attributes for the script tag. The following options are specially handled
     * and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this JS file depends on.
     * - `position`: specifies where the JS script tag should be inserted in a page. The possible values are:
     *     * [[POS_HEAD]]: in the head section
     *     * [[POS_BEGIN]]: at the beginning of the body section
     *     * [[POS_END]]: at the end of the body section. This is the default value.
     *
     * Please refer to [[Html::jsFile()]] for other supported options.
     *
     * @param string $key the key that identifies the JS script file. If null, it will use
     * $url as the key. If two JS files are registered with the same key at the same position, the latter
     * will overwrite the former. Note that position option takes precedence, thus files registered with the same key,
     * but different position option will not override each other.
     */
    public function registerJsFile($filename, $options = [], $key = null)
    {
        $file = $this->basePath . DIRECTORY_SEPARATOR . "web/js/" . $filename;
        Yii::$app->getAssetManager()->publish($file);
        $url = Yii::$app->getAssetManager()->getPublishedUrl($file, $options, $key);
        Yii::$app->view->registerCssFile($url);

    }
}
