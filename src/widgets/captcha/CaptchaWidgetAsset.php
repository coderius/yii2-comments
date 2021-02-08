<?php

namespace coderius\comments\widgets\captcha;

use yii\web\AssetBundle;

class CaptchaWidgetAsset extends AssetBundle{

    /**
     * @inheritdoc
     */
    public $sourcePath = (__DIR__ . '/assets');

    /**
     * @inheritdoc
     */
    public $js = [
        'coderiusCaptcha.js'
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];

}